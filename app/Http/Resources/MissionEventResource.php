<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start,
            'end' => $this->end,
            'allDay' => (bool) $this->all_day, // Cast to boolean
            'extendedProps' => $this->extendedProps,
            'mission_type' => $this->mission_type,
            'city' => $this->city,
            'client' => $this->client,
            'calendar' => $this->calendar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
