<?php

use App\Models\Plan;
use App\Types\Payments\PeriodType;
use App\Types\Plans\Types;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const PLANS_COMMISSIONS = [
        'St. Ferdinand' => [
            ['position' => 'Agent', 'amount' => 70],
            ['position' => 'Manager', 'amount' => 30],
            ['position' => 'Director', 'amount' => 10],
        ],
        'St. Mercy' => [
            ['position' => 'Agent', 'amount' => 400],
            ['position' => 'Manager', 'amount' => 100],
            ['position' => 'Director', 'amount' => 50],
        ],
    ];

    private function pricing($plan)
    {
        if ($plan === Types::ST_FERDINAND) {
            return [
                'annual' => 4650,
                'semi_annualy' => 2300,
                'quarterly' => 1150,
                'monthly' => 400,
            ];
        }
        if ($plan === Types::ST_MERCY) {
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
        dd($plan === Types::ST_FERDINAND);
        if ($plan === Types::ST_FERDINAND) {
            return 24000;
        }
        if ($plan === Types::ST_MERCY) {
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
        foreach (Types::planOptions() as $plan) {
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
