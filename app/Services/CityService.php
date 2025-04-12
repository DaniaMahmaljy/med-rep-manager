<?php

namespace App\Services;

use App\Models\City;

class CityService extends Service
{
    public function all($data = [], $withes = [], $paginated = true)
    {
        $query = City::when(isset($data['search']), function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['search']}%");
        })->with($withes)->latest();
        if($paginated)
            return $query->paginate();
        return $query->get();
    }
}
