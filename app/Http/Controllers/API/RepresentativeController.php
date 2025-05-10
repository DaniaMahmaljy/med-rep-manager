<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllRepVisitsRequest;
use App\Http\Requests\IndexRepresentativeVisits;
use App\Http\Resources\VisitResource;
use App\Models\Representative;
use App\Services\RepresentativeService;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    public function __construct(protected RepresentativeService $representativeService)
    {

    }

    /**
     * Display a listing of the resource.
     */

    public function allVisits(AllRepVisitsRequest $request )
    {
        $date = $request->afterValidation();
        $visits = $this->representativeService->allVisits(data: $date, withes: ['doctor:id,first_name,last_name']);
        return $this->answer(VisitResource::collection($visits));

    }



    public function todayVisits(AllRepVisitsRequest $request)
    {
        $date = $request->afterValidation();

        $visits = $this->representativeService->allVisits(data: $date, withes: ['doctor:id,first_name,last_name'], today: true);

         return $this->answer(VisitResource::collection($visits));
    }

    public function index()
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
