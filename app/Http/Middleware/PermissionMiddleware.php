<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        try {
            if (!$request->user()) {
                throw new Exception('Пользователь не авторизован', 404);
            }

            if(!$request->user()->hasPermissions($permissions)) {
                throw new Exception('Отсутствуют права для запрашиваемого метода', 403);
            }

            return $next($request);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ], $exception->getCode());
        }
    }
}
