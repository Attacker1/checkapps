<?php

namespace App\Http\Resources;

use App\Enum\PermissionsEnum;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\PermissionResource;
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
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'isAdmin' => $this->whenLoaded('permissions', function() {
                return (bool) $this->permissions->where('slug', PermissionsEnum::CAN_VIEW_ADMIN_PAGES['slug'])->first();
            }),
        ];

        return $data;
    }
}
