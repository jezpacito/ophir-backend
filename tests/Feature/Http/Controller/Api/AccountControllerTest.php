<?php

namespace Tests\Feature\Http\Api;

use App\Models\Branch;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_referral_tree()
    {
        $agent = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);
        $this->actingAs($agent);

        $agent->roles()->attach([2, 4]); //planholder, agent

        $agent->userPlans()->attach(Plan::first(), [
            'billing_method' => Plan::YEARLY,
        ]);

        $users = User::factory()->count(50)->create()->toArray();

        foreach ($users as $user) {
            $user = User::find($user['id']);
            $user->roles()->attach([Role::ofName(Role::ROLE_PLANHOLDER)->id]);
            $user->userPlans()->attach(Plan::ofName(Plan::ST_CLAIRE)->id, [
                'billing_method' => Plan::YEARLY,
                'referred_by_id' => $agent->id,
            ]);
        }

        $response = $this->get('api/referral-tree', ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_switch_account_from_planholder_to_agent()
    {
        $user = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);
        $user->roles()->attach([2, 4]);

        $user->userPlans()->attach(Plan::first(), [
            'billing_method' => Plan::YEARLY,
        ]);

        $this->actingAs($user);
        $data = [
            'role_account_id' => $user->roles()->first()->id,
        ];

        $response = $this->put('api/switch-account', $data, ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(200);
    }
}
