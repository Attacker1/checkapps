<?php

namespace App\Http\Controllers;

use App\Repositories\CheckRepository;

class DevController extends Controller
{
    private $checkRepository;

    public function __construct(CheckRepository $checkRepository)
    {
        $this->checkRepository = $checkRepository;
    }

    public function index()
    {
        $data =  $this->checkRepository->getByExpirityTimeout(60 * 60);

        return view('dev', ['data' => $data]);
    }
}