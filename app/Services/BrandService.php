<?php

namespace App\Services;

use App\Models\Brand;

class BrandService extends Service
{
    public function all($data = [], $withes = [], $paginated = true)
    {
        $query = Brand::when(isset($data['search']), function ($query) use ($data) {
            return $query->where('name', 'like', "%{$data['search']}%");
        })->with($withes)->latest();
        if($paginated)
            return $query->paginate();
        return $query->get();
    }
}
