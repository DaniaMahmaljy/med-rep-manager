<?php

namespace App\Services;

use App\Models\Supervisor;
use Yajra\DataTables\DataTables;

class SupervisorService extends Service
{

     public function __construct( protected DataTables $dataTables)
    {

    }

    public function all($data = [], $withes = [], $paginated = true)
    {
        $query = Supervisor::when(isset($data['search']), function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['search']}%");
        })->with($withes)->latest();
        if($paginated)
            return $query->paginate();
        return $query->get();
    }


      public function getSupervisorsDataTable($filters)
    {
        $search = $filters['search'];

        $query = Supervisor::with('user','city')
            ->latest();


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
    ->addColumn('username', fn($r) => $r->user->username ?? 'N/A')
    ->addColumn('city', fn($r) => $r->city->name ?? 'N/A')

      ->toJson();
    }
}
