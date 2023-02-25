<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\UserRole;

class AccountController extends Controller
{
    public function switchAccount(AccountRequest $accountRequest, int $role_account_id)
    {
        $userRoleAccount = UserRole::findOrFail($role_account_id);
    }
}
