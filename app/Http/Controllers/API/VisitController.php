<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteVisitRequest;
use App\Http\Requests\ShowVisitRequest;
use App\Http\Requests\UpdateVisitStatusRequest;
use App\Http\Resources\VisitResource;
use App\Models\Visit;
use App\Services\VisitService;
use Illuminate\Http\Request;

class VisitController extends Controller
{

     public function __construct(protected VisitService $visitService)
     {

     }
    /**
     * Display a listing of the resource.
     */
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
    public function show(ShowVisitRequest $request, Visit $visit)
    {
        $data = $request->afterValidation();
        $visitData = $this->visitService->show(data: $data, withes: ['doctor.specialty', 'samples.brand', 'notes']);
        $visitData = VisitResource::make($visitData);
        return $this->answer(VisitResource::make($visitData));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdateVisitStatusRequest $request, Visit $visit)
    {
          $data = $request->afterValidation();
          $visitData = $this->visitService->updateStatus(data: $data, visit: $visit);
          return $this->answer(message: 'Visit status updated.', data:VisitResource::make($visitData));
    }

    public function completeVisit(CompleteVisitRequest $request, Visit $visit)
    {
        $data = $request->afterValidation();

        $updatedVisit = $this->visitService->completeVisit(data: $data, visit: $visit);

        return $this->answer(
            message: 'Visit completed successfully.',
            data: VisitResource::make($updatedVisit)
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
