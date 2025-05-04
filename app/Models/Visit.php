<?php

namespace App\Models;

use App\Enums\VisitStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];


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
        return $this->belongsToMany(Sample::class, 'sample_visit')
        ->withPivot('status', 'quantity');
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
            return $query->whereHas('representative', function ($q) use ($user) {
                $q->where('supervisor_id', $user->userable_id);
            });
        }
        return $query;
    }

}
