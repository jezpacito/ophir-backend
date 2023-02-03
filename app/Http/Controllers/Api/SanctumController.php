<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SanctumController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Login',
            ], 503);
        }
        $sanctumToken = $user->createToken($request->username)->plainTextToken;

        return response()->json([
            'data' => new UserResource($user),
            'sanctumToken' => $sanctumToken,
        ], 200);
    }
}
