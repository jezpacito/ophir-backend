<?php

namespace Tests\Feature\Http\Controller\Api;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_get_payments()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $planholders = User::factory()->count(10)->create();

        foreach ($planholders as $planholder) {
            $user_plan_uuid_1 = Str::orderedUuid();
            $user_plan_uuid_2 = Str::orderedUuid();
            $planholder->userPlans()->attach(Plan::first()->id, [
                'user_plan_uuid' => $user_plan_uuid_1,
            ]);
            $planholder->userPlans()->attach(Plan::find(2)->id, [
                'user_plan_uuid' => $user_plan_uuid_2,
            ]);
            $planholder->roles()->attach(Role::ofName('Planholder')->id);
            $userPlans = UserPlan::whereIn('user_plan_uuid', [$user_plan_uuid_1, $user_plan_uuid_2])
                ->get();

            foreach ($userPlans as $userPlan) {
                $planholder->subscribeToPlan($userPlan, (int) rand(1000, 5000), (string) 'Manual', $planholder);
            }
        }

        $response = $this->get('api/payments', ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    public function test_get_planholder_payment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $planholders = User::factory()->count(1)->create();

        foreach ($planholders as $planholder) {
            $user_plan_uuid_1 = Str::orderedUuid();
            $user_plan_uuid_2 = Str::orderedUuid();
            $planholder->userPlans()->attach(Plan::first()->id, [
                'user_plan_uuid' => $user_plan_uuid_1,
            ]);
            $planholder->userPlans()->attach(Plan::find(2)->id, [
                'user_plan_uuid' => $user_plan_uuid_2,
            ]);
            $planholder->roles()->attach(Role::ofName('Planholder')->id);
            $userPlans = UserPlan::whereIn('user_plan_uuid', [$user_plan_uuid_1, $user_plan_uuid_2])
                ->get();

            foreach ($userPlans as $userPlan) {
                $planholder->subscribeToPlan($userPlan, (int) rand(1000, 5000), (string) 'Manual', $planholder);
            }
        }

        $response = $this->get("api/planholder-payments/$planholder->id", ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    public function test_get_plan_payment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $planholders = User::factory()->count(1)->create();

        foreach ($planholders as $planholder) {
            $user_plan_uuid_1 = Str::orderedUuid();
            $user_plan_uuid_2 = Str::orderedUuid();
            $planholder->userPlans()->attach(Plan::first()->id, [
                'user_plan_uuid' => $user_plan_uuid_1,
            ]);
            $planholder->userPlans()->attach(Plan::find(2)->id, [
                'user_plan_uuid' => $user_plan_uuid_2,
            ]);
            $planholder->roles()->attach(Role::ofName('Planholder')->id);
            $userPlans = UserPlan::whereIn('user_plan_uuid', [$user_plan_uuid_1, $user_plan_uuid_2])
                ->get();

            foreach ($userPlans as $userPlan) {
                $planholder->subscribeToPlan($userPlan, (int) rand(1000, 5000), (string) 'Manual', $planholder);
            }
        }

        $response = $this->get("api/plan-payments/$user_plan_uuid_1", ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
