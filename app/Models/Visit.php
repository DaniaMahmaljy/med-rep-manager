<?php

namespace App\Models;

use App\Enums\VisitStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'update_at'];


    protected $casts = [
        'status' => VisitStatusEnum::class,
        'scheduled_at' => 'datetime',

    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function representative()
    {
        return $this->belongsTo(Representative::class);
    }

    public function samples()
    {
        return $this->belongsToMany(Sample::class, 'sample_visit');
    }

    public function tickets() {
        return $this->morphMany(Ticket::class, 'ticketable');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function scopeVisibleTo($query, $user)
    {
        if ($user->hasRole('supervisor')) {
            return $query->whereHas('representative.supervisor.user', function ($q) use ($user) {
                return $q->where('id', $user->id);
        });
        }
        return $query;
    }

}
