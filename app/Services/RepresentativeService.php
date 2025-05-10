<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Models\Representative;
use App\Models\Visit;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;


class RepresentativeService extends Service
{

    public function __construct( protected DataTables $dataTables)
    {

    }

      public function getRepresentativesDataTable($filters)
    {
        $groupBy = $filters['group_by'];
        $search = $filters['search'];
        $user = $filters['user'];

        $query = Representative::with(['user', 'residingMunicipal.city'])->visibleTo($user);
        if (! $user->hasRole('supervisor')) {
            $query->with('supervisor.user');
        }

           $query->when($search, function($query) use ($search) {
                $searchTerm = '%' . str_replace(' ', '%', $search) . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('user', function($q2) use ($searchTerm) {
                        $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                           ->orWhere('first_name', 'LIKE', $searchTerm)
                           ->orWhere('last_name', 'LIKE', $searchTerm);
                    })
                    ->orWhereHas('residingMunicipal.translations', function($q2) use ($searchTerm) {
                          $q2->Where('name', 'LIKE', $searchTerm);
                    })
                     ->orWhereHas('residingMunicipal.city.translations', function($q3) use ($searchTerm) {
                        $q3->where('name', 'LIKE', $searchTerm);
                    });
                });
            })

        ->when($groupBy === 'municipal', function($query) {
            $query->orderBy('municipal_id');
        })
         ->when($groupBy === 'supervisor', function($query) {
            $query->orderBy('supervisor_id');
        })
         ->latest();

        return $this->dataTables->eloquent($query)
            ->addColumn('name', function($r) {
                return $r->user->full_name ?? 'N/A';
            })
            ->addColumn('supervisor', function($r) {
                return  $r->supervisor && $r->supervisor->user? $r->supervisor->user->full_name: 'No Supervisor Assigned';;
            })
            ->addColumn('municipal', function($r) {
              $municipal = $r->residingMunicipal;
                if (!$municipal) return '—';
                $city = $municipal->city->name ?? '';
                return $municipal->name . ($city ? " ($city)" : '');
            })

          ->addColumn('action', function($r) {
            $icon = app()->getLocale() === 'ar' ? 'bi-box-arrow-up-left' : 'bi-box-arrow-up-right';
            return '<a href="'.route('representatives.show', $r->id).'"><i class="bi ' . $icon . '"></i></a>';
          })

        ->rawColumns(['action'])

        ->toJson();
    }


    public function show($id, $withes =[])
    {
        return Representative::with($withes)->find($id);
    }


    public function getTodayVisits(Representative $representative)
    {
        return $representative->visits()
            ->with(['doctor','samples'])
            ->whereDate('scheduled_at', Carbon::today())
            ->orderBy('scheduled_at')
            ->get();
    }


public function getStatistics(Representative $representative)
{
    $statuses = [
        VisitStatusEnum::SCHEDULED,
        VisitStatusEnum::COMPLETED,
        VisitStatusEnum::CANCELED,
        VisitStatusEnum::MISSED,
    ];

    $statusCounts = [];
    $totalVisits = $representative->visits()->count();

    foreach ($statuses as $status) {
        $count = $representative->visits() ->where('status', $status->value)->count();

        $statusCounts[$status->label()] = $count;
    }

    $linkedDoctorsCount = $representative->visits()->distinct('doctor_id')->count('doctor_id');

    $completedVisits = $statusCounts[VisitStatusEnum::COMPLETED->label()] ?? 0;

    $completionRate = $totalVisits > 0 ? round(($completedVisits / $totalVisits) * 100, 2): 0;

    $labels = [];
    $values = [];
    $colors = [];

    foreach ($statuses as $status) {
        $labels[] = $status->label();
        $values[] = $statusCounts[$status->label()] ?? 0;

       $colorMap = [
        'primary' => '#50e3c2',
        'success' => '#1e90ff',
        'danger'  => '#ff6b6b',
        'warning' => '#f7b733',
    ];

        $bootstrapColor = $status->color();
        $colors[] = $colorMap[$bootstrapColor] ?? '#b2bec3';
    }

    return [
        'total_visits' => $totalVisits,
        'completed_visits' => $completedVisits,
        'completion_rate' => $completionRate,
        'linked_doctors' => $linkedDoctorsCount,
        'labels' => $labels,
        'values' => $values,
        'colors' => $colors,
    ];
}


public function allVisits($data = [], $paginated = true, $withes = [], $today = false)
{
        $representative = $data['representative'];

        $query = $representative->visits()
         ->with($withes)->latest();


        if ($today) {
           $query->whereDate('scheduled_at', Carbon::today())
            ->orderBy('scheduled_at');
        }

        if ($paginated) {
             return $query->paginate();
        }


        else {
            return  $query->get();
        }
}

};
