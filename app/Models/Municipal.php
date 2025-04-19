<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Municipal extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $translatedAttributes = ['name'];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }


    public function residingRepresentatives()   // where the representatives reside
    {
        return $this->hasMany(Representative::class);
    }


     public function workingRepresentatives() // where the representative works
     {
         return $this->belongsToMany(Representative::class, 'municipal_representative');
     }

}
