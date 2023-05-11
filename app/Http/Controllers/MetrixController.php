<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Types\Roles;
use Illuminate\Support\Facades\Response;

class MetrixController extends Controller
{
    public function totalCounts()
    {
        $totalPlanholder = User::whereHas('roles', function ($query) {
            $query->where('name', Roles::PLANHOLDER->label());
        })->count();

        $totalAgent = User::whereHas('roles', function ($query) {
            $query->where('name', Roles::AGENT->label());
        })->count();

        $totalBranch = Branch::count();

        $userBranches = Branch::withCount(['users' => function ($query) {
            $query->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', [Roles::ADMIN->label(), Roles::BRANCH_ADMIN->label()]);
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
