<?php


namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Services\Admin\LoginService;
use Exception;

class AdminService
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request)
    {
        return $this->loginService->__invoke($request);
    }
}
