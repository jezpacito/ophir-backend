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

    public function test_account_details()
    {
        /**planholder active to agent role */
        $planholder = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);
        $planholder->roles()->attach([Role::ofName(Role::ROLE_PLANHOLDER)->id]); //planholder, agent
        $planholder->roles()->attach([Role::ofName(Role::ROLE_AGENT)->id], [
            'is_active' => false,
        ]);
        $this->actingAs($planholder);

        $response = $this->get('api/account-details', ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    public function test_referral_tree()
    {
        $agent = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);
        $this->actingAs($agent);

        $agent->roles()->attach([2, 4]); //planholder, agent

        $agent->userPlans()->attach(Plan::first(), [
            'billing_occurrence' => Plan::YEARLY,
        ]);

        $users = User::factory()->count(50)->create()->toArray();

        foreach ($users as $user) {
            $user = User::find($user['id']);
            $user->roles()->attach([Role::ofName(Role::ROLE_PLANHOLDER)->id]);
            $user->userPlans()->attach(Plan::ofName(Plan::ST_CLAIRE)->id, [
                'billing_occurrence' => Plan::YEARLY,
                'referred_by_id' => $agent->id,
            ]);
        }

        $response = $this->get('api/referral-tree', ['Accept' => 'application/json']);
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
        $user->roles()->attach([Role::ofName(Role::ROLE_PLANHOLDER)->id]); //planholder, agent
        $user->roles()->attach([Role::ofName(Role::ROLE_AGENT)->id], [
            'is_active' => false,
        ]);

        $user->userPlans()->attach(Plan::first(), [
            'billing_occurrence' => Plan::YEARLY,
        ]);

        $this->actingAs($user);
        $data = [
            'role_id' => Role::ofName(Role::ROLE_AGENT)->id,
        ];

        $response = $this->put('api/switch-account', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
