<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Sample;
use Yajra\DataTables\DataTables;


class SampleService extends Service
{
    public function __construct( protected DataTables $dataTables)
    {

    }

    public function getSamplesByDoctorSpecialty(Doctor $doctor)
    {
         if (!$doctor->specialty_id) {
        return collect();
    }
    return Sample::whereHas('specialties', function($query) use ($doctor) {
        $query->where('specialty_id', $doctor->specialty_id);
    })->get();
}

 public function getSamplesDataTable($filters)
{
    $groupBy = $filters['group_by'] ?? null;
    $search = $filters['search'] ?? null;
    $user = $filters['user'] ?? null;

    $query = Sample::with(['brand', 'sampleClass']);

    if ($search) {
        $searchTerm = '%' . str_replace(' ', '%', $search) . '%';

        $query->where(function($q) use ($searchTerm) {
            $q->whereHas('brand.translations', function($q2) use ($searchTerm) {
                $q2->where('name', 'LIKE', $searchTerm);
            })
            ->orWhereHas('sampleClass.translations', function($q3) use ($searchTerm) {
                $q3->where('name', 'LIKE', $searchTerm);
            });
        });
    }

    $query->when($groupBy === 'brand', fn($q) => $q->orderBy('brand_id'))
          ->when($groupBy === 'sampleClass', fn($q) => $q->orderBy('sample_class_id'))
          ->latest();

    return $this->dataTables->eloquent($query)
        ->addColumn('name', fn($r) => $r->name ?? '—')
        ->addColumn('brand', fn($r) => $r->brand->name ?? '—')
        ->addColumn('sampleClass', fn($r) => $r->sampleClass->name ?? '—')
        ->addColumn('action', function($r) {
            $icon = app()->getLocale() === 'ar' ? 'bi-box-arrow-up-left' : 'bi-box-arrow-up-right';
            $url = route('samples.show', $r->id);
            return '<a href="' . $url . '"><i class="bi ' . $icon . '"></i></a>';
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    public function show($id, $withes =[])
    {
            return Sample::with($withes)->find($id);
    }

    public function store($data)
    {

        $sample = Sample::create ([
        'brand_id' => $data['brand_id'],
        'sample_class_id' => $data['sample_class_id'],
        'unit' => $data['unit'],
        'quantity_available' => $data['quantity_available'],
        'expiration_date' => $data['expiration_date'],
       ]);

        $sample->translateOrNew('en')->name = $data['name']['en'];
        $sample->translateOrNew('ar')->name = $data['name']['ar'];
        $sample->save();

        if (!empty($data['specialty_ids'])) {
            $sample->specialties()->sync($data['specialty_ids']);
        }

       return $sample;
    }
}
