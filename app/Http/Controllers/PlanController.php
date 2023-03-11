<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentPlanRequest;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanholderResource;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use App\Models\User;

class PlanController extends Controller
{
    public function addPlan(AgentPlanRequest $request)
    {
        $planholder = User::findOrFail($request->user_id);
        $plan = Plan::findOrFail($request->plan_id);

        $planholder->userPlans()
        ->attach($plan, $request->except('plan_id'));

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
