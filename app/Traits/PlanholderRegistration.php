<?php

namespace App\Traits;

use App\Models\Beneficiary;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Types\Roles;
use Illuminate\Support\Facades\Log;

trait PlanholderRegistration
{
    public function registrationDetails($request, $planholder, $user_plan_uuid)
    {
        if ($request->role === Roles::PLANHOLDER->label()) {
            /* creating beneficiaries of planholders */
            foreach ($request->beneficiaries as $beneficiary) {
                Beneficiary::create(array_merge(['user_id' => $planholder->id], $beneficiary));

                Log::info('beneficiary creation: '.json_encode($beneficiary));
            }

            /* create plan for planholder */
            $plan = Plan::findOrFail($request->plan_id);

            /* default: pending role for approval account*/
            if ($planholder->roles()->count() <= 1) {
                $is_active = true;
            }

            /* attach role to user planholder */
            $planholder->roles()->attach(Role::ofName($request->role)->id, [
                'is_active' => $is_active,
            ]);

            $referred_by = User::first(); //ophir company
            if ($request->referral_code) {
                $referred_by = User::whereReferralCode($request->referral_code)->first();
                Log::info('referred_by : '.$referred_by);
            }

            $planholder->userPlans()->attach($plan,
                [
                    'billing_occurrence' => $request->billing_occurrence,
                    'referred_by_id' => $referred_by->id,
                    'user_plan_uuid' => $user_plan_uuid,
                ]);

            Log::info('attached plan : ');

            /**create agent account for planholder REMOVE*/
            // $planholder->roles()->attach(Role::ofName(Roles::AGENT), [
            //     'is_active' => false,
            // ]);
            // Log::info('created agent accountfor planholder '.json_encode($planholder));
        }
    }
}
