<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="User",
     *     description="User",
     *     operationId="user",
     *     tags={"User"},
     *     security={ {"passport": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="user_fio", type="string"),
     *             @OA\Property(property="user_email", type="string"),
     *             @OA\Property(property="balance", type="string"),
     *         )
     *    )
     * )
     */
    public function user(Request $request)
    {
        return response()->json($this->userService->user($request));
    }
}
