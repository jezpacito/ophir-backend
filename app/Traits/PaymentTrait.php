<?php

namespace App\Traits;

use App\Models\Payment;
use App\Types\Payments\PaymentType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait PaymentTrait
{
    protected $amount;

    private function processPayment(string $paymentType, int $amount)
    {
        if ($paymentType === PaymentType::MANUAL->label() && $amount >= 0) {
            $code = PaymentType::MANUAL_CODE->label();

            return uniqid($code.'-');
        }
        if ($paymentType === PaymentType::ONLINE->label() && $amount >= 0) {
            $code = PaymentType::ONLINE_CODE->label();

            return uniqid($code.'-');
        }
    }

    public function paymentMethod(object $userPlan, int $amount, string $paymentType, object $planholder)
    {
        $referenceNumber = $this->processPayment($paymentType, $amount);
        Log::info('referenceNumber: '.$referenceNumber);

        $payment = Payment::create([
            'user_id' => $planholder->id,
            'payment_uuid' => Str::orderedUuid(),
            'user_plan_id' => $userPlan->id,
            'amount' => encrypt($amount),
            'referrence_number' => $referenceNumber,
        ]);

        Log::info('payment created: '.$payment);

        return $payment;

    }
}
