<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentPlanRequest;
use App\Http\Resources\PlanholderResource;
use App\Models\Plan;

class AgentController extends Controller
{
    public function addPlan(AgentPlanRequest $request)
    {
        $agent = auth()->user();
        $plan = Plan::findOrFail($request->plan_id);
        $agent->userPlans()
        ->attach($plan, $request->except('plan_id'));

        return response()->json([
            'data' => new PlanholderResource($agent),
        ]);
    }
}
