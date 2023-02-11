<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeneficiaryRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'firstname' => 'required|string|max:255',
                'middlename' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'relationship' => 'required|string|max:255',
                'birthdate' => 'required|date_format:Y-m-d',
                'user_id' => 'required|exists:users,id',
            ];
        }

        return [
            'firstname' => 'sometimes|string|max:255',
            'middlename' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'relationship' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|date_format:Y-m-d',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }
}
