<?php

namespace App\Models;

use App\Enums\TicketPriorityEnum;
use App\Enums\TicketStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'update_at'];

    protected $casts = [
        'priority' => TicketPriorityEnum::class,
        'status' => TicketStatusEnum::class,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ticketable()
    {
        return $this->morphTo('ticketable');
    }

    public function replies() {
        return $this->hasMany(TicketReply::class);
    }

}
