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
        $requestParams = $request->except('image');

        $result = (bool)$this->client->send('Cashback/Moderator/accept', $requestParams);
        if ($result) {
            $this->addToRejectHistory($request);
            return response()->json([
                'message' => 'Чек отправлен в неисправные',
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Что-то пошло не так, попробуйте позже',
                'success' => false
            ]);
        }
    }

    public function checkApprove(CheckApproveRequest $request)
    {
        $requestParams = $request->except('image');

        $result = (bool)$this->client->send('Cashback/Moderator/accept', $requestParams);
        if ($result) {
            $this->addToApproveHistory($request);
            return response()->json([
                'message' => 'Чек отправлен в исправные',
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Что-то пошло не так, попробуйте позже',
                'success' => false
            ]);
        }
    }

    public function getPurchaseListItem($request)
    {
        $params = $request->all();
        $list = $this->client->send('Cashback/Moderator/getPurchaseList', $params);
        return response()->json($list->items[0]);
    }

    private function addToRejectHistory(CheckRejectRequest $request)
    {
        $user = User::byTokenId($request->only('token_id'));

        $result = [
            'user_id' => $user->user_id,
            'check_id' => $request->only('id'),
            'status' => 'REJECTED',
            'comment' => $request->only('comment'),
            'image' => $request->only('image'),
        ];
        $check = new CheckHistory($result);
        $check->save();
    }

    private function addToApproveHistory(CheckApproveRequest $request)
    {
        $user = User::byTokenId($request->only('token_id'));

        $result = [
            'user_id' => $user->user_id,
            'check_id' => $request->only('id'),
            'status' => 'APPROVED',
            'image' => $request->only('image'),
        ];
        $check = new CheckHistory($result);
        $check->save();
    }
}
