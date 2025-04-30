<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class SampleClass extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $translatedAttributes = ['name', 'description'];


    public function samples()
{
    return $this->hasMany(Sample::class);
}


}
