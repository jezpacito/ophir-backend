<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanholderResource;
use App\Models\Beneficiary;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendCredentials;
use DB;
use Illuminate\Support\Str;

class PlanholderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $password = Str::random(12);

        $planholder = DB::transaction(function () use ($password, $request) {
            $planholder = User::create(array_merge($request->except('role', 'beneficiaries'), [
                'password' => $password,
            ]));
            $credentials = ['username' => $planholder->username, 'password' => $password];
            $planholder->notify(new SendCredentials($credentials));

            if ($request->role === Role::ROLE_PLANHOLDER) {
                foreach ($request->beneficiaries as $beneficiary) {
                    Beneficiary::create(array_merge(['user_id' => $planholder->id], $beneficiary));
                }
            }

            return $planholder;
        });

        return response()->json([
            'data' => new PlanholderResource($planholder),
            'message' => 'success',
        ], 201);
    }
}
