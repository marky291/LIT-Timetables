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
            'id' => $this->id,
            'campus' => $this->campus_id,
            'department_id' => $this->department_id,
            'course' => $this->name,
            'identifier' => $this->identifier,
            'group' => $this->group,
            'year' => $this->year,
            'timetable' => sprintf(config('services.lit.relay.timetable.route'), $this->identifier, ''),
        ];
    }
}
