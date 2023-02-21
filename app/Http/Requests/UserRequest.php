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
        if ($this->isMethod('post')) {
            return [
                'firstname' => 'required|string|max:255',
                'middlename' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|unique:users,email|string|max:255',
                'role' => 'required|string|exists:roles,name',
                'branch_id' => 'nullable|exists:branches,id',
                'beneficiaries' => 'sometimes|array|min:1|max:2',
            ];
        }
    }
}
