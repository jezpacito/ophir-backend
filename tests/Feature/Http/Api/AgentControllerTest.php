<?php

namespace Tests\Feature\Http\Api;

use App\Models\Branch;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AgentControllerTest extends TestCase
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
    public function test_add_another_plan()
    {
        $this->actingAs(User::factory()->create(['branch_id' => Branch::first()->id]));

        $reffered = User::factory()->create();
        $data = [
            'plan_id' => Plan::first()->id,
            'billing_method' => Plan::YEARLY,
            'referred_by_id' => $reffered->id,
        ];
        $response = $this->post('api/add-plan', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
