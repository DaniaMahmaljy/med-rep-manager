<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\Visit;
use Carbon\Carbon;

class DashboardService extends Service
{
    public function getDashboardStatistics()
    {
        $now = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        return [
            'total_representatives' => Representative::count(),
            'total_doctors' => Doctor::count(),
            'last_month_visits' => Visit::whereBetween('created_at', [$lastMonth, $now])->count(),
            'completed_visits' => Visit::whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->where('status', VisitStatusEnum::COMPLETED)
                ->count(),
            'chart_data' => [
                'completed' => Visit::where('status', VisitStatusEnum::COMPLETED)->count(),
                'missed' => Visit::where('status', VisitStatusEnum::MISSED)->count(),
                'scheduled' => Visit::where('status', VisitStatusEnum::SCHEDULED)->count(),
                'cancelled' => Visit::where('status', VisitStatusEnum::CANCELED)->count(),
            ]
        ];
    }
}
