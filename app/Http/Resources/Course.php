<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Course extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'location' => $this->location,
            'identifier' => $this->identifier,
            'course' => $this->name,
            'timetable' => sprintf(config('timetable.url.source'), $this->identifier, ""),
            'department' => new Department($this->whenLoaded('department')),
        ];
    }
}
