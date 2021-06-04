<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enum\PermissionsEnum;
use Illuminate\Support\Facades\Gate;
use App\Repositories\CheckRepository;

class DevController extends Controller
{
    private $checkRepository;

    public function __construct(CheckRepository $checkRepository)
    {
        $this->checkRepository = $checkRepository;
    }

    public function index(Request $request)
    {
        $data = 'Мамкин хацкер';
        // $data = Gate::abilities();

        return view('dev', ['data' => $data]);
    }
}
