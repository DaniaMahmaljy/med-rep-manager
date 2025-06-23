<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoteRequest;
use App\Models\Visit;
use App\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    public function __construct(protected NoteService $noteService)
     {

     }

    public function store(StoreNoteRequest $request, Visit $visit)
    {
        $this->authorize('addNote', $visit);

        $data = $request->afterValidation();

        $this->noteService->createForVisit(visit: $visit, data: $data);

        return back()->with('success', __('local.Note added successfully.'));
    }
}
