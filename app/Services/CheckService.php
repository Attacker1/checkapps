<?php


namespace App\Services;


use App\Enum\CheckStatusEnum;
use App\Models\Check;
use Exception;
use App\Models\User;
use App\Models\CheckHistory;
use App\Client\JsonRpcClient;
use Illuminate\Http\Request;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\CheckApproveRequest;
use App\Http\Requests\PurchaseListRequest;

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

    public function checkReject(CheckRejectRequest $request)
    {
        $requestParams = $request->except(['image', 'user_id']);
        $result = (bool)$this->client->send('Cashback/Moderator/reject', $requestParams);

        if (isset($result->error)) {
            return $result;
        }

        if ($result) {
            $addedToReject = $this->addToRejectHistory($request);
            if (!isset($addedToReject->error)) {
                return (object)[
                    'message' => 'Чек отклонен',
                    'success' => (bool)true
                ];
            } else {
                return $addedToReject;
            }
        } else {
            return (object)[
                'message' => 'Что-то пошло не так, попробуйте позже',
                'success' => (bool)false
            ];
        }
    }

    public function checkApprove(CheckApproveRequest $request)
    {
        $requestParams = $request->except(['image', 'user_id']);
        $result = (bool)$this->client->send('Cashback/Moderator/accept', $requestParams);

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

    public function getPurchaseListItems($request)
    {
        $params = $request->all();
        $list = $this->client->send('Cashback/Moderator/getPurchaseList', $params);
        return response()->json($list->items);
    }

    private function addToRejectHistory($request)
    {
        try {
            $user = User::find($request->user_id)->first();
            if (!$user) {
                throw new Exception('Пользователь не найден', 404);
            }

            $result = [
                'user_id' => $user->user_id,
                'check_id' => $request->id,
                'status' => 'REJECTED',
                'comment' => $request->comment,
                'image' => $request->image,
            ];

            $check = new CheckHistory($result);
            $check->save();

        } catch (Exception $e) {
            return (object)[
                'message' => $e->getMessage(),
                'error' => $e->getCode()
            ];
        }
    }

    public function getChecks($request)
    {
        $user = $request->user();

        return Check::query()->where([
            ['status', CheckStatusEnum::INCHECK],
            ['check_user_id', null]
        ])->limit(50)->orderByDesc('current_quantity')->update(['check_user_id' => $user->id]);

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
                'message' => $e->getMessage(),
                'error' => $e->getCode()
            ];
        }
    }

    public function addChecks($checks)
    {
        // try {
        //     if(!is_array($checks)) {
        //         throw new Exception('Переданный параметр не является массивом', 404);
        //     }


        //    return $checks;
        // } catch (Exception $exception) {
        //     return response()->json([
        //         'code' => $exception->getCode(),
        //         'message' => $exception->getMessage(),
        //     ], $exception->getCode());
        // }
    }

    public function addCheck($check)
    {
        # code...
    }
}
