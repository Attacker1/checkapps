<?php

namespace App\Http\Controllers;
use App\Client\JsonRpcClient;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->only(['login', 'password']);
        $client = new JsonRpcClient();
        $client->send('User/login', $params);
    }
}
