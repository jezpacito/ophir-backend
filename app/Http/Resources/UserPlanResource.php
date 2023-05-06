<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPlanResource extends JsonResource
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
            'user' => $this->user,
            'plan' => $this->plan,
            'referred_by' => $this->referred_by,
            'profile_image' => $this->profile_image,
            'signature_image' => $this->signature_image,
            'roles' => $this->user->roles,
        ];
    }
}
