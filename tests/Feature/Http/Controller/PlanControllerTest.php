<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Branch;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlanControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_add_another_plan()
    {
        $this->actingAs(User::factory()->create(['branch_id' => Branch::first()->id]));

        $reffered = User::factory()->create();
        $data = [
            'user_id' => auth()->user()->id,
            'plan_id' => Plan::first()->id,
            'billing_occurrence' => Plan::YEARLY,
            'referred_by_id' => $reffered->id,
        ];
        $response = $this->post('api/add-plan', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_plans()
    {
        $this->actingAs(User::factory()->create());
        $count = 5;
        Plan::factory()->count(5)->create();
        $response = $this->get('api/plans', ['Accept' => 'application/json']);

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_plan()
    {
        $this->actingAs(User::factory()->create());
        $data = Plan::factory()->make()->toArray();
        $response = $this->post('api/plans', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_plan()
    {
        $this->actingAs(User::factory()->create());
        $plan = Plan::factory()->create();
        $data = [
            'name' => 'test',
        ];
        $response = $this->put("api/plans/$plan->id", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
