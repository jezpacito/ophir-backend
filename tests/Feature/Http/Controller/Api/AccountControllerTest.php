<?php

namespace Tests\Feature\Http\Api;

use App\Models\Branch;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use App\Types\PeriodType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_activate_agent_account()
    {
        $planholder = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);
        $this->actingAs($planholder);

        $data = [
            'user_id' => $planholder->id,
            'payment_type' => 'account registration',
            'registration_fee' => 150,
        ];

        $response = $this->post('api/activate-agent-account', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    public function test_transferPlan()
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

        $plan = Plan::first();
        $uuid = Str::orderedUuid();
        $planholder->userPlans()->attach($plan,
            [
                'billing_occurrence' => 'Yearly',
                'referred_by_id' => User::first()->id,
                'user_plan_uuid' => $uuid,
            ]);

        $userPlan = UserPlan::whereUserPlanUuid($uuid)->first();
        $planholder->paymentMethod($userPlan, (int) 100, (string) 'Manual', $planholder);

        /**receiver of plan*/
        $receiver = User::factory()->create([
            'branch_id' => Branch::first()->id,
        ]);

        $data = [
            'user_id' => $receiver->id,
            'user_plan_uuid' => $uuid,
        ];

        $response = $this->post('api/transfer-plan', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
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
            'billing_occurrence' => PeriodType::ANNUAL->label(),
        ]);

        $users = User::factory()->count(50)->create()->toArray();

        foreach ($users as $user) {
            $user = User::find($user['id']);
            $user->roles()->attach([Role::ofName(Role::ROLE_PLANHOLDER)->id]);
            $user->userPlans()->attach(Plan::ofName(Plan::ST_MERCY)->id, [
                'billing_occurrence' => PeriodType::ANNUAL->label(),
                'referred_by_id' => $agent->id,
            ]);
        }

        $response = $this->get('api/referral-tree', ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
