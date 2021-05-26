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

    /**
     * @OA\GET(
     *     path="/api/check-histories",
     *     summary="Позволяет получить историю чеков пользователя",
     *     description="Позволяет получить список чеков пользователя. Параметры не обязательны, по умолчанию user_id - это текущий пользователь, а paginate - 20",
     *     operationId="check-histories",
     *     tags={"User"},
     *     security={ {"passport": {} }},
     *     @OA\Parameter(
     *         description="Позволяет получить историю чеков определенного пользователя по его ID",
     *         in="query",
     *         name="user_id",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         description="Определяет количество чеков на одной странице",
     *         in="query",
     *         name="paginate",
     *         required=false,
     *         example="3",
     *     ),
     *     @OA\Parameter(
     *         description="Номер запрашиваемой страницы",
     *         in="query",
     *         name="page",
     *         required=false,
     *         example="1",
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
     *         response=401,
     *         description="Вылетает если запрос не авторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="user_id", type="number"),
     *             @OA\Property(property="check_id", type="number"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="reward", type="number"),
     *             @OA\Property(property="comment", type="null|string"),
     *             @OA\Property(property="created_at", type="string", format="date-format", description="Date this interaction was created"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="check_id", type="number"),
     *                 @OA\Property(property="image", type="string"),
     *                 @OA\Property(property="amount", type="number"),
     *                 @OA\Property(property="amount_in_currency", type="number"),
     *                 @OA\Property(property="currency", type="string"),
     *                 @OA\Property(property="verify_quantity", type="number"),
     *                 @OA\Property(property="current_quantity", type="number"),
     *                 @OA\Property(property="status", type="string"),
     *                 @OA\Property(property="check_user_id", type="null|number"),
     *             ),
     *         )
     *     )
     * )
     */
    public function checkHistories(Request $request)
    {
        $userID = $request->user_id ?? $request->user()->id;
        $paginate = $request->paginate ?? 20;

        return response()->json($this->userService->checkHistories($userID, $paginate));
    }
}
