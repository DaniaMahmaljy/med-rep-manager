<?php

namespace App\Services;

use App\Enums\VisitStatusEnum;
use App\Models\Doctor;
use Yajra\DataTables\DataTables;


class DoctorService extends Service
{

    public function __construct( protected DataTables $dataTables)
    {

    }

      public function getDoctorsDataTable($filters)
    {
        $groupBy = $filters['group_by'];
        $search = $filters['search'];
        $user = $filters['user'];

        $query = Doctor::with(['specialty', 'municipal', 'supervisors.user'])->visibleTo($user);


           $query->when($search, function($query) use ($search) {
                $searchTerm = '%' . str_replace(' ', '%', $search) . '%';
                $query->where(function($q) use ($searchTerm) {
                        $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                           ->orWhere('first_name', 'LIKE', $searchTerm)
                           ->orWhere('last_name', 'LIKE', $searchTerm);
                })
                    ->orWhereHas('municipal.translations', function($q2) use ($searchTerm) {
                          $q2->Where('name', 'LIKE', $searchTerm);
                    });

                })


        ->when($groupBy === 'municipal', function($query) {
            $query->orderBy('municipal_id');
        })
         ->when($groupBy === 'specialty', function($query) {
            $query->orderBy('specialty_id');
        })
         ->latest();

        return $this->dataTables->eloquent($query)
            ->addColumn('name', function($r) {
                return $r->full_name ?? 'N/A';
            })
            ->addColumn('specialty', function($r) {
                return  $r->specialty ? $r->specialty->name: '-';;
            })
            ->addColumn('municipal', function($r) {
              $municipal = $r->municipal;
                if (!$municipal) return '—';
                $city = $municipal->city->name ?? '';
                return $municipal->name . ($city ? " ($city)" : '');
            })
           ->addColumn('supervisors', function ($r) use ($user) {
            if (!$user->hasRole('supervisor')) {
                return $r->supervisors->map(function ($supervisor) {
                    return $supervisor->user->full_name ?? '—';
                })->implode(', ') ?: '—';
            }
            return null;
        })
        ->addColumn('supervisorIds', function ($r) {
            return $r->supervisors->pluck('user_id')->toArray();
        })

        ->rawColumns(['action'])

        ->toJson();
    }


    public function show($id, $withes =[])
    {
        return Doctor::with($withes)->find($id);
    }

    public function getDoctorStatistics(Doctor $doctor)
{
    $visits = $doctor->visits()->with(['representative', 'samples'])->get();

    $stats = [
        'total_visits' => 0,
        'upcoming_visits' => 0,
        'completed_visits' => 0,
        'cancelled_visits' => 0,
        'distinct_representatives' => 0,
        'completed_rate' => 0,
        'has_visits' => false,
        'sample_stats' => [
            'total_assigned' => 0,
            'total_used' => 0,
            'utilization_rate' => '0%'
        ]
    ];

    if ($visits->isNotEmpty()) {
        $sampleStats = ['total_assigned' => 0, 'total_used' => 0];
        foreach ($visits as $visit) {
            foreach ($visit->samples as $sample) {
                $sampleStats['total_assigned'] += $sample->pivot->quantity_assigned ?? 0;
                $sampleStats['total_used'] += $sample->pivot->quantity_used ?? 0;
            }
        }

        $utilizationRate = $sampleStats['total_assigned'] > 0  ? round(($sampleStats['total_used'] / $sampleStats['total_assigned']) * 100, 2) . '%'  : '0%';

        $groupedVisits = $visits->groupBy('representative_id');

        $stats = [
            'total_visits' => $visits->count(),
            'upcoming_visits' => $visits->where('scheduled_at', '>', now())->count(),
            'completed_visits' => $visits->where('status', VisitStatusEnum::COMPLETED)->count(),
            'cancelled_visits' => $visits->where('status', '!=',  VisitStatusEnum::COMPLETED)->count(),
            'distinct_representatives' => $groupedVisits->count(),
            'completed_rate' => round(($visits->where('status', VisitStatusEnum::COMPLETED)->count() / $visits->count()) * 100, 2),
            'has_visits' => true,
            'sample_stats' => array_merge($sampleStats, ['utilization_rate' => $utilizationRate])
        ];
    }

    return $stats;
}


    public function store($data)
    {

        $doctor = Doctor::create ([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'municipal_id' => $data['municipal_id'],
        'specialty_id' => $data['specialty_id'],
        'phone' => $data['phone'],
        'address' => $data['address'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude'],
       ]);

       return $doctor;
    }

    public function assignSupervisors(Doctor $doctor, array $data)
    {
        if (array_key_exists('supervisor_ids', $data)) {
            $doctor->supervisors()->sync($data['supervisor_ids']);
        }
    }

}

