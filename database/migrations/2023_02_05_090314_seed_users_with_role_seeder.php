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

        /** @var Role $roles */
        foreach (Role::get() as $role) {
            User::factory()->create([
                'role_id' => $role->id,
                'username' => $role->name,
                'password' => 'password',
            ]);
        }
    }
};
