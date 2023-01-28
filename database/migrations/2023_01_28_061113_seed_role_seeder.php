<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        foreach(Role::$roles as $role){
            Role::query()->create([
                'name' => $role,
                'guard_name' =>'api'
            ]);
        }
    }

};
