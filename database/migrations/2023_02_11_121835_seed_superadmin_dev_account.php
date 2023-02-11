<?php

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
        User::factory()->create([
            'username' => 'superadmin_dev',
            'password' => 'hello123',
            'email' => 'superadmin@dev.com',
        ]);
    }
};
