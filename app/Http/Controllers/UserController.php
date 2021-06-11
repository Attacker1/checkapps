<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\ManagePermissionsRequest;

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
        $user_id = $request->user()->user_id;
        $response = $this->userService->user($user_id);

        return response()->json($response, isset($response->error) ? $response->code : 200);
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

    /**
     * @OA\GET(
     *     path="/api/users",
     *     summary="Позволяет получить всех пользователей с пагинацией",
     *     description="Позволяет получить всех пользователей с пагинацией. Параметры не обязательны, по умолчанию paginate = 20, а filter = DESC",
     *     operationId="users",
     *     tags={"Users"},
     *     security={ {"passport": {} }},
     *     @OA\Parameter(
     *         description="Определяет количество пользователей на одной странице",
     *         in="query",
     *         name="paginate",
     *         required=false,
     *         example="20",
     *     ),
     *     @OA\Parameter(
     *         description="Номер запрашиваемой страницы",
     *         in="query",
     *         name="page",
     *         required=false,
     *         example="1",
     *     ),
     *     @OA\Parameter(
     *         description="Фильтр пользователей по активности DESC - самые активные, ASC - самые неактивные",
     *         in="query",
     *         name="filter",
     *         required=false,
     *         example="DESC",
     *     ),
     *     @OA\Parameter(
     *         description="По какому полю искать пользователя user_fio - ФИО, user_email - email. Если будет использоваться поиск, то этот параметр обязателен",
     *         in="query",
     *         name="searchBy",
     *         required=false,
     *         example="user_fio",
     *     ),
     *     @OA\Parameter(
     *         description="Поисковый запрос",
     *         in="query",
     *         name="s",
     *         required=false,
     *         example="Никита",
     *     ),
     *     @OA\Parameter(
     *         description="Искать среди забаненых или незабаненых пользователей, если не указать, то будет искать среди всех. Принимаемые зачения true, false",
     *         in="query",
     *         name="isBanned",
     *         required=false,
     *         example="true",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Вылетает если запрос не авторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Вылетает если у пользователя не прав для этого метода",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="user_id", type="number"),
     *             @OA\Property(property="user_fio", type="string"),
     *             @OA\Property(property="user_email", type="string"),
     *             @OA\Property(property="user_phone", type="string"),
     *             @OA\Property(property="balance", type="number"),
     *             @OA\Property(property="check_history_count", type="number"),
     *         )
     *     )
     * )
     */
    public function users(Request $request)
    {
        return response()->json($this->userService->users($request->paginate, $request->filter, $request->s, $request->searchBy, $request->isBanned));
    }

    /**
     * @OA\GET(
     *     path="/api/users/{user_id}",
     *     summary="Позволяет получить определенного пользователя по user_id",
     *     description="Позволяет получить определенного пользователя по user_id",
     *     operationId="getUser",
     *     tags={"Users"},
     *     security={ {"passport": {} }},
     *     @OA\Parameter(
     *         description="user id",
     *         in="path",
     *         name="user_id",
     *         required=true,
     *         example="513753",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Вылетает если запрос не авторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Вылетает если у пользователя не прав для этого метода",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number"),
     *             @OA\Property(property="user_id", type="number"),
     *             @OA\Property(property="user_fio", type="string"),
     *             @OA\Property(property="user_email", type="string"),
     *             @OA\Property(property="user_phone", type="string"),
     *             @OA\Property(property="balance", type="number"),
     *             @OA\Property(property="isAdmin", type="boolean"),
     *             @OA\Property(property="check_history_count", type="number"),
     *             @OA\Property(property="rejected_checks_count", type="number"),
     *             @OA\Property(property="approved_checks_count", type="number"),
     *             @OA\Property(property="permissions", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="slug", type="string"),
     *                     @OA\Property(property="name", type="string"),
     *                 )
     *             ),
     *         )
     *     )
     * )
     */
    public function getUser($user_id)
    {
        $response = $this->userService->user($user_id, true);

        return response()->json($response, isset($response->error) ? $response->code : 200);
    }

    /**
     * @OA\GET(
     *     path="/api/users/{user_id}/block",
     *     summary="Позволяет заблокировать определенного пользователя по user_id, если есть на это право у текущего пользователя",
     *     description="Позволяет заблокировать определенного пользователя по user_id, если есть на это право у текущего пользователя",
     *     operationId="blockUser",
     *     tags={"Users"},
     *     security={ {"passport": {} }},
     *     @OA\Parameter(
     *         description="user id",
     *         in="path",
     *         name="user_id",
     *         required=true,
     *         example="513753",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Вылетает если запрос не авторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Вылетает если запрашиваемый пользователь не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Вылетает если у пользователя не прав для этого метода",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     )
     * )
     */
    public function blockUser($user_id)
    {
        $response = $this->userService->blockUser($user_id);

        return response()->json($response, isset($response->error) ? $response->code : 200);
    }

    /**
     * @OA\GET(
     *     path="/api/users/{user_id}/unblock",
     *     summary="Позволяет разблокировать определенного пользователя по user_id, если есть на это право у текущего пользователя",
     *     description="Позволяет разблокировать определенного пользователя по user_id, если есть на это право у текущего пользователя",
     *     operationId="unblockUser",
     *     tags={"Users"},
     *     security={ {"passport": {} }},
     *     @OA\Parameter(
     *         description="user id",
     *         in="path",
     *         name="user_id",
     *         required=true,
     *         example="513753",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Вылетает если запрос не авторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Вылетает если запрашиваемый пользователь не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Вылетает если у пользователя не прав для этого метода",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully response",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     )
     * )
     */
    public function unblockUser($user_id)
    {
        $response = $this->userService->unblockUser($user_id);

        return response()->json($response, isset($response->error) ? $response->code : 200);
    }

    /**
     * @OA\Post(
     *     path="/api/users/manage-permissions",
     *     summary="Позволяет менять разрешения для пользователя",
     *     description="Позволяет менять разрешения для пользователя",
     *     operationId="managePermissions",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Изменить разрешения",
     *         @OA\JsonContent(
     *             required={"user_id", "permissions"},
     *             @OA\Property(property="user_id", type="string", example="793710"),
     *             @OA\Property(property="permissions", type="[array]", example="['can_verivy_checks', 'can_manage_permission']"),
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
     *         response=403,
     *         description="Вылетает если у пользователя не прав для этого метода",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string"),
     *             @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Не найдено",
     *         @OA\JsonContent(
     *           @OA\Property(property="error", type="string"),
     *           @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Не указаны необходимые параметры",
     *         @OA\JsonContent(
     *              @OA\Property(property="errors", type="object"),
     *              @OA\Property(property="code", type="string"),
     *         )
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="200 response",
     *         @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *              @OA\Property(property="code", type="string"),
     *         ),
     *     ),
     * )
     */
    public function managePermissions(ManagePermissionsRequest $request)
    {
        $data = $request->only([
            'user_id',
            'permissions',
        ]);

        $response = $this->userService->managePermissions($data['permissions'], $data['user_id']);

        return response()->json($response, $response->code ?? 200);
    }
}
