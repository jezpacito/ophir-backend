<?php

namespace App\Traits;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;
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

    public function subscribeToPlan(object $userPlan, int $amount, string $paymentType, object $planholder)
    {
        $referenceNumber = $this->processPayment($paymentType, $amount);
        Log::info('referenceNumber: '.$referenceNumber);

        $payment = Payment::create([
            'user_id' => $planholder->id,
            'payment_uuid' => Str::orderedUuid(),
            'user_plan_id' => $userPlan->id,
            'amount' => encrypt($amount),
            'referrence_number' => $referenceNumber,
            'isPaid' => true,
        ]);

        Log::info('payemnt created: '.$payment);
    }
}
