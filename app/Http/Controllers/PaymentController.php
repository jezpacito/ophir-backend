<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserPlan;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PaymentResource::collection(Payment::paginate(12))->response()->getData(true);
    }

    //get all payments regardless of what time of plan
    public function planholderPayments(User $planholder)
    {
        return PaymentResource::collection($planholder->payments()->paginate(12))->response()->getData(true);
    }

    //get payment history base on plan
    public function planPayments(string $user_plan_uuid)
    {
        $userPlan = UserPlan::where('user_plan_uuid', $user_plan_uuid)->first();

        return PaymentResource::collection($userPlan->payments()->paginate(12))->response()->getData(true);
    }
}
