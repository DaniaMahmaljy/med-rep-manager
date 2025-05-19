<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexSupervisorRequest;
use App\Services\SupervisorService;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
     public function __construct(protected SupervisorService $supervisorService)
     {

     }

    public function index(IndexSupervisorRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->supervisorService->getSupervisorsDataTable($filters);
        }
       return view('supervisors.index');
    }
}
