<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\User;

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

    public function planholderPayments(User $planholder)
    {
        return PaymentResource::collection($planholder->payments()->paginate(12))->response()->getData(true);
    }
}
