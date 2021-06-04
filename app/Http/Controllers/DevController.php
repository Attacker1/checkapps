<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
