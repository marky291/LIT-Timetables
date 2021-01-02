<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Schedule extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'module' => $this->module->name,
            'lecturer' => $this->lecturer->fullname,
            'room' => $this->room->door,
            'starting_timestamp' => $this->starting_date,
            'ending_timestamp' => $this->ending_date,
            'type' => $this->type->abbreviation,
        ];
    }
}
