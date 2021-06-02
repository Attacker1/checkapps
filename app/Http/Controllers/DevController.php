<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return view('dev', ['data' => $data]);
    }
}
