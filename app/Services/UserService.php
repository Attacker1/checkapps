<?php

namespace App\Services;


use App\Models\User;

class UserService
{
    public function storeUser($response)
    {
        $user = new User($response);
        $user->save();
        return $user;
    }

    public function updateUser($response, User $user)
    {
        $user->update($response);
        $user->save();
        return $user;
    }

    public function storeUpdate($response)
    {
        $user = User::byUserId($response->user_id)->first();
        if ($user) {
            return $this->updateUser((array)$response, $user);
        } else {
            return $this->storeUser((array)$response);
        }
    }
}
