<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $userRole = UserRole::whereIn('user_id', [$user->id])
        ->whereIn('role_id', [Role::ofName(User::ROLE_ADMIN)->id, Role::ofName(User::ROLE_BRANCH_ADMIN)->id])
        ->exists();


        if ($userRole) {
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
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
