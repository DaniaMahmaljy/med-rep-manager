<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
class TicketController extends Controller
{
    public function __construct(private TicketService $ticketService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexTicketRequest $request)
    {
        $data = $request->afterValidation();
        $tickets = $this->ticketService->all(data: $data, paginated: true, withes: ['ticketable']);
        return $this->answer(data: TicketResource::collection($tickets));
    }

    /**
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $data = $request->afterValidation();
        $ticket = $this->ticketService->store($data);
        return $this->answer(data: TicketResource::make($ticket));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $ticket = $this->ticketService->show(id: $id, withes: ['replies.user']);
         $this->authorize('view', $ticket);
        return $this->answer(data: TicketResource::make($ticket));
    }

    /**
     *
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
