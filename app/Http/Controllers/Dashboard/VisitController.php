<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRepVisitsRequest;
use App\Http\Requests\IndexVisitRequest;
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
        $visit = $this->visitService->show($id);
        return view('visits.show',compact('visit'));
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
