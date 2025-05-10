<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->full_name,
            'specialty' => SpecialtyResource::make($this->whenLoaded('specialty')),
            'municipal'=> MunicipalResource::make($this->whenLoaded('municipal')),
            'phone' => $this->phone,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ], fn ($value) => !is_null($value));
    }

}
