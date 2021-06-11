<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * @OA\GET(
     *     path="/api/permissions",
     *     summary="Позволяет получить все разрешения",
     *     description="Позволяет получить все разрешения",
     *     operationId="permissions",
     *     tags={"Permissions"},
     *     security={ {"passport": {} }},
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
     *                  @OA\Property(property="slug", type="string"),
     *                  @OA\Property(property="name", type="string"),
     *         ),
     *     ),
     * )
     */
    public function permissions() {
        $response = $this->permissionService->permissions();

        return response()->json($response, $response->code ?? 200);
    }
}
