<?php

namespace App\Http\Resources;

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
            'samples' => SampleResource::collection($this->whenLoaded('samples')),
            'scheduled_at' => $this->scheduled_at->toDateTimeString(),
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
        ];
    }
}
