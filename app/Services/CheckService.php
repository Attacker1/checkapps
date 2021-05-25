<?php


namespace App\Services;

use App\Enum\CheckHistoryStatusEnum;
use App\Models\Check;
use App\Models\Setting;
use Exception;
use App\Models\User;
use App\Models\CheckHistory;
use Illuminate\Http\Request;
use App\Client\JsonRpcClient;
use App\Enum\CheckStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\CheckApproveRequest;
use App\Http\Requests\PurchaseListRequest;
use Illuminate\Support\Facades\Log;

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

        $addedToReject = $this->addToRejectHistory($request);
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
        $requestParams = $request->except(['image', 'user_id']);
        $result = $this->client->send('Cashback/Moderator/accept', $requestParams);

        if (isset($result->error)) {
            return $result;
        }

        if ($result) {
            $addedToApprove = $this->addToApproveHistory($request);
            if (!isset($addedToApprove->error)) {
                return (object)[
                    'message' => 'Чек принят',
                    'success' => (bool)true
                ];
            } else {
                return $addedToApprove;
            }
        } else {
            return (object)[
                'message' => 'Что-то пошло не так, попробуйте позже',
                'success' => (bool)false
            ];
        }
    }

    private function addToRejectHistory($request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $reward = Setting::query()->where(['slug', 'check_verify_price'])->first()->value;

            if (!$reward) {
                throw new Exception('Не найдено такой настройки', 404);
            }


            $result = [
                'user_id' => $user->user_id,
                'check_id' => $request->id,
                'status' => CheckHistoryStatusEnum::REJECTED,
                'comment' => $request->comment,
                'reward' => $reward,
            ];

            $check = new CheckHistory($result);
            return $check->save();

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

    private function addToApproveHistory(CheckApproveRequest $request)
    {
        try {
            $user = User::find($request->user_id)->first();
            if (!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $result = [
                'user_id' => $user->user_id,
                'check_id' => $request->id,
                'status' => 'APPROVED',
                'image' => $request->image,
            ];
            $check = new CheckHistory($result);
            $check->save();
        } catch (Exception $e) {
            return (object)[
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
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
