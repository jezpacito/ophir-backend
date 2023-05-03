<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public function generateAccountNumber($user)
    {
        $prefix = 'ACCT-BR'.$user->branch?->branch_number;
        $referralCode = Str::random(8); //referral code
        $date = date('Ymd');

        $code = "{$prefix}-{$date}-{$referralCode}";
        $user->referral_code = $referralCode;
        $user->user_uuid = $code;
    }

    /**
     * Handle the User "created" event.
     *
     * @return void
     */
    public function created(User $user)
    {
        $usernameCheck = User::whereNull('username')->exists();

        $this->generateAccountNumber($user);

        if ($usernameCheck) {
            $username = strtolower(substr($user->firstname, 0, 1).$user->middlename.'.'.$user->lastname);
            $query = User::where('username', $username);
            if ($query->exists()) {
                $username = $username.$query->count();
            }
            $user->username = $username;
            $user->save();
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
