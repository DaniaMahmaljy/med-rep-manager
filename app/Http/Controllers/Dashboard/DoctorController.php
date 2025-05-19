<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignSupervisorsRequest;
use App\Http\Requests\IndexDoctorRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctor;
use App\Services\DoctorService;
use App\Services\MunicipalService;
use App\Services\SpecialtyService;
use App\Services\SupervisorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(protected DoctorService $doctorService, protected MunicipalService $municipalService, protected SpecialtyService $specialtyService, protected SupervisorService $supervisorService)
    {

    }


    /**
     * Display a listing of the resource.
     */

    public function index(IndexDoctorRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->doctorService->getDoctorsDataTable($filters);
        }
      $supervisors =  $this->supervisorService->all(withes:['user'], paginated: false);
       return view('doctors.index',compact('supervisors'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $municipals = $this->municipalService->all(paginated: false);
        $specialties = $this->specialtyService->all(paginated: false);

        return view('doctors.create', compact('municipals','specialties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();
        $doctor = $this->doctorService->store($data);
        return redirect()->route('doctors.create')
        ->with('success',  __('local.Doctor created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = $this->doctorService->show(id: $id,  withes: ['visits','specialty', 'municipal.city','supervisors.user']);
        $this->authorize('view', $doctor);

        return view('doctors.show',compact('doctor'));
    }


    public function statistics(Doctor $doctor)
    {
        $stats = $this->doctorService->getDoctorStatistics($doctor);
        return response()->json($stats);
    }

    public function assignSupervisors(AssignSupervisorsRequest $request, Doctor $doctor)
    {
        $data = $request->validated();

        $this->doctorService->assignSupervisors($doctor,$data);

        return response()->json(['message' => 'Updated successfully']);
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
