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
                $planholder->paymentMethod($userPlan, (int) rand(1000, 5000), (string) 'Manual', $planholder);
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
                $planholder->paymentMethod($userPlan, (int) rand(1000, 5000), (string) 'Manual', $planholder);
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
                $planholder->paymentMethod($userPlan, (int) rand(1000, 5000), (string) 'Manual', $planholder);
            }
        }

        $response = $this->get("api/plan-payments/$user_plan_uuid_1", ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    public function test_make_payment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $planholder = User::factory()->create();

        $user_plan_uuid = Str::orderedUuid();
        $planholder->userPlans()->attach(Plan::first()->id, [
            'user_plan_uuid' => $user_plan_uuid,
        ]);

        $data = [
            'user_id' => $planholder->id,
            'user_plan_uuid' =>  $user_plan_uuid,
            'billing_option' =>
            'amount' => 999,
            'payment_type' => 'Manual',
        ];

        $user_plan_id = UserPlan::where('user_plan_uuid', $user_plan_uuid)->first();

        $response = $this->post('api/make-payment', $data, ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(201);

        $this->assertDatabaseHas('payments', [
            'user_id' =>  $data['user_id'],
            'status' => 'pending',
            'user_plan_id' => $user_plan_id->id,
        ]);
    }
}
