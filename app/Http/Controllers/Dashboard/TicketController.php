<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTicketTableRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(protected TicketService $ticketService)
     {

     }

    public function index(IndexTicketTableRequest $request)
    {
        if ($request->ajax()) {
        $filters = $request->filters();
        return $this->ticketService->getTicketsDataTable($filters);
        }
       return view('tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $ticket = $this->ticketService->show(id: $id, withes: ['user','replies']);
         $this->authorize('view', $ticket);
        return view('tickets.show',compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     public function updateStatus(UpdateTicketStatusRequest $request, Ticket $ticket)
     {
        $data = $request->afterValidation();

        $ticket = $this->ticketService->updateStatus($data);

        return back()->with('success', 'Ticket status updated.');
    }

     public function active(Ticket $ticket)
    {
        $this->ticketService->active($ticket);

        return response()->noContent();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
