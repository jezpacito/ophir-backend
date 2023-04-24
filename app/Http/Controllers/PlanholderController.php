<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanholderRequest;
use App\Http\Requests\RegisterAsAgentRequest;
use App\Http\Resources\PlanholderResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use App\Notifications\SendCredentials;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PlanholderController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => PlanholderResource::collection(User::ofRoles([Role::ROLE_PLANHOLDER])->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanholderRequest $request)
    {
        $password = Str::random(12);
        $user_plan_uuid = Str::orderedUuid();

        $planholder = DB::transaction(function () use ($password, $request, $user_plan_uuid) {
            $planholder = User::create(array_merge($request->except('role', 'beneficiaries', 'plan_id', 'billing_occurrence', 'referred_by_id', 'payment_type', 'amount'),
                [
                    'password' => $password,
                    'is_verified' => $request->referral_code ? false : true,
                ]));

            /* Will send planholder credentials thru email */
            $credentials = ['username' => $planholder->username, 'password' => $password];
            $planholder->notify(new SendCredentials($credentials));
            Log::info('planholder credentials sent: '.$planholder->username.' pass: '.$password);


            $planholder->registrationDetails($request, $planholder, $user_plan_uuid);

            return $planholder;
        });

        /* subscription */
        try {
            $userPlan = UserPlan::whereUserPlanUuid($user_plan_uuid)->first();
            $planholder->subscribeToPlan($userPlan, (int) $request->amount, (string) $request->payment_type, $planholder);
        } catch (\Exception $e) {
            Log::error($e);
        }

        return response()->json([
            'data' => new PlanholderResource($planholder),
            'message' => 'success',
        ], 201);
    }

    public function registerAsAgent(RegisterAsAgentRequest $request)
    {
        $planholder = User::findOrFail($request->user_id);
        $planholder->roles()->attach(Role::ofName($request->role), [
            'is_active' => false,
        ]);

        return response()->json([
            'data' => new PlanholderResource($planholder),
            'message' => 'success',
        ], 201);
    }
}
