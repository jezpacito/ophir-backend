<?php

namespace App\Traits;

use App\Models\Beneficiary;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;

trait PlanholderRegistration
{
    public function registrationDetails($request, $planholder, $user_plan_uuid)
    {
        if ($request->role === Role::ROLE_PLANHOLDER) {
            /* creating beneficiaries of planholders */
            foreach ($request->beneficiaries as $beneficiary) {
                Beneficiary::create(array_merge(['user_id' => $planholder->id], $beneficiary));
            }

            /* create plan for planholder */
            $plan = Plan::findOrFail($request->plan_id);

            /* is_active column for switching account roles
             *  whoevers has a is_active===true user_role
             * would be the default profile after login
             *
             * NOTE: should only have one is_active status in user roles
             */

            $is_active = true;
            if ($planholder->userPlans()->count() >= 1) {
                /* is_active column in user_role table */
                $is_active = false;
            }

            /* attach role to user planholder */
            $planholder->roles()->attach(Role::ofName($request->role)->id, [
                'is_active' => $is_active,
            ]);

            $referred_by = User::first(); //ophir company
            if ($request->referral_code) {
                $referred_by = User::whereReferralCode($request->referral_code)->first();
            }

            $planholder->userPlans()->attach($plan,
                [
                    'billing_occurrence' => $request->billing_occurrence,
                    'referred_by_id' => $referred_by->id,
                    'user_plan_uuid' => $user_plan_uuid,
                ]);

            /**create agent account for planholder */
            $planholder->roles()->attach(Role::ofName(ROLE::ROLE_AGENT), [
                'is_active' => false,
            ]);
        }
    }
}
