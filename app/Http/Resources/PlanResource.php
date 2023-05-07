<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'name' => $this->name,
            'description'=> $this->description,
            'commission'=> $this->commission,
            'is_active'=> $this->is_active,
            'term_period'=> $this->term_period,
            'contestability_period'=> $this->contestability_period,
            'is_transferrable'=> $this->is_transferrable,
            'pricing'=> json_decode($this->pricing),
            'contract_price'=> $this->contract_price,
        ];
    }
}
