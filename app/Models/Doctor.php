<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function municipal()
    {
        return $this->belongsTo(Municipal::class);
    }

    public function tickets() {
        return $this->morphMany(Ticket::class, 'ticketable');
    }


}
