<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class City extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = ['name'];

    protected $guarded = ['id', 'created_at', 'update_at'];

    public function municipals()
    {
        return $this->hasMany(Municipal::class);
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

}
