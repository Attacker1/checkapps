<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_fio' => $this->user_fio,
            'user_email' => $this->user_email,
            'user_phone' => $this->user_phone,
            'balance' => $this->balance,
        ];

        if($this->check_history_count) {
            $data['check_history_count'] = $this->check_history_count;
        }

        return $data;
    }
}
