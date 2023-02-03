<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('account_type')->unique()->index()->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('lastname')->index()->nullable();
            $table->string('firstname')->index()->nullable();
            $table->string('middlename')->nullable()->index();
            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('contact_no')->nullable()->index();
            $table->string('civil_status')->nullable()->index();
            $table->string('height')->nullable();
            $table->string('weigth')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('sss_number')->nullable()->index();
            $table->string('tin_number')->nullable()->index();
            $table->string('ben_firstname')->nullable();
            $table->string('ben_middlename')->nullable();
            $table->string('ben_lastname')->nullable();
            $table->string('ben_relationship')->nullable();
            $table->string('ben_birthdate')->nullable();
            $table->string('status')->nullable()->index();
            $table->string('facebook')->nullable();
            $table->string('messenger')->nullable();
            $table->string('twitter')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
