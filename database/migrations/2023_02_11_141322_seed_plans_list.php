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

    private function pricing($plan)
    {
        if ($plan === Plan::ST_FERDINAND) {
            return [
                'annual' => 4650,
                'semi_annualy' => 2300,
                'quarterly' => 1150,
                'monthly' => 400,
            ];
        }
        if ($plan === Plan::ST_MERCY) {
            return [
                'annual' => 22940,
                'semi_annualy' => 11470,
                'quarterly' => 5685,
                'monthly' => 1995,
            ];
        }

        return null;
    }

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
            $pricing = $this->pricing($plan);
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
