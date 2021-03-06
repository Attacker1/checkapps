<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Client\JsonRpcClient;
use App\Enum\PermissionsEnum;
use App\Services\AdminService;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    protected $loginClient;
    protected $adminService;
    protected $userService;

    protected $loginResponse;
    protected $currentUser;

    public function __construct(JsonRpcClient $loginClient, AdminService $adminService, UserService $userService)
    {
        $this->loginClient = $loginClient;
        $this->adminService = $adminService;
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('login', 'password');

        $response = $this->loginClient->send('User/login', $credentials);

        try {
            if (isset($response->error)) {
                throw new Exception(
                    $response->error,
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
        try {
            $successLogin = Auth::loginUsingId($this->currentUser->id);

            if (!$successLogin) {
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
            [
                'password' => bcrypt(Str::random()),
            ],
            (array) $this->loginResponse
        );

        $createdUser = $this->create($userData);

        try {
            if (isset($createdUser->error)) {
                throw new Exception(
                    $createdUser->error,
                    404
                );
            }

            $createdUser->givePermissionsTo(PermissionsEnum::CAN_VERIVY_CHECKS['slug']);

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
        $checkUserExist = $this->userService->userExists($request->login);

        try {
            if (!empty($checkUserExist)) {

                if((bool) $checkUserExist->is_banned === true) {
                    throw new Exception('Пользователь заблокирован', 404);
                }

                $this->currentUser = $checkUserExist;

                $checkUserExist->token_id = $this->loginResponse->token_id;
                $success = $checkUserExist->save();

                if (!$success) {
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

            if (!$success) {
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
