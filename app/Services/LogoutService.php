<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LogoutService
{
    public function logout($request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Вы успешно вышли из системы',
        ]);
    }
}

