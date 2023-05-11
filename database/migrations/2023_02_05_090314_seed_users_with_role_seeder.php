<?php

use App\Models\Role;
use App\Models\User;
use App\Types\Roles;
use App\Types\User as TypesUser;
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
            'referral_code' => TypesUser::COMPANY_REFFERRAL_CODE,
        ]);

        $user->roles()->attach([Role::ofName(Roles::AGENT->label())->id]);
        foreach (Roles::officeUsersOptions() as $role_users) {
            $user = User::factory()->create([

                'username' => $role_users,
                'password' => 'password',
            ]);

            $user->roles()->attach([Role::ofName($role_users)->id]);
        }

        foreach (Roles::clientUsersOptions() as $roles) {
            $user = User::factory()->create([
                'username' => $roles,
                'password' => 'password',
            ]);

            $user->roles()->attach([Role::ofName($roles)->id]);
        }
    }
};
