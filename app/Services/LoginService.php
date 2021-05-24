<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Client\JsonRpcClient;
use Illuminate\Support\Carbon;
use App\Http\Client\LoginClient;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    protected $loginClient;
    protected $loginResponse;
    protected $currentUser;

    /**
     * LoginService constructor.
     * @param $loginClient
     * @param $userService
     */
    public function __construct(JsonRpcClient $loginClient)
    {
        $this->loginClient = $loginClient;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('login', 'password');
        $response = $this->loginClient->send('User/login', $credentials);

        try {
            if (isset($response->error)) {
                throw new Exception(
                    $response->message,
                    404
                );
            }

            $response->info->token_id = $response->token_id;
            $this->loginResponse = $response->info;

            return $this->userAuthenticate($request);
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }

    private function loginUser(LoginRequest $request)
    {
        $successLogin = Auth::loginUsingId($this->currentUser->id);

        try {
            if(!$successLogin) {
                throw new Exception(
                    'Не получилось войти',
                    404
                );
            }

            $token = Auth::user()->createToken(config('app.name'));
            $token->token->expires_at = $request->remember_me ?
                Carbon::now()->addMonth() :
                Carbon::now()->addDay();

            $token->token->save();

            $attributes = $this->currentUser->getAttributes();
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['id']);

            return [
                'token_type' => 'Bearer',
                'token' => $token->accessToken,
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                'user_id' => $this->currentUser->id,
                'user' => $attributes,
            ];
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }


    private function registerUser(LoginRequest $request)
    {
        $userData = array_merge(
            ['password' =>  bcrypt(Str::random())],
            (array) $this->loginResponse
        );

        $createdUser = $this->create($userData);

        try {
            if(isset($createdUser->error)) {
                throw new Exception(
                    $createdUser->error,
                    404
                );
            }

            $this->currentUser = $createdUser;

            return $this->loginUser($request);
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }


    private function userAuthenticate(LoginRequest $request)
    {
        $checkUserExist = User::byEmail($request->login)->first();

        try {
            if (!empty($checkUserExist)) {
                $this->currentUser = $checkUserExist;

                $checkUserExist->token_id = $this->loginResponse->token_id;
                $success = $checkUserExist->save();

                if(!$success) {
                    throw new Exception(
                        'Не удалось обновить токен входа',
                        404
                    );
                }

                return $this->loginUser($request);
            } else {
                return $this->registerUser($request);
            }
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function create($response)
    {
        try {
            $user = new User($response);
            $success = $user->save();

            if(!$success) {
                throw new Exception(
                    'Не удалось создать пользователя',
                    404
                );
            }

            return $user;
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }
}