<?php

use App\Models\Role;
use App\Types\Roles;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Roles::clientUsersOptions() as $role) {
            Role::query()->create([
                'name' => $role,
                'guard_name' => 'api',
            ]);
        }

        foreach (Roles::officeUsersOptions() as $role_users) {
            Role::query()->create([
                'name' => $role_users,
                'guard_name' => 'api',
            ]);
        }
    }
};
