<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:650',
            'price' => 'sometimes|integer|min:0',
            'term_period' => 'sometimes|min:0',
            'is_active' => 'sometimes|boolean',
            'is_transferrable' => 'sometimes|boolean',
            'commission' => 'sometimes|string',
        ];
    }
}
