<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckApproveRequest;
use App\Http\Requests\CheckRejectRequest;
use App\Http\Requests\PurchaseListRequest;
use App\Services\CheckService;
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

    public function getPurchaseListItems(PurchaseListRequest $request)
    {
        return $this->checkService->getPurchaseListItems($request);
    }

    public function getChecks(Request $request)
    {
        $response = $this->checkService->getChecks($request);
        return response()->json($response);
    }
}
