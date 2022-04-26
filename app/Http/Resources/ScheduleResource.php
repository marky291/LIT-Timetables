<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'course_id' => $this->course_id,
            'module_id' => $this->module_id,
            'room_id' => $this->room_id,
            'type_id' => $this->type_id,
            'academic_week' => $this->academic_week,
            'academic_year' => $this->academic_year,
            'starting_timestamp' => $this->starting_date,
            'ending_timestamp' => $this->ending_date,
        ];
    }
}
