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

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $translatedAttributes = ['name', 'description'];


    protected $cast =
    [
        'unit' => SampleUnitEnum::class,
        'expiration_date' => 'date',
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
        return $this->belongsToMany(Visit::class, 'sample_visit')->withPivot([
            'quantity_assigned',
            'quantity_used',
            'status',
        ]);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'sample_specialty');
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity_available', '>', 0);
    }


}
