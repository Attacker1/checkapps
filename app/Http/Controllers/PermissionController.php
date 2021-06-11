<?php

namespace App\Http\Controllers;

use App\Services\PermissionService;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function permissions() {
        $response = $this->permissionService->permissions();

        return response()->json($response, $response->code ?? 200);
    }
}
