<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexSampleRequest;
use App\Http\Requests\StoreSampleRequest;
use App\Models\Doctor;
use App\Services\BrandService;
use App\Services\SampleClassService;
use App\Services\SampleService;
use App\Services\SpecialtyService;
use Illuminate\Http\Request;

class SampleController extends Controller
{

    public function __construct(protected SampleService $sampleService,  protected SpecialtyService $specialtyService,
    protected BrandService $brandService, protected SampleClassService $sampleClass)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(IndexSampleRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->sampleService->getSamplesDataTable($filters);
        }

       return view('samples.index');
    }



    public function getByDoctor(Request $request, Doctor $doctor)
    {
         if ($request->ajax()) {
            $samples = $this->sampleService->getSamplesByDoctorSpecialty($doctor);
            return response()->json($samples);
          }

        abort(403, 'Unauthorized action.');
    }
    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        $brands = $this->brandService->all(paginated: false);
        $sampleClasses = $this->sampleClass->all(paginated: false);
        $specialties = $this->specialtyService->all(paginated: false);

        return view('samples.create', compact('brands', 'sampleClasses', 'specialties'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSampleRequest $request)
    {
        $data = $request->validated();
        $sample = $this->sampleService->store($data);
        return redirect()->route('samples.index')
        ->with('success',  __('local.Samples added successfully'));
    }

    /**
     * Display the specified resource.
     */
     public function show(string $id)
    {
        $sample = $this->sampleService->show(id: $id,  withes: ['brand', 'sampleClass', 'specialties']);
        return view('samples.show',compact('sample'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
