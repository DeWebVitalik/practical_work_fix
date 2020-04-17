<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;

class HomeController extends Controller
{
    protected StatisticsService $service;

    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home', $this->service->getStatistic());
    }
}
