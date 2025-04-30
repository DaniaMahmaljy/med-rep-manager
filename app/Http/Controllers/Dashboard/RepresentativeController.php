<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRepresentativeRequest;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $representative = $this->representativeService->show(id: $id,  withes: ['visits', 'user', 'workingMunicipals','residingMunicipal.city','supervisor']);
        return view('representatives.show',compact('representative'));
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
