<?php

namespace App\Http\Requests;

use App\Types\Payments\PeriodType;
use Illuminate\Foundation\Http\FormRequest;

class AgentPlanRequest extends FormRequest
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
        $billingMethods = implode(',', PeriodType::billingMethods());

        return [
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:plans,id',
            'referred_by_id' => 'nullable|exists:users,id',
            'billing_occurrence' => 'required|in:'.$billingMethods,
            'payment_type' => 'required|in:Online,Manual',
            'amount' => 'required|min:0',

        ];
    }
}
