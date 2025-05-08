<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Specialty extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $translatedAttributes = ['name', 'description'];


    public function doctors()
    {
        $this->hasMany(Doctor::class);
    }

    public function samples()
    {
        return $this->belongsToMany(Sample::class, 'sample_specialty');
    }


}
