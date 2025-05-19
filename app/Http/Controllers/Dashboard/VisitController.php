<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexDoctorVisitsRequest;
use App\Http\Requests\IndexRepVisitsRequest;
use App\Http\Requests\IndexVisitRequest;
use App\Http\Requests\ShowVisitRequest;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitStatusRequest;
use App\Models\Doctor;
use App\Models\Representative;
use App\Models\Visit;
use App\Services\VisitService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(protected VisitService $visitService)
     {

     }

    public function index(IndexVisitRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->visitService->getVisitsDataTable($filters);
        }
       return view('visits.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->visitService->create();
        return view('visits.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitRequest $request)
    {
         $data = $request->afterValidation();
         $visit = $this->visitService->store($data);
         if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'redirect_url' => route('visits.show', $visit->id),
        ]);
    }

    return redirect()->route('visits.show', $visit->id)
        ->with('success', __('local.Visit created successfully.'));
    }



    public function byRepresentative(IndexRepVisitsRequest $request, Representative $representative)
    {
        $this->authorize('view', $representative);
        if ($request->ajax()) {
            $filters = $request->filters();
            return $this->visitService->getVisitsForRepresentativeDataTable($representative, $filters);
        }
        return view('visits.by-representative', compact('representative'));
    }

    public function byDoctor(IndexDoctorVisitsRequest $request, Doctor $doctor)
    {
        $this->authorize('view', $doctor);
        if ($request->ajax()) {
            $filters = $request->filters();
            return $this->visitService->getVisitsForDoctorDataTable($doctor, $filters);
        }
        return view('visits.by-doctor', compact('doctor'));
    }



        public function show(ShowVisitRequest $request, Visit $visit)
        {
            $data = $request->afterValidation();

            $visitData = $this->visitService->show(data: $data, withes: [
                'representative.user',
                'doctor',
                'notes.user',
                'samples.brand',
                'samples.sampleClass'
            ]);


            return view('visits.show', compact('visitData'));
        }

    public function updateStatus(UpdateVisitStatusRequest $request, Visit $visit)
    {
        $data = $request->afterValidation();
        $visitData = $this->visitService->updateStatus(data: $data, visit: $visit);
        return back()->with('success', 'Visit status updated.');
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
