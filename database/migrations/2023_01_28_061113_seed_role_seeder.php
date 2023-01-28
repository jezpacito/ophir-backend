<?php

use App\Models\Role;
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
        /** @var Role $roles */
        foreach (Role::$roles as $role) {
            Role::query()->create([
                'name' => $role,
                'guard_name' => 'api',
            ]);
        }
    }
};
