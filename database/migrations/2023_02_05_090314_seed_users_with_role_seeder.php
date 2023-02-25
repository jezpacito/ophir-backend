<?php

use App\Models\Role;
use App\Models\User;
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
        // Call seeder
        Artisan::call('db:seed', [
            '--class' => 'BranchSeeder',
            '--force' => true,
        ]);

        /** @var Role $roles_users */
        foreach (Role::$role_users as $role_users) {
            $user = User::factory()->create([
                'username' => $role_users,
                'password' => 'password',
            ]);

            $user->roles()->attach(Role::ofName($role_users));
        }

        /** @var Role $roles */
        foreach (Role::$roles as $roles) {
            $user = User::factory()->create([
                'username' => $roles,
                'password' => 'password',
            ]);

            $user->roles()->attach(Role::ofName($roles));
        }
    }
};
