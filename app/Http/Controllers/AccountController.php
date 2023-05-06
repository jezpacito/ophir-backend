<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\ActivateAgentAccountRequest;
use App\Http\Requests\TransferPlanRequest;
use App\Http\Resources\PlanholderResource;
use App\Http\Resources\UserPlanResource;
use App\Http\Resources\UserResource;
use App\Models\PaymentAccountRegistration;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Response;

class AccountController extends Controller
{
    public function activateAgentAccount(ActivateAgentAccountRequest $request)
    {
        $planholder = User::findOrFail($request->user_id);
        //creating agent account
        $planholder->roles()->attach(Role::ofName(ROLE::ROLE_AGENT), [
            'is_active' => false,
        ]);

        //adding payment
        PaymentAccountRegistration::create($request->validated());

        return response()->json([
            'data' => new PlanholderResource(auth()->user()),
        ]);
    }

    public function transferPlan(TransferPlanRequest $request)
    {
        $userPlan = UserPlan::where('user_plan_uuid', $request->user_plan_uuid)->first();
        if (! $userPlan->plan->is_transferrable) {
            return Response::json([
                'success' => false,
                'message' => 'Plan is Non-Transferrable!',
            ], 422);
        }

        $userPlan->update([
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'data' => new UserPlanResource($userPlan),
        ]);
    }

    public function referralTree()
    {
        $referrals = UserPlan::with('user.roles')
            ->ofReferredBy(auth()->user()->id)->paginate(20);

        return UserPlanResource::collection($referrals)->response()->getData(true);
    }

    public function accountDetails()
    {
        $userRoles = User::ofRoles(Role::$role_users)
            ->where('id', auth()->user()->id)
            ->exists();

        if (! $userRoles) {
            return response()->json([
                'data' => new PlanholderResource(auth()->user()),
            ]);
        }

        return response()->json([
            'data' => new UserResource(auth()->user()),
        ]);
    }

    public function switchAccount(AccountRequest $request)
    {
        $userRoleAccount = UserRole::where([
            'user_id' => auth()->user()->id,
            'role_id' => $request->role_id,
            'is_active' => false,
        ])
            ->first();

        $userActiveAccount = UserRole::active()
            ->first();

        FacadesDB::transaction(function () use ($userActiveAccount, $userRoleAccount) {
            $userActiveAccount->update([
                'is_active' => false,
            ]);
            $userRoleAccount->update([
                'is_active' => true,
            ]);
        });

        return response()->json([
            'data' => new PlanholderResource(auth()->user()),
        ]);
    }
}
