<?php


namespace App\Services;

use App\Enum\CheckHistoryStatusEnum;
use App\Events\CheckVerified;
use App\Models\Check;
use App\Models\Setting;
use Exception;
use App\Models\User;
use App\Models\CheckHistory;
use App\Client\JsonRpcClient;
use App\Enum\CheckStatusEnum;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\CheckApproveRequest;

class CheckService
{
    protected $client;

    /**
     * CheckService constructor.
     * @param $client
     */
    public function __construct(JsonRpcClient $client)
    {
        $this->client = $client;
    }

    public function getChecksFromApi($params)
    {
        try {
            if (!$params) {
                throw new Exception('Не удалось получить доступ к чекам, не переданы необходимые параметры', 404);
            }

            $list = $this->client->send('Cashback/Moderator/getPurchaseList', $params);

            if (isset($list->error)) {
                throw new Exception($list->message, $list->code);
            }

            return $list;
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function checkReject(CheckRejectRequest $request)
    {
//        $result = $this->client->send('Cashback/Moderator/reject', $requestParams);

        $addedToReject = $this->addCheckToHistory($request);
        if (!isset($addedToReject->error)) {
            return (object)[
                'message' => 'Чек отклонен',
                'success' => (bool)true
            ];
        } else {
            return $addedToReject;
        }
    }

    public function checkApprove(CheckApproveRequest $request)
    {
//        $result = $this->client->send('Cashback/Moderator/accept', $requestParams);
        $addedToApprove = $this->addCheckToHistory($request);
        if (!isset($addedToApprove->error)) {
            return (object)[
                'message' => 'Чек принят',
                'success' => (bool)true
            ];
        } else {
            return $addedToApprove;
        }
    }

    private function addCheckToHistory($request)
    {
        $hasComment = $request->has('comment');

        try {
            $user = $request->user();
            if (!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $reward = Setting::settingBySlug('check_verify_price')->first()->value;

            if (!$reward) {
                throw new Exception('Не найдено такой настройки в базе', 404);
            }


            $result = [
                'user_id' => $user->user_id,
                'check_id' => $request->check_id,
                'status' => $hasComment ? CheckHistoryStatusEnum::REJECTED : CheckHistoryStatusEnum::APPROVED,
                'comment' => $hasComment ? $request->comment : null,
                'reward' => $reward,
            ];

            $check = new CheckHistory($result);
            $success = $check->save();
            if (!$success) {
                throw new Exception('Не получилось проверить чек', 404);
            }
            /* Здесь добавляем события, которые должны происходить после проверки чека */
            event(new CheckVerified($user, $check));
        } catch (Exception $e) {
            return (object)[
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function getUniqueChecks($limit = 50, $check_user_id = null)
    {
        return Check::query()->where([
            ['status', CheckStatusEnum::INCHECK],
            ['check_user_id', $check_user_id]
        ])->limit($limit)->orderByDesc('current_quantity');
    }

    public function getChecks($request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new Exception('Пользователь не найден', 404);
            }
            /* Очищаем чеки перед тем, как их раздать, чтобы всегда было занято максимум 50 одним пользователем */
            $this->resetUserChecks($user->id);

            $checks = $this->getUniqueChecks();

            $checks->update(['check_user_id' => $user->id]);

            return (object)$checks->get();
        } catch (Exception $e) {
            return (object)[
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function resetUserChecks($userID)
    {
        $userChecks = $this->getUniqueChecks(-1, $userID);
        if ($userChecks) {
            $userChecks->update(['check_user_id' => null]);
        }
    }

    public function addChecks($checks)
    {
        try {
            if (empty($checks->items)) {
                throw new Exception('Нет чеков для проверки', 404);
            }

            $addedChecksIDs = [];
            $setting = Setting::query()->where('slug', 'check_verify_quantity')->first();
            if (!$setting) {
                $verifyQuantity = 5;
            } else {
                $verifyQuantity = $setting->value;
            }

            foreach ($checks->items as $check) {
                $addedCheckID = $this->addCheck($check, $verifyQuantity);

                if (!isset($addedCheckID->error)) {
                    $addedChecksIDs[] = $addedCheckID;
                }
            }

            return $addedChecksIDs;
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function addCheck($rawCheck, $verifyQuantity)
    {
        try {
            if (empty($rawCheck)) {
                throw new Exception('Чек не передан', 404);
            }

            $check = new Check();
            $check->check_id = $rawCheck->id;
            $check->image = $rawCheck->receipt;
            $check->amount = $rawCheck->amount;
            $check->amount_in_currency = $rawCheck->amount_in_currency;
            $check->dt = date('Y-m-d H:i:s', strtotime($rawCheck->dt));
            $check->dt_purchase = date('Y-m-d H:i:s', strtotime($rawCheck->dt_purchase));
            $check->currency = $rawCheck->currency;
            $check->verify_quantity = $verifyQuantity;
            $check->current_quantity = 0;
            $check->status = CheckStatusEnum::INCHECK;

            $success = $check->save();

            if ($success) {
                return $check->check_id;
            } else {
                throw new Exception('Ошибка при добавлении чека', 500);
            }

        } catch (Exception $exception) {
            return [
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }
}
