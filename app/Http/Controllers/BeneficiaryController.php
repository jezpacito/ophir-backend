<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeneficiaryRequest;
use App\Http\Resources\BeneficiaryResource;
use App\Models\Beneficiary;

class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => BeneficiaryResource::collection(Beneficiary::query()->take(Beneficiary::ALLOWED_BENEFICIARIES)->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BeneficiaryRequest $request)
    {
        return response()->json([
            'data' => new BeneficiaryResource(Beneficiary::create($request->validated())),
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
    public function update(BeneficiaryRequest $request, Beneficiary $beneficiary)
    {
        $beneficiary->update($request->validated());

        return response()->json([
            'data' => new BeneficiaryResource($beneficiary),
            'message' => 'success',
        ], 200);
    }
}
