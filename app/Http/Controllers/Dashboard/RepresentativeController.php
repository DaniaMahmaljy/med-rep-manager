<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRepresentativeRequest;
use App\Models\Representative;
use App\Services\RepresentativeService;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

      public function __construct(protected RepresentativeService $representativeService)
     {

     }

    public function index(IndexRepresentativeRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->representativeService->getRepresentativesDataTable($filters);
        }
       return view('representatives.index');
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
