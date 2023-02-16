<?php

namespace App\Observers;

use App\Models\Beneficiary;

class BenefeciaryObserver
{
    /**
     * Handle the Beneficiary "created" event.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return void
     */
    public function created(Beneficiary $beneficiary)
    {
    }

    /**
     * Handle the Beneficiary "updated" event.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return void
     */
    public function updated(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Handle the Beneficiary "deleted" event.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return void
     */
    public function deleted(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Handle the Beneficiary "restored" event.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return void
     */
    public function restored(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Handle the Beneficiary "force deleted" event.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return void
     */
    public function forceDeleted(Beneficiary $beneficiary)
    {
        //
    }
}
