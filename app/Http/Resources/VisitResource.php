<?php

namespace App\Http\Resources;

use App\Enums\SampleUnitEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'status' => $this->status->label(),
            'doctor' => DoctorResource::make($this->whenLoaded('doctor')),
            'scheduled_at' => $this->scheduled_at->toDateTimeString(),
            'actual_visit_time' => optional($this->actual_visit_time)->toDateTimeString(),
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
            'samples' => $this->whenLoaded('samples', function () {
                return $this->samples->map(function ($sample) {
                    return [
                        'id' => $sample->id,
                        'name' => $sample->name,
                        'brand' => $sample->brand ? [
                            'id' => $sample->brand->id,
                            'name' => $sample->brand->name
                        ] : null,
                        'quantity_assigned' => $sample->pivot->quantity_assigned,
                        'quantity_used' => $sample->pivot->quantity_used,
                         'status' => $sample->pivot->status
                    ];
                });
            }),
        ];
    }
}
