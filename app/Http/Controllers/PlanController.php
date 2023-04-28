<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentPlanRequest;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanholderResource;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function addPlan(AgentPlanRequest $request)
    {
        $user_plan_uuid = Str::orderedUuid();
        $planholder = User::findOrFail($request->user_id);
        $plan = Plan::findOrFail($request->plan_id);

        $planholder->userPlans()
        ->attach($plan, array_merge($request->except('plan_id', 'payment_type', 'amount'), [
            'user_plan_uuid' => $user_plan_uuid,
        ]));

        $userPlan = UserPlan::where('user_plan_uuid', $user_plan_uuid)->first();

        $planholder->subscribeToPlan($userPlan, (int) $request->amount, (string) $request->payment_type, $planholder);

        return response()->json([
            'data' => new PlanholderResource($planholder),
            'message' => 'success',
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => PlanResource::collection(Plan::query()->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        return response()->json([
            'data' => new PlanResource(Plan::create($request->validated())),
            'message' => 'success',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());

        return response()->json([
            'data' => new PlanResource($plan),
            'message' => 'success',
        ], 200);
    }
}
