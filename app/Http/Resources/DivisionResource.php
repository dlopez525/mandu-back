<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
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
            'key' => $this->id,
            'name' => $this->name,
            'level' => $this->level,
            'number_collaborators' => $this->number_collaborators,
            'super_division_id' => $this->super_division_id,
            'superior_division' => $this->super_division_id != null ? $this->superDivision->name : '-',
            'ambassador_id' => $this->ambassador_id,
            'ambassador' => $this->ambassador->name,
            'sub_divisions' => SubDivisionResource::collection($this->subDivisions)
        ];
    }
}
