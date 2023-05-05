<?php

use App\Models\Plan;
use App\Models\Role;
use App\Types\PeriodType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const PLANS_COMMISSIONS = [
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

    private const PLAN_PRICING = [
        Plan::ST_FERDINAND => [
            ['billing_option' => Plan::ANNUAL, 'amount' => 4650],
            ['billing_option' => Plan::SEMI_ANNUAL, 'amount' => 2300],
            ['billing_option' => Plan::MONTHLY, 'amount' => 1150],
            ['billing_option' => Plan::QUARTERLY, 'amount' => 400],

        ],
        Plan::ST_MERCY => [
            ['billing_option' => Plan::ANNUAL, 'amount' => 22940],
            ['billing_option' => Plan::SEMI_ANNUAL, 'amount' => 11470],
            ['billing_option' => Plan::MONTHLY, 'amount' => 5685],
            ['billing_option' => Plan::QUARTERLY, 'amount' => 1995],
        ],
    ];

    public function contractPricing($plan)
    {
        if ($plan === Plan::ST_FERDINAND) {
            return 24000;
        }
        if ($plan === Plan::ST_MERCY) {
            return 119700;
        }

        return 0;
    }

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
            $pricing = self::PLAN_PRICING[$plan];
            $contactPrice = $this->contractPricing($plan);
            Plan::create([
                'name' => $plan,
                'contract_price' => $contactPrice,
                'term_period' => PeriodType::CURRENT_YEAR_PERIOD,
                'commission' => json_encode($commissions),
                'pricing' => json_encode($pricing),
                'is_transferrable' => true,
            ]);
        }
    }
};
