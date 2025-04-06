<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'update_at'];

    public function samples()
    {
        return $this->hasMany(Sample::class);
    }

}
