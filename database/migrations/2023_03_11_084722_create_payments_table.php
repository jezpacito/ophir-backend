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
        /**
         * @todo add status payment
         */
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('payment_uuid');
            $table->unsignedBigInteger('user_plan_id')->nullable();
            $table->string('amount');
            $table->boolean('is_confirmed_payment')->default(false);
            $table->string('referrence_number');
            $table->string('status')->default('pending')->comment('due date,on-time, delayed,pending');
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
        Schema::dropIfExists('payments');
    }
};
