<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketReplyRequest;
use App\Http\Resources\TicketReplyResource;
use App\Models\Ticket;
use App\Services\TicketReplyService;
use Illuminate\Http\Request;

class TicketReplyController extends Controller
{

    public function __construct(protected TicketReplyService $ticketReplyService)
     {

     }

     public function store(StoreTicketReplyRequest $request, Ticket $ticket)
    {
        $data = $request->afterValidation();

        $ticket = $this->ticketReplyService->store($data);

        return $this->answer(data: TicketReplyResource::make($ticket));

    }
}
