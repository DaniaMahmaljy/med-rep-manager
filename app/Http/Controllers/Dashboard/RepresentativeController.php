<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRepresentativeRequest;
use App\Http\Requests\UpdateRepresentativeAssignmentsRequest;
use App\Models\Representative;
use App\Services\MunicipalService;
use App\Services\RepresentativeService;
use App\Services\SupervisorService;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      public function __construct(protected RepresentativeService $representativeService, protected MunicipalService $municipalService, protected SupervisorService $supervisorService)
     {

     }

    public function index(IndexRepresentativeRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->representativeService->getRepresentativesDataTable($filters);
        }

        $municipals = $this->municipalService->all(paginated: false);
        $supervisors =  $this->supervisorService->all(withes:['user'], paginated: false);
       return view('representatives.index', compact('municipals','supervisors'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $representative = $this->representativeService->show(id: $id,  withes: ['visits', 'user', 'workingMunicipals','residingMunicipal.city','supervisor']);
        $this->authorize('view', $representative);
        return view('representatives.show',compact('representative'));
    }

    public function todayVisits(Representative $representative)
    {
        $this->authorize('view', $representative);
        $visits = $this->representativeService->getTodayVisits($representative);

        return view('representatives.partials.visits-table', compact($representative, $visits));
    }


public function statistics(Representative $representative)
{
    $this->authorize('view', $representative);

    $stats = $this->representativeService->getStatistics($representative);

    return response()->json($stats);
}


public function updateAssignments(UpdateRepresentativeAssignmentsRequest $request, Representative $representative, )
{
    $data = $request->validated();
    $service = $this->representativeService->updateAssignments($representative,$data);

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
