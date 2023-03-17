<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    $userCreated = User::first()->created_at->toDateString();
    $userCreateDateParse = Carbon::parse($userCreated);
    // dd($userCreateDateParse);
    // dd($userCreatedDate);
    $lastMonthDate = now()->subMonth()->toDateString();
    $lastMonthDateParse = Carbon::parse($lastMonthDate);

    $result = $userCreateDateParse->eq($lastMonthDateParse);
    dd($result);
});
