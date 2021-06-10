<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function settings()
    {
        $response = $this->settingService->settings();

        return response()->json($response, $response->code ?? 200);
    }

    public function edit(EditSettingRequest $request) {
        $data = $request->only([
            'slug',
            'value',
        ]);
        $response = $this->settingService->edit($data['slug'], $data['value']);

        return response()->json($response, $response->code ?? 200);
    }
}
