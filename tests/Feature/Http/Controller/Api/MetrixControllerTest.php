<?php

namespace Tests\Feature\Http\Controller\Api;

use App\Models\Branch;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Types\Payments\PeriodType;
use App\Types\Plans\Types;
use App\Types\Roles;
use Tests\TestCase;

class MetrixControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_total_Counts()
    {
        $agent = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);
        $this->actingAs($agent);

        $agent->roles()->attach([2, 4]); //planholder, agent

        $agent->userPlans()->attach(Plan::first(), [
            'billing_occurrence' => PeriodType::ANNUAL->label(),
        ]);

        $users = User::factory()->count(50)->create()->toArray();

        foreach ($users as $user) {
            $user = User::find($user['id']);
            $user->roles()->attach([Role::ofName(Roles::PLANHOLDER->label())->id]);
            $user->userPlans()->attach(Plan::ofName(Types::ST_MERCY->label())->id, [
                'billing_occurrence' => PeriodType::ANNUAL->label(),
                'referred_by_id' => $agent->id,
            ]);
        }

        $response = $this->get('api/total-counts', ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
