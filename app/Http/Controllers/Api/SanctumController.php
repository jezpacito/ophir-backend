<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SanctumController extends Controller
{
    public function store(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            dd('ss');

            return response('Login invalid', 503);
        }
        $sanctumToken = $user->createToken($request->username)->plainTextToken;

        return response()->json([
            'sanctumToken' => $sanctumToken,
        ], 200);
    }
}
