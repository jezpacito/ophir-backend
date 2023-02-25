<?php

namespace Tests\Feature\Http\Controller;

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
