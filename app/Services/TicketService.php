<?php

namespace App\Services;

use App\Events\TicketCreated;
use App\Models\Ticket;
use App\Notifications\NewTicketNotification;
use DB;
use Yajra\DataTables\DataTables;

class TicketService extends Service
{

     public function __construct( protected DataTables $dataTables)
    {

    }

    public function all($data = [], $paginated = false, $withes = [])
    {
        $query = Ticket::with($withes)
        ->when(isset($data['user_id']), fn($q) => $q->where('user_id', $data['user_id']))
        ->when(isset($data['ticketable_type']), fn($q) =>
            $q->where('ticketable_type', $data['ticketable_type']))
        ->when(isset($data['ticketable_id']), fn($q) =>
            $q->where('ticketable_id', $data['ticketable_id']))
        ->when(isset($data['status']), fn($q) =>
            $q->where('status', $data['status']))
        ->when(isset($data['priority']), fn($q) =>
            $q->where('priority', $data['priority']))
        ->latest();

        if ($paginated) {
             return $query->paginate();
        }


        else {
            return  $query->get();
        }

    }

    public function store($data, $withes = [])
    {
        return DB::transaction(function () use ($data, $withes) {
            $ticket = Ticket::create($data);

            $representative = $ticket->user->userable;
            $supervisor = $representative->supervisor;

            $supervisor->user->notify(new NewTicketNotification($ticket));

            return Ticket::with($withes)->findOrFail($ticket->id);
        });

    }

    public function show($id, $withes)
    {
        return Ticket::with($withes)->findOrFail($id);
    }

  public function getTicketsDataTable($filters)
    {
        $groupBy = $filters['group_by'];
        $search = $filters['search'];
        $dateFrom = $filters['date_from'];
        $dateTo = $filters['date_to'];
        $authUser = $filters['auth_user'];

        $query = Ticket::with(['user'])->visibleTo($authUser);

           $query->when($search, function($query) use ($search) {
                $searchTerm = '%' . str_replace(' ', '%', $search) . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('user', function($q2) use ($searchTerm) {
                        $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                           ->orWhere('first_name', 'LIKE', $searchTerm)
                           ->orWhere('last_name', 'LIKE', $searchTerm);
                    });
                });
            })
            ->when($dateFrom, function ($q) use ($dateFrom) {
                 return $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                return $q->whereDate('created_at', '<=', $dateTo);
            })

        ->when($groupBy === 'user', function($query) {
            $query->orderBy('user_id');
        })
         ->when($groupBy === 'created_at', function($query) {
               $query ->orderBy('created_at','DESC');
            })
         ->when($groupBy === 'status', function($query) {
               $query ->orderBy('status');
            })
         ->when($groupBy === 'priority', function($query) {
               $query ->orderBy('priority');
            })

         ->latest();

        return $this->dataTables->eloquent($query)
            ->addColumn('user', function($t) {
                return $t->user->full_name ?? 'N/A';
            })
            ->addColumn('title', function($t) {
                return $t->title ?? 'N/A';
            })

            ->addColumn('created_at', function($t) {
                 $format = app()->getLocale() === 'ar' ? 'j F Y H:i' : 'Y-m-d H:i';
                return $t->created_at->translatedFormat($format);
            })

            ->addColumn('status', function($t) {
            return '<span class="badge bg-light-'.$t->status->color().'">'.$t->status->label().'</span>';
            })

            ->addColumn('priority', function($t) {
            return '<span class="badge bg-light-'.$t->priority->color().'">'.$t->priority->label().'</span>';
            })

          ->addColumn('action', function($t) {
            $icon = app()->getLocale() === 'ar' ? 'bi-box-arrow-up-left' : 'bi-box-arrow-up-right';
            return '<a href="'.route('tickets.show', $t->id).'"><i class="bi ' . $icon . '"></i></a>';
          })

        ->rawColumns(['title','status', 'priority', 'action'])
        ->toJson();
    }

    public function updateStatus($data)
    {
      $ticket = Ticket::findOrFail($data['ticket_id']);
      $ticket->update(['status' => $data['status']]);

      return $ticket;
    }


}
