<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\RecaptchaService;

class Recaptcha
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $recaptchaService = new RecaptchaService();
            $token = $request->input('recaptcha_token');
            $ip = $request->ip();

            $responce = $recaptchaService->check($token, $ip);

            if(isset($responce->error)) {
                throw new Exception($responce->error, $responce->code);
            }

            if(!$responce) {
                throw new Exception('Captcha is invalid.', 404);
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
