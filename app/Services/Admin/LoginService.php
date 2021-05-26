<?php
namespace App\Services\Admin;

use Exception;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\ModeratorService;

class LoginService
{
    private $moderatorService;

    public function __construct(ModeratorService $moderatorService)
    {
        $this->moderatorService = $moderatorService;
    }

    public function __invoke(LoginRequest $request)
    {
        try {
            $token_id = $this->moderatorService->getToken();
            $creditnails = [
                'user_email' => $request->login,
                'password' => $request->password,
            ];

            if(isset($token_id->error)) {
                throw new Exception($token_id->error, $token_id->code);
            }

            $canLogin = Auth::attempt($creditnails);

            if (!$canLogin) {
                throw new Exception(
                    'Неверный логин или пароль',
                    404
                );
            }
            $user = User::where('user_email', $request->login)->first();
            $successLogin = Auth::loginUsingId($user->id);

            if (!$successLogin) {
                throw new Exception(
                    'Не получилось войти',
                    404
                );
            }

            $token = Auth::user()->createToken(config('app.name'));
            $token->token->expires_at = $request->remember_me ? Carbon::now()->addMonth() : Carbon::now()->addDay();
            $token->token->save();

            $attributes = $user->getAttributes();
            $attributes['token_id'] = $token_id;
            unset($attributes['created_at'], $attributes['updated_at'], $attributes['id']);

            return [
                'token_type' => 'Bearer',
                'token' => $token->accessToken,
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString(),
                'user_id' => $user->id,
                'user' => $attributes,
            ];
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }
}
