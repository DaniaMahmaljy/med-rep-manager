<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representative extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function residingMunicipal() // where the representative resides
    {
        return $this->belongsTo(Municipal::class, 'municipal_id');
    }


      public function workingMunicipals() //where the representative works
      {
          return $this->belongsToMany(Municipal::class, 'municipal_representative');
      }

      public function visits()
      {
        return $this->hasMany(Visit::class);
      }

      public function supervisor()
      {
        return $this->belongsTo(Supervisor::class);
      }

      public function tickets() {
        return $this->morphMany(Ticket::class, 'ticketable');
      }

      public function scopeVisibleTo($query, $user)
        {
            if ($user->hasRole('supervisor')) {
                return $query->where('supervisor_id', $user->userable_id);
            }
            return $query;
        }

}
