<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Beneficiary;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendCredentials;
use DB;
use Illuminate\Http\Request;
use Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => UserResource::collection(User::query()->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $password = Str::random(12);

        $user = DB::transaction(function () use ($password, $request) {
            $user = User::create(array_merge($request->except('role', 'beneficiaries'), [
                'password' => $password,
                'role_id' => Role::ofName($request->role)->id,
            ]));
            $credentials = ['username' => $user->username, 'password' => $password];
            $user->notify(new SendCredentials($credentials));

            if ($request->role === Role::ROLE_PLANHOLDER) {
                foreach ($request->beneficiaries as $beneficiary) {
                    Beneficiary::create(array_merge(['user_id' => $user->id], $beneficiary));
                }
            }

            return $user;
        });

        return response()->json([
            'data' => new UserResource($user),
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
    public function update(Request $request, User $user)
    {
        $user = $user->update($request->all());

        return response()->json([
            'data' => new UserResource($user),
            'message' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(User $user, Request $request)
    {
        if ($request->profile_image) {
            $split = explode('/', $request->profile_image);
            $type = explode(';', $split[1])[0];

            $image = $request->profile_image;
            $imageName = Str::random(20).'.'.$type;

            $user->addMediaFromBase64(json_decode($image))
                ->usingFileName($imageName)
                ->toMediaCollection('profile_image');

            return response()->json([
                'data' => new UserResource($user),
                'message' => 'success',
            ], 200);
        }

        return response()->json([
            'message' => 'no image found on request!',
        ], 404);
    }
}
