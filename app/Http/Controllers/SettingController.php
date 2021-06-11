<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * @OA\GET(
     *     path="/api/settings",
     *     summary="Позволяет получить все настройки",
     *     description="Позволяет получить все настройки",
     *     operationId="settings",
     *     tags={"Settings"},
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
     *                  @OA\Property(property="value", type="mixed"),
     *         ),
     *     ),
     * )
     */
    public function settings()
    {
        $response = $this->settingService->settings();

        return response()->json($response, $response->code ?? 200);
    }
    /**
     * @OA\Post(
     *     path="/api/settings/edit",
     *     summary="Позволяет изменить настройку",
     *     description="Позволяет изменить настройку",
     *     operationId="editSetting",
     *     tags={"Settings"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Изменить настройку",
     *         @OA\JsonContent(
     *             required={"slug", "value"},
     *             @OA\Property(property="slug", type="string", example="check_expirity_time"),
     *             @OA\Property(property="email", type="mixed", example="72"),
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
    public function edit(EditSettingRequest $request)
    {
        $data = $request->only([
            'slug',
            'value',
        ]);
        $response = $this->settingService->edit($data['slug'], $data['value']);

        return response()->json($response, $response->code ?? 200);
    }
}
