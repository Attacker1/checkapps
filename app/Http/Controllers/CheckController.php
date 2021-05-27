<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckApproveRequest;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\PurchaseListRequest;
use App\Services\CheckService;
use DebugBar\DebugBar;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    protected $checkService;

    /**
     * CheckController constructor.
     * @param $checkService
     */
    public function __construct(CheckService $checkService)
    {
        $this->checkService = $checkService;
    }

    public function reject(CheckRejectRequest $request)
    {
        $response = $this->checkService->checkReject($request);
        return response()->json($response);
    }

    public function approve(CheckApproveRequest $request)
    {
        $response = $this->checkService->checkApprove($request);
        return response()->json($response);
    }

    public function skipCheck(Request $request)
    {
        $response = $this->checkService->skipCheck($request);
        return response()->json($response, $response->code ?? 200);
    }

    public function getChecks(Request $request)
    {
        $response = $this->checkService->getChecks($request);
        $errors = isset($response->error);

        return response()->json($response);
    }

    public function resetChecks(Request $request)
    {
        $user = $request->user();
        $this->checkService->resetUserChecks($user->user_id);
        return response()->json(['message' => 'Чеки успешно очищены в базе']);
    }
}
