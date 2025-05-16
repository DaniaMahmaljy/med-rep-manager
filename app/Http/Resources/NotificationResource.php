<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'title' => $this->data['title'] ?? 'Notification',
            'message' => $this->data['message'] ?? '',
            'type' => class_basename($this->type),
            'is_read' => !is_null($this->read_at),
            'created_at' => $this->created_at->toISOString(),
            'time_ago' => $this->created_at->diffForHumans(),
            'url' => $this->data['url'] ?? null,
            'meta' => [
            'icon' => $this->data['icon'] ?? 'bell',
            'color' => $this->data['color'] ?? 'primary'
            ]
        ];
    }
}
