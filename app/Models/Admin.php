<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id', 'created_at', 'update_at'];


    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
