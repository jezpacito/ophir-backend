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

        $user = User::factory()->create([
            'username' => 'OPHIR AGENT',
            'password' => 'password',
            'referral_code' => User::COMPANY_REFFERRAL_CODE,
        ]);

        $user->roles()->attach([Role::ofName(ROLE::ROLE_AGENT)->id]);

        /** @var Role $roles_users */
        foreach (Role::$role_users as $role_users) {
            $user = User::factory()->create([

                'username' => $role_users,
                'password' => 'password',
            ]);

            $user->roles()->attach([Role::ofName($role_users)->id]);
        }

        /** @var Role $roles */
        foreach (Role::$roles as $roles) {
            $user = User::factory()->create([
                'username' => $roles,
                'password' => 'password',
            ]);

            $user->roles()->attach([Role::ofName($roles)->id]);
        }
    }
};
