<?php

namespace App\Http\Controllers\Auth;

use App\Models\Setting;
use App\Services\LoginService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     description="Login",
     *     operationId="login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"login","password"},
     *             @OA\Property(property="login", type="string", format="email", example="user1@mail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="404 response",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer"),
     *             @OA\Property(property="error", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="expires_at", type="string"),
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="token_type", type="string"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="career_id", type="null|number"),
     *                 @OA\Property(property="referer_user_fio", type="null|string"),
     *                 @OA\Property(property="referer_user_id", type="null|number"),
     *                 @OA\Property(property="token_id", type="string"),
     *                 @OA\Property(property="user_email", type="string"),
     *                 @OA\Property(property="user_fio", type="string"),
     *                 @OA\Property(property="user_id", type="number"),
     *                 @OA\Property(property="user_phone", type="string"),
     *             ),
     *         )
     *     )
     * )
     */
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

        return isset($response->error) ? response()->json($response, 404) : response()->json($response);
    }
}
