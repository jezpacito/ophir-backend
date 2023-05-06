<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class MertixController extends Controller
{
    public function totalCounts()
    {
        $totalPlanholder = User::whereHas('roles', function ($query) {
            $query->where('name', Role::ROLE_PLANHOLDER);
        })->count();

        $totalAgent = User::whereHas('roles', function ($query) {
            $query->where('name', Role::ROLE_AGENT);
        })->count();

        $totalBranch = Branch::count();

        $userBranches = Branch::withCount(['users' => function ($query) {
            $query->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', [Role::ROLE_ADMIN, Role::ROLE_BRANCH_ADMIN]);
            });
        }])->get();

        return Response::json([
            'totalPlanholder' => $totalPlanholder,
            'totalAgent' => $totalAgent,
            'totalBranch' => $totalBranch,
            'usersPerBranch' => $userBranches,
        ]);
    }
}
