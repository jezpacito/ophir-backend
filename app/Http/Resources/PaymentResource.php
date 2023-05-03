<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id' => $this->id,
            'user' => new UserResource($this->planholder),
            'user_plan_id' => new UserPlanResource($this->userPlan),
            'payment_uuid' => $this->payment_uuid,
            'amount' => $this->amount,
            'referrence_number' => $this->referrence_number,
            'is_paid' => $this->is_paid,
            'created_at' => $this->created_at,
        ];
    }
}
