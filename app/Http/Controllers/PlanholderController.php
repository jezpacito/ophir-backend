<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanholderRequest;
use App\Http\Resources\PlanholderResource;
use App\Models\Beneficiary;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PlanholderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $planholder = DB::transaction(function () use ($password, $request) {
            $planholder = User::create(array_merge($request->except('role', 'beneficiaries', 'plan_id', 'billing_method', 'referred_by_id'),
                [
                    'password' => $password,
                ]));

            /* Will send planholder credentials thru email */
            $credentials = ['username' => $planholder->username, 'password' => $password];
            $planholder->notify(new SendCredentials($credentials));
            Log::info('planholder credentials sent: '.$planholder->username.' pass: '.$password);

            if ($request->role === Role::ROLE_PLANHOLDER) {
                /* creating beneficiaries of planholders */
                foreach ($request->beneficiaries as $beneficiary) {
                    Beneficiary::create(array_merge(['user_id' => $planholder->id], $beneficiary));
                }

                /* create plan for planholder */
                $plan = Plan::findOrFail($request->plan_id);

                /* is_active column for switching account roles
                 *  whoevers has a is_active===true user_role
                 * would be the default profile after login
                 *
                 * NOTE: should only have one is_active status in user roles
                 */

                $is_active = true;
                if ($planholder->userPlans()->count() >= 1) {
                    /* is_active column in user_role table */
                    $is_active = false;
                }

                /* attach role to user planholder */
                $planholder->roles()->attach(Role::ofName($request->role)->id, [
                    'is_active' => $is_active,
                ]);

                $planholder->userPlans()->attach($plan,
                    [
                        'billing_method' => $request->billing_method,
                        'referred_by_id' => $request->referred_by_id,
                    ]);
            }

            return $planholder;
        });

        return response()->json([
            'data' => new PlanholderResource($planholder),
            'message' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}