<?php

namespace App\Models;

use App\Enums\SampleUnitEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Sample extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes;
    use Translatable;

    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $translatedAttributes = ['name', 'description'];


    protected $cast =
    [
        'unit' => SampleUnitEnum::class
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function sampleClass()
    {
        return $this->belongsTo(SampleClass::class);
    }

    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'sample_visit');
    }


}
