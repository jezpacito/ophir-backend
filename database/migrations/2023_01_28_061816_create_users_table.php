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
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
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
            $table->string('status')->nullable()->index();
            $table->string('facebook')->nullable();
            $table->string('messenger')->nullable();
            $table->string('twitter')->nullable();
            $table->string('email')->unique();
            $table->string('referral_code')->nullable();
            $table->boolean('account_status')->default(true);
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
