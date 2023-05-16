<?php

use App\Models\Plan;
use App\Types\Payments\PeriodType;
use App\Types\Plans\Types;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private function pricingCommission($plan)
    {
        if ($plan === Types::ST_FERDINAND->label()) {
            $pricing = [
                'annual' => 4650,
                'semi_annualy' => 2300,
                'quarterly' => 1150,
                'monthly' => 400,
            ];
            $commission = [
                'agent' => 70,
                'manager' => 30,
                'director' => 10,
            ];
            $contractPrice = 24000;

            return [$pricing, $commission, $contractPrice];
        }
        if ($plan === Types::ST_MERCY->label()) {

            $pricing = [
                'annual' => 22940,
                'semi_annualy' => 11470,
                'quarterly' => 5685,
                'monthly' => 1995,
            ];
            $commission = [
                'agent' => 400,
                'manager' => 100,
                'director' => 50,
            ];
            $contractPrice = 119700;

            return [$pricing, $commission, $contractPrice];
        }

        return null;
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
            // $commissions = self::PLANS_COMMISSIONS[$plan];
            $pricingCommission = $this->pricingCommission($plan);
            Plan::create([
                'name' => $plan,
                'contract_price' => $pricingCommission[2],
                'term_period' => PeriodType::CURRENT_YEAR_PERIOD,
                'commission' => json_encode($pricingCommission[1]),
                'pricing' => json_encode($pricingCommission[0]),
                'is_transferrable' => true,
            ]);
        }
    }
};
