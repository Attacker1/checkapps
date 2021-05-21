<?php

namespace App\Http\Controllers\Auth;

use App\Services\LoginService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Обработка попытки аутентификации.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        $response = $this->loginService->login($request);

        return isset($response->errors) ? response()->json($response, 404) : response()->json($response);
    }
}
