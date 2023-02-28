<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Resources\PlanholderResource;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB as FacadesDB;

class AccountController extends Controller
{
    public function referralTree()
    {
        $referrals = UserPlan::ofReferredBy(auth()->user()->id)->paginate(20);

        return response()->json([
            'data' => PlanholderResource::collection($referrals),
        ]);
    }

    public function accountDetails()
    {
        $adminRole = User::ofRoles(Role::$role_users)
        ->doesntExist();

        if ($adminRole) {
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
        $userRoleAccount = UserRole::findOrFail($request->role_account_id);
        $userActiveAccount = UserRole::where('user_id', auth()->user()->id)
        ->where('is_active', true)
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
