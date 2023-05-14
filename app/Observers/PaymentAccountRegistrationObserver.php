<?php

namespace App\Observers;

use App\Models\PaymentAccountRegistration;
use App\Types\Payments\PaymentStatus;

class PaymentAccountRegistrationObserver
{
    /**
     * Handle the PaymentAccountRegistration "created" event.
     *
     * @return void
     */
    public function created(PaymentAccountRegistration $paymentAccountRegistration)
    {
        $paymentAccountRegistration->status = PaymentStatus::PREAPPROVED->label();
        $paymentAccountRegistration->save();
    }

    /**
     * Handle the PaymentAccountRegistration "updated" event.
     *
     * @return void
     */
    public function updated(PaymentAccountRegistration $paymentAccountRegistration)
    {
        //
    }

    /**
     * Handle the PaymentAccountRegistration "deleted" event.
     *
     * @return void
     */
    public function deleted(PaymentAccountRegistration $paymentAccountRegistration)
    {
        //
    }

    /**
     * Handle the PaymentAccountRegistration "restored" event.
     *
     * @return void
     */
    public function restored(PaymentAccountRegistration $paymentAccountRegistration)
    {
        //
    }

    /**
     * Handle the PaymentAccountRegistration "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(PaymentAccountRegistration $paymentAccountRegistration)
    {
        //
    }
}
