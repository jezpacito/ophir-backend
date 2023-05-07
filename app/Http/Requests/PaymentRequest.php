<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'user_plan_uuid' => 'required|exists:user_plan,user_plan_uuid',
            'amount' => 'required|integer|min:0',
            'payment_type' => 'required|in:Online,Manual',
        ];
    }
}
