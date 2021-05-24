<?php


namespace App\Services;


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

        if ($result) {
            $this->addToRejectHistory($request);
            return response()->json([
                'message' => 'Чек отклонен',
                'success' => (bool)true
            ]);
        } else {
            return response()->json([
                'message' => 'Что-то пошло не так, попробуйте позже',
                'success' => (bool)false
            ]);
        }
    }

    public function checkApprove(CheckApproveRequest $request)
    {
        $requestParams = $request->except(['image', 'user_id']);

        $result = (bool)$this->client->send('Cashback/Moderator/accept', $requestParams);
        if ($result) {
            $this->addToApproveHistory($request);
            return response()->json([
                'message' => 'Чек принят',
                'success' => (bool)true
            ]);
        } else {
            return response()->json([
                'message' => 'Что-то пошло не так, попробуйте позже',
                'success' => (bool)false
            ]);
        }
    }

    public function  ($request)
    {
        $params = $request->all();
        $list = $this->client->send('Cashback/Moderator/getPurchaseList', $params);
        return response()->json($list->items);
    }

    private function addToRejectHistory($request)
    {
        $user = User::byUserId($request->user_id)->first();
        $result = [
            'user_id' => $user->user_id,
            'check_id' => $request->id,
            'status' => 'REJECTED',
            'comment' => $request->comment,
            'image' => $request->image,
        ];
        $check = new CheckHistory($result);
        $check->save();
    }

    private function addToApproveHistory(CheckApproveRequest $request)
    {
        $user = User::byUserId($request->user_id)->first();

        $result = [
            'user_id' => $user->user_id,
            'check_id' => $request->id,
            'status' => 'APPROVED',
            'image' => $request->image,
        ];
        $check = new CheckHistory($result);
        $check->save();
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
