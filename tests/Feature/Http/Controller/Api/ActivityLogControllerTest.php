<?php

namespace Tests\Feature\Http\Controller\Api;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityLogControllerTest extends TestCase
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
    public function test_get_activity_logs()
    {
        $this->actingAs(User::factory()->create(['branch_id' => Branch::first()->id]));
        $response = $this->get('api/activity-logs', ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(200);
    }
}
