<?php

namespace App\Services;

use App\Enums\NoteTypeEnum;
use App\Enums\SampleVisitStatus;
use App\Enums\VisitStatusEnum;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\Sample;
use App\Models\Visit;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class VisitService extends Service
{

    public function __construct( protected DataTables $dataTables)
    {

    }

      public function getVisitsDataTable($filters)
    {
        $groupBy = $filters['group_by'];
        $search = $filters['search'];
        $dateFrom = $filters['date_from'];
        $dateTo = $filters['date_to'];
        $user = $filters['user'];

        $query = Visit::with(['representative.user', 'doctor'])->visibleTo($user);

           $query->when($search, function($query) use ($search) {
                $searchTerm = '%' . str_replace(' ', '%', $search) . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('representative.user', function($q2) use ($searchTerm) {
                        $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                           ->orWhere('first_name', 'LIKE', $searchTerm)
                           ->orWhere('last_name', 'LIKE', $searchTerm);
                    })
                    ->orWhereHas('doctor', function($q2) use ($searchTerm) {
                        $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                           ->orWhere('first_name', 'LIKE', $searchTerm)
                           ->orWhere('last_name', 'LIKE', $searchTerm);
                    });
                });
            })
            ->when($dateFrom, function ($q) use ($dateFrom) {
                 return $q->whereDate('scheduled_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                return $q->whereDate('scheduled_at', '<=', $dateTo);
            })

        ->when($groupBy === 'representative', function($query) {
            $query->orderBy('representative_id');
        })
        ->when($groupBy === 'doctor', function($query) {
            $query->orderBy('doctor_id');
        })
         ->when($groupBy === 'scheduled_at', function($query) {
               $query ->orderBy('scheduled_at','DESC');
            })
         ->when($groupBy === 'status', function($query) {
               $query ->orderBy('status');
            })
         ->latest('scheduled_at');

        return $this->dataTables->eloquent($query)
            ->addColumn('representative', function($v) {
                return $v->representative->user->full_name ?? 'N/A';
            })
            ->addColumn('doctor', function($v) {
                return $v->doctor->full_name ?? 'No Doctor Assigned';
            })
            ->addColumn('scheduled_at', function($v) {
                 $format = app()->getLocale() === 'ar' ? 'j F Y H:i' : 'Y-m-d H:i';
                return $v->scheduled_at->translatedFormat($format);
            })

            ->addColumn('status', function($v) {
            return '<span class="badge bg-light-'.$v->status->color().'">'.$v->status->label().'</span>';
            })

          ->addColumn('action', function($v) {
            $icon = app()->getLocale() === 'ar' ? 'bi-box-arrow-up-left' : 'bi-box-arrow-up-right';
            return '<a href="'.route('visits.show', $v->id).'"><i class="bi ' . $icon . '"></i></a>';
          })

        ->rawColumns(['status', 'action'])

        ->toJson();
    }


    public function show($data, $withes =[])
    {

        return Visit::with($withes)->findOrFail($data['visit_id']);
    }

    public function getVisitsForRepresentativeDataTable(Representative $representative, $filters = [])
{
       $groupBy = $filters['group_by'];
        $search = $filters['search'];
        $dateFrom = $filters['date_from'];
        $dateTo = $filters['date_to'];
        $user = $filters['user'];

    $query = $representative->visits()
        ->with(['doctor', 'samples']);

     $query->when($search, function($query) use ($search) {
                $searchTerm = '%' . str_replace(' ', '%', $search) . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('doctor', function($q2) use ($searchTerm) {
                        $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                           ->orWhere('first_name', 'LIKE', $searchTerm)
                           ->orWhere('last_name', 'LIKE', $searchTerm);
                    });
                });
            })
            ->when($dateFrom, function ($q) use ($dateFrom) {
                 return $q->whereDate('scheduled_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                return $q->whereDate('scheduled_at', '<=', $dateTo);
            })

        ->when($groupBy === 'doctor', function($query) {
            $query->orderBy('doctor_id');
        })
         ->when($groupBy === 'scheduled_at', function($query) {
               $query ->orderBy('scheduled_at','DESC');
            })
         ->when($groupBy === 'status', function($query) {
               $query ->orderBy('status');
            })
         ->latest('scheduled_at');


    return $this->dataTables->eloquent($query)
        ->addColumn('doctor', function($v) {
            return $v->doctor->full_name ?? 'No Doctor Assigned';
        })
        ->addColumn('scheduled_at', function($v) {
            $format = app()->getLocale() === 'ar' ? 'j F Y H:i' : 'Y-m-d H:i';
            return $v->scheduled_at->translatedFormat($format);
        })
        ->addColumn('status', function($v) {
            return '<span class="badge bg-light-'.$v->status->color().'">'.$v->status->label().'</span>';
        })
        ->addColumn('action', function($v) {
            $icon = app()->getLocale() === 'ar' ? 'bi-box-arrow-up-left' : 'bi-box-arrow-up-right';
            return '<a href="'.route('visits.show', $v->id).'"><i class="bi ' . $icon . '"></i></a>';
        })
        ->rawColumns(['status', 'action'])
        ->toJson();
}


   public function create()
    {
        $user = auth()->user();

        $representatives = Representative::with('user','workingMunicipals')->visibleTo($user)->get();
        $doctors = Doctor::with('municipal')->visibleTo($user)->get();

        return [
            'representatives' => $representatives,
            'doctors'         => $doctors,
            'samples'         => [],
        ];
    }


    public function store($data)
    {

        return DB::transaction(function () use ($data) {
        $visit = Visit::create([
            'representative_id' => $data['representative_id'],
            'doctor_id'         => $data['doctor_id'],
            'created_by'        => $data['user_id'],
            'status'            => VisitStatusEnum::SCHEDULED->value,
            'scheduled_at'      => $data['scheduled_at'],
        ]);

        if (!empty($data['samples'])) {
            foreach ($data['samples'] as $sampleData) {
                $sample = Sample::findOrFail($sampleData['id']);

                if ($sample->quantity_available < $sampleData['quantity_assigned']) {
                    throw ValidationException::withMessages([
                        'samples' => ["Sample '{$sample->name}' has only {$sample->quantity_available} available."],
                    ]);
                }

                $visit->samples()->attach($sample->id, [
                    'quantity_assigned' => $sampleData['quantity_assigned'],
                    'status'            => SampleVisitStatus::PENDING->value,
                ]);

                $sample->decrement('quantity_available', $sampleData['quantity_assigned']);
            }
        }

        if (!empty($data['notes'])) {
                $visit->notes()->create([
                    'user_id' => $data['user_id'],
                    'content' => $data['notes'],
                    'type'    => $data['type'] ??  NoteTypeEnum::INSTRUCTION->value,
                ]);
        }

        return $visit;
        });
    }


    public function updateStatus($data, $visit)
    {

        $visit->status = $data['status'];

        $visit->save();

        return $visit;
    }


    public function completeVisit(array $data, Visit $visit): Visit
{
    return DB::transaction(function () use ($data, $visit) {
        $visit->status = VisitStatusEnum::COMPLETED->value;
        $visit->actual_visit_time = Carbon::now();
        $visit->save();

        foreach ($data['samples'] as $sample) {
            $visit->samples()->updateExistingPivot($sample['id'], [
                'status' => $sample['status'],
                'quantity_used' => $sample['quantity_used'] ?? null,
            ]);
        }

        if (!empty($data['notes'])) {
            $visit->notes()->create([
                'user_id' => $data['user_id'],
                'content' => $data['notes'],
                'type' => NoteTypeEnum::REPORT->value,
            ]);
        }

        return $visit->load(['doctor', 'samples', 'notes.user']);
    });
}


}



