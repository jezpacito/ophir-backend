<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Api\SanctumController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanholderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::get('upload-profile', function () {
    User::first()
    ->addMedia(public_path('demo/test2.jpg'))
    ->toMediaCollection('profile_image');
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    /*api resources*/
    Route::apiResource('users', UserController::class);
    Route::apiResource('branches', BranchController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('beneficiaries', BeneficiaryController::class);
    Route::apiResource('plans', PlanController::class);

    /*single route apis*/
    Route::post('add-plan', [AgentController::class, 'addPlan']);
    Route::post('upload-image/{user}', [UserController::class, 'uploadImage']);

    /*users controllers*/
    Route::controller(UserController::class)->group(function () {
        Route::get('users-branch/{branch_id}', 'userBranch');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::get('account-details', 'accountDetails');
        Route::get('referral-tree', 'referralTree');
        Route::put('switch-account', 'switchAccount');
    });

    Route::controller(PlanholderController::class)->group(function () {
        Route::get('planholders', 'index');
        Route::post('planholders', 'store');
        Route::post('register-as-agent', 'registerAsAgent');
    });
});
