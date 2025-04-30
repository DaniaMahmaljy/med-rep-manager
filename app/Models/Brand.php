<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Brand extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes;
    use Translatable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $translatedAttributes = ['name', 'description'];

    public function samples()
    {
        return $this->hasMany(Sample::class);
    }

}
