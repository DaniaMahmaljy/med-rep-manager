<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexAdminRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(protected AdminService $adminService)
     {

     }

    public function index(IndexAdminRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->adminService->getAdminsDataTable($filters);
        }
       return view('admins.index');
    }
}
