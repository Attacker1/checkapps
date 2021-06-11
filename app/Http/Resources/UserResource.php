<?php

namespace App\Http\Resources;

use App\Enum\PermissionsEnum;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\CheckHistoryResource;
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
            'is_banned' => (bool) $this->is_banned,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'is_admin' => $this->whenLoaded('permissions', function() {
                return (bool) $this->permissions->where('slug', PermissionsEnum::CAN_VIEW_ADMIN_PAGES['slug'])->first();
            }),
        ];

        if(isset($this->check_history_count)) {
            $data['check_history_count'] = $this->check_history_count;
        }

        if(isset($this->rejected_checks_count)) {
            $data['rejected_checks_count'] = $this->rejected_checks_count;
        }

        if(isset($this->approved_checks_count)) {
            $data['approved_checks_count'] = $this->approved_checks_count;
        }

        return $data;
    }
}
