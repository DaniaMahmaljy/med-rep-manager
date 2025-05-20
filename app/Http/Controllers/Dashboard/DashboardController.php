<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService)
    {

    }
    public function index()
    {
        $stats = $this->dashboardService->getDashboardStatistics();
        return view('dashboard', compact('stats'));
    }
}
