<?php

namespace App\Services;

use App\Enum\PermissionsEnum;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Gate;

class SettingService
{
    public function settings()
    {
        try {
            $can = Gate::check(PermissionsEnum::CAN_EDIT_SETTINGS['slug']);

            if(!$can) {
                throw new Exception('У вас не прав для редактирования настроек', 403);
            }

            $settings = Setting::all();

            return SettingResource::collection($settings);
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }

    public function edit($settingSlug, $settingValue)
    {
        try {
            $can = Gate::check(PermissionsEnum::CAN_EDIT_SETTINGS['slug']);

            if(!$can) {
                throw new Exception('У вас не прав для редактирования настроек', 403);
            }

            $setting = Setting::SettingBySlug($settingSlug)->first();

            if(!$setting) {
                throw new Exception('Настройка не найдена', 404);
            }

            $setting->value = $settingValue;
            $success = $setting->save();

            if(!$success) {
                throw new Exception('Не удалось изменить настройку', 403);
            }

            return (object) [
                'message' => 'Настройка успешно изменена',
                'code' => 200,
            ];
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }
}
