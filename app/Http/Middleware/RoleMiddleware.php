<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        try {
            if (!$request->user()) {
                throw new Exception('Пользователь не авторизован', 404);
            }

            $userRole = $request->user()->role;

            if(!$userRole) {
                throw new Exception('Пользователь не имеет ролей', 404);
            }

            $isPass = in_array($userRole->slug, $roles);

            if(!$isPass) {
                throw new Exception('Отсутствуют права для запрашиваемого метода', 404);
            }

            return $next($request);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }
    }
}
