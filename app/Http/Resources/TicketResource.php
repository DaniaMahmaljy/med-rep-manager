<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status->label(),
            'priority'    => $this->priority->label(),
            'created_at'  => $this->created_at->toDateTimeString(),
            'user'        => UserSummaryResource::make($this->whenLoaded('user')),
            'replies' => TicketReplyResource::collection($this->whenLoaded('replies')),
            'ticketable' => $this->when($this->ticketable, function () use ($request) {
             return $this->getTicketableResource($request);
            }),
        ];
    }

    private function getTicketableResource(Request $request)
    {
        $model = $this->ticketable;

        if (! $model) {
            return null;
        }

        $isShowRoute = $request->routeIs('tickets.show');

        return match (get_class($model)) {
            \App\Models\Doctor::class => new DoctorSummaryResource($model),

            \App\Models\Visit::class  => new VisitResource($model),

            \App\Models\Representative::class => new RepresentativeResource($model),

            default => null,
        };
    }


}
