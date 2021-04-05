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
        return $this->checkService->checkReject($request);
    }

    public function approve(CheckApproveRequest $request)
    {
        return $this->checkService->checkApprove($request);
    }

    public function getPurchaseListItems(PurchaseListRequest $request)
    {
        return $this->checkService->getPurchaseListItems($request);
    }
}
