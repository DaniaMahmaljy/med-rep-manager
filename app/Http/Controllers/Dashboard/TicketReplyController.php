<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketReplyRequest;
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

        return back()->with('success', 'Reply added.');
    }
}
