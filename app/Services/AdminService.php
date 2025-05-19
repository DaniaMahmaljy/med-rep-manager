<?php

namespace App\Services;

use App\Models\Admin;
use Yajra\DataTables\DataTables;


class AdminService extends Service
{

    public function __construct( protected DataTables $dataTables)
    {

    }



    public function getAdminsDataTable($filters)
    {

        $search = $filters['search'];

        $query = Admin::with('user')->latest();

        if ($search) {
            $searchTerm = '%' . str_replace(' ', '%', $search) . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('user', function($q2) use ($searchTerm) {
                    $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                    ->orWhere('first_name', 'LIKE', $searchTerm)
                    ->orWhere('last_name', 'LIKE', $searchTerm);
                });
        });
    }
        return $this->dataTables->eloquent($query)
            ->addColumn('name', fn($r) => $r->user->full_name ?? 'N/A')
            ->addColumn('username', fn($r) => $r->user->full_name ?? 'N/A')
            ->addColumn('email', fn($r) => $r->user->email ?? 'N/A')
            ->toJson();
    }
}




