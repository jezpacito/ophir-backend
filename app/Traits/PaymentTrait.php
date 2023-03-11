<?php

namespace App\Traits;

use App\Models\Payment;
use Illuminate\Support\Str;

trait PaymentTrait
{
    protected $amount;

    private function processPayment(string $paymentType, int $amount)
    {
        if ($paymentType === 'Manual' && $amount > 0) {
            $code = Payment::MANUAL_PAYMENT;

            return uniqid($code.'-');
        }
        if ($paymentType === 'Online' && $amount > 0) {
            $code = Payment::ONLINE_PAYMENT;

            return uniqid($code.'-');
        }
    }

    public function subscribeToPlan(int $userPlan, int $amount, string $paymentType, int $planholder)
    {
        $referenceNumber = $this->processPayment($paymentType, $amount);
        Payment::create([
            'user_id' => $planholder,
            'payment_uuid' => Str::orderedUuid(),
            'user_plan_id' => $userPlan,
            'amount' => encrypt($amount),
            'referrence_number' => $referenceNumber,
        ]);
    }
}
