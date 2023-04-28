<?php

use App\Models\Plan;
use App\Models\Role;
use App\Types\PeriodType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const PLANS_COMMISSIONS = [
        Plan::ST_CLAIRE => [
            ['position' => Role::ROLE_AGENT, 'amount' => 30],
            ['position' => Role::ROLE_MANAGER, 'amount' => 20],
            ['position' => Role::ROLE_DIRECTOR, 'amount' => 10],
        ],
        Plan::ST_FERDINAND => [
            ['position' => Role::ROLE_AGENT, 'amount' => 70],
            ['position' => Role::ROLE_MANAGER, 'amount' => 30],
            ['position' => Role::ROLE_DIRECTOR, 'amount' => 10],
        ],
        Plan::ST_MERCY => [
            ['position' => Role::ROLE_AGENT, 'amount' => 400],
            ['position' => Role::ROLE_MANAGER, 'amount' => 100],
            ['position' => Role::ROLE_DIRECTOR, 'amount' => 50],
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var Plan $plans */
        foreach (Plan::$plans as $plan) {
            $commissions = self::PLANS_COMMISSIONS[$plan];

            Plan::create([
                'name' => $plan,
                'term_period' => PeriodType::CURRENT_YEAR_PERIOD,
                'price' => 3000,
                'commission' => json_encode($commissions),
                'is_transferrable' => true,
            ]);
        }
    }
};
