<?php

namespace App\Services;

use App\Client\JsonRpcClient;
use App\Models\User;

class AuthService
{
    protected $client;
    protected $userService;

    /**
     * AuthService constructor.
     * @param $client
     * @param $userService
     */
    public function __construct(JsonRpcClient $client, UserService $userService)
    {
        $this->client = $client;
        $this->userService = $userService;
    }


    public function login($request)
    {
        $params = $request->all();
        $response = $this->client->send('User/login', $params);

        if (isset($response->error)) {
            return response()->json($response);
        } else {
            $userToken = $response->token_id;
            $userInfo = $response->info;
            $result = (object)array_merge((array)$userInfo, (array)['token_id' => $userToken]);

            $user = $this->userService->storeUpdate($result);
            $attributes = $user->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['id']);
            return response()->json($attributes);
        }
    }

    public function logout()
    {
        return response()->json([
            'success' => (bool)true
        ]);
    }
}
