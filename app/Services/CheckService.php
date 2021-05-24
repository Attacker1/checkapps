<?php


namespace App\Services;


use App\Client\JsonRpcClient;
use App\Http\Requests\CheckApproveRequest;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\PurchaseListRequest;
use App\Models\CheckHistory;
use App\Models\User;

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

    public function getPurchaseListItems($request)
    {
        $params = $request->all();
        $list = $this->client->send('Cashback/Moderator/getPurchaseList', $params);
        return response()->json($list->items);
    }

    private function addToRejectHistory($request)
    {
        $user = User::find($request->user_id)->first();
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
        $user = User::find($request->user_id)->first();


        $result = [
            'user_id' => $user->user_id,
            'check_id' => $request->id,
            'status' => 'APPROVED',
            'image' => $request->image,
        ];
        $check = new CheckHistory($result);
        $check->save();
    }
}
