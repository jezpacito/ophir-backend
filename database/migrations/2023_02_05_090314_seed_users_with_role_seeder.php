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
            User::factory()->create([
                'role_id' => $role_users->id,
                'username' => $role_users->name,
                'password' => 'password',
            ]);
        }

        /** @var Role $roles */
        foreach (Role::get() as $roles) {
            User::factory()->create([
                'role_id' => $roles->id,
                'password' => 'password',
            ]);
        }
    }
};
