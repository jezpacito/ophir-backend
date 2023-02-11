<?php

use App\Models\Plan;
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
        /** @var Plan $plans */
        foreach (Plan::$plans as $plan) {
            Plan::query()->create([
                'name' => $plan,
                'year_period' => Plan::CURRENT_YEAR_PERIOD,
            ]);
        }
    }
};
