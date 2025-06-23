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
        $reply = $this->ticketReplyService->store($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'reply' => $reply]);
        }

        return back()->with('success', 'Reply added.');
    }

}
