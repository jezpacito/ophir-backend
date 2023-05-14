<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' => 'sometimes|string|max:255',
            'middlename' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|max:255',
            'role' => 'sometimes|string|exists:roles,name',
            'branch_id' => 'nullable|exists:branches,id',
            'gender' => 'nullable|string|max:50',
            'birthdate' => 'nullable|date',
            'age' => 'nullable',
            'postal_code' => 'sometimes|string|max:255',
            'contact_no' => 'sometimes|string|max:255',
            'civil_status' => 'sometimes|string|max:255',
            'height' => 'sometimes|string|max:255',
            'weigth' => 'sometimes|string|max:255',
            'citizenship' => 'sometimes|string|max:255',
            'sponsor' => 'sometimes|string|max:255',
            'sss_number' => 'sometimes|string|max:255',
            'tin_number' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:255',
            'facebook' => 'sometimes|string|max:255',
            'messenger' => 'sometimes|string|max:255',
            'twitter' => 'sometimes|string|max:255',
        ];
    }
}
