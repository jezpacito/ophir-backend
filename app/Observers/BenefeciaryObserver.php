l<?php

namespace App\Observers;

use App\Models\Beneficiary;

class BenefeciaryObserver
{
    /**
     * Handle the Beneficiary "created" event.
     *
     * @return void
     */
    public function created(Beneficiary $beneficiary)
    {
    }

    /**
     * Handle the Beneficiary "updated" event.
     *
     * @return void
     */
    public function updated(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Handle the Beneficiary "deleted" event.
     *
     * @return void
     */
    public function deleted(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Handle the Beneficiary "restored" event.
     *
     * @return void
     */
    public function restored(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Handle the Beneficiary "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Beneficiary $beneficiary)
    {
        //
    }
}
