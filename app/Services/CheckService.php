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
use App\Enum\PermissionsEnum;
use App\Enum\SettingSlugEnum;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\CheckApproveRequest;
use App\Repositories\CheckRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;

class CheckService
{
    protected $client;
    protected $checkRepository;

    /**
     * CheckService constructor.
     * @param $client
     */
    public function __construct()
    {
        $this->client = new JsonRpcClient();
        $this->checkRepository = new CheckRepository();
    }

    public function getChecksFromApi($params)
    {
        try {
            if (!$params) {
                throw new Exception('Не удалось получить доступ к чекам, не переданы необходимые параметры', 404);
            }

            $list = $this->client->send('Cashback/Moderator/getPurchaseList', $params);

            if (isset($list->error)) {
                throw new Exception($list->error, $list->code);
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
        try {
            $canVerify = Gate::check(PermissionsEnum::CAN_VERIVY_CHECKS['slug']);

            if ($canVerify === false) {
                throw new Exception('У вас нет прав для проверки чеков', 403);
            }

            $hasComment = $request->has('comment');

            $user = $request->user();
            if (!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $reward = Setting::settingBySlug(SettingSlugEnum::CHECK_VERIFY_PRICE)->first()->value;

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


            $checkHistory = new CheckHistory($result);
            $success = $checkHistory->save();
            if (!$success) {
                throw new Exception('Не получилось проверить чек', 404);
            }

            event(new CheckVerified($user, $checkHistory));
        } catch (QueryException $exception) {
            if ((int)$exception->getCode() === 23000) {
                return (object)[
                    'error' => 'Данный чек уже проверен вами, пропустите его',
                    'code' => 500
                ];
            }

            return (object)[
                'error' => 'Ошибка',
                'code' => 500
            ];
        } catch (Exception $e) {
            return (object)[
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function getChecks($request)
    {
        try {
            $canVerify = Gate::check(PermissionsEnum::CAN_VERIVY_CHECKS['slug']);

            if ($canVerify === false) {
                throw new Exception('У вас нет прав для проверки чеков', 403);
            }

            $user = $request->user();

            /**
             * Очищаем чеки перед тем, как их раздать, чтобы всегда было занято максимум 50 одним пользователем
             */
            $this->resetUserChecks($user->user_id);

            $checks = $this->checkRepository->getUniqueToUserChecks($user)->get();

            $this->setUserToCheck($user, $checks->pluck('check_id'));

            return $checks;
        } catch (Exception $e) {
            return (object)[
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    public function resetUserChecks($userID)
    {
        $userChecks = Check::query()->where([
            ['status', CheckStatusEnum::INCHECK],
            ['check_user_id', $userID]
        ])->orderByDesc('current_quantity');

        $this->resetChecks($userChecks);
    }

    public function addChecks($checks)
    {
        try {
            if (empty($checks->items)) {
                throw new Exception('Нет чеков для проверки', 404);
            }

            $addedChecksIDs = [];
            $setting = Setting::query()->where('slug', SettingSlugEnum::CHECK_VERIFY_QUANTITY)->first();
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

    public function skipCheck($request)
    {
        try {
            $check = Check::query()->where('check_id', $request->check_id)->first();
            $check->setAttribute('check_user_id', null);
            $success = $check->save();
            if (!$success) {
                throw new Exception('Что-то пошло не так', 500);
            }

            return  (object) [
                'message' => 'Чек пропущен',
                'success' => (bool)true,
            ];
        } catch (Exception $e) {
            return (object) [
                'code' => $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }
    }

    public function resetChecks(Builder $checks)
    {
        $checks->update(['check_user_id' => null]);
    }

    public function setUserToCheck(User $user, $checks) {
        $checks = Check::query()->whereIn('check_id', $checks);
        $checks->update(['check_user_id' => $user->user_id]);
    }
}
