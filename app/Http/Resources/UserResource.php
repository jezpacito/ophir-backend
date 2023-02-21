<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'role' => $this->role,
            'beneficiaries' =>BeneficiaryResource::collection($this->beneficiaries),
            'branch' => $this->branch,
            'account_type' => $this->account_type,
            'username' => $this->username,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'age' => $this->age,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'contact_no' => $this->contact_no,
            'civil_status' => $this->civil_status,
            'height' => $this->height,
            'weigth' => $this->weigth,
            'citizenship' => $this->citizenship,
            'sponsor' => $this->sponsor,
            'sss_number' => $this->sss_number,
            'tin_number' => $this->tin_number,
            'status' => $this->status,
            'facebook' => $this->facebook,
            'messenger' => $this->messenger,
            'twitter' => $this->twitter,
            'email' => $this->email,
        ];
    }
}
