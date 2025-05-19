<?php

namespace App\Services;

use App\Models\Specialty;

class SpecialtyService extends Service
{
    public function all($data = [], $withes = [], $paginated = true)
    {
        $query = Specialty::when(isset($data['search']), function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['search']}%");
        })->with($withes)->latest();
        if($paginated)
            return $query->paginate();
        return $query->get();
    }
}
