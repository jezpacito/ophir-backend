<?php

namespace App\Observers;

use App\Models\Payment;
use App\Types\Payments\PaymentStatus;
use Illuminate\Support\Str;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @return void
     */
    public function created(Payment $payment)
    {
        $payment->payment_uuid = Str::uuid();
        $payment->status = PaymentStatus::PREAPPROVED->label();
        $payment->save();
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
