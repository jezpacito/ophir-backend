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
        foreach (Role::get() as $role_users) {
            $user = User::factory()->create([
                'username' => $role_users->name,
                'password' => 'password',
            ]);

            $user->roles()->attach($role_users->id);
        }

        /** @var Role $roles */
        foreach (Role::get() as $roles) {
            $user = User::factory()->create([
                'username' => $roles->name,
                'password' => 'password',
            ]);

            $user->roles()->attach($role_users->id);
        }
    }
};
