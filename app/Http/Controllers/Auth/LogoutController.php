<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\LogoutService;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    protected $logoutService;

    public function __construct(LogoutService $logoutService)
    {
        $this->logoutService = $logoutService;
    }

    public function __invoke(Request $request)
    {
        return $this->logoutService->logout($request);
    }
}
