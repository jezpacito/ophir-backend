<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

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

    //get all payments regardless of what type of plan
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

    /**
     * payment for planholders
     * get latest payment
     * paano ko malalaman ang
     *
     * @return void
     */
    public function makePayment(PaymentRequest $request)
    {
        $planholder = User::whereId($request->user_id)->first();
        /* subscription */
        try {
            $userPlan = UserPlan::whereUserPlanUuid($request->user_plan_uuid)->first();
            $payment = $planholder->paymentMethod($userPlan, (int) $request->amount, (string) $request->payment_type, $planholder);
        } catch (\Exception $e) {
            Log::error($e);
        }

        return Response::json([
            'message' => 'success',
            'data' => new PaymentResource($payment),
        ], 201);
    }
}
