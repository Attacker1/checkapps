<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(UserRequest $request)
    {
       return $this->authService->login($request);
    }
}
