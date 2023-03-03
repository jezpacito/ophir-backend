<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Activity::all(),
        ]);
    }
}
