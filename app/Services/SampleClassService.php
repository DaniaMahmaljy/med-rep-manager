<?php

namespace App\Services;

use App\Models\SampleClass;

class SampleClassService extends Service
{
    public function all($data = [], $withes = [], $paginated = true)
    {
        $query = SampleClass::when(isset($data['search']), function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['search']}%");
        })->with($withes)->latest();
        if($paginated)
            return $query->paginate();
        return $query->get();
    }
}
