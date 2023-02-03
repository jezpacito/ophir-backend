<?php

use App\Http\Controllers\Api\SanctumController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\StaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [SanctumController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('branches', BranchController::class);
    Route::apiResource('staffs', StaffController::class);
});
