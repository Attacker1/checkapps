<?php

namespace App\Services;

use App\Client\JsonRpcClient;

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
        $params = $request->only(['login', 'password']);
        $response = $this->client->send('User/login', $params);

        if (isset($response->error)) {
            return json_encode($response);
        } else {
            $userToken = $response->token_id;
            $userInfo = $response->info;
            $result = (object)array_merge((array)$userInfo, (array)['token_id' => $userToken]);

            $user = $this->userService->storeUpdate($result);
            dd($user);

            return $user;
        }
    }
}
