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
        Schema::create('user_plan', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_plan_uuid')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('referred_by_id')->nullable()->references('id')->nullOnDelete()->on('users')->comment('referred_by');
            $table->boolean('is_active')->default(true);
            // $table->boolean('is_transferrable')->default(true);
            $table->string('billing_occurrence')->comment('Monthly, Yearly, Quarterly, Semi-Annually, Annual')->nullable();
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
        Schema::dropIfExists('user_plan');
    }
};
