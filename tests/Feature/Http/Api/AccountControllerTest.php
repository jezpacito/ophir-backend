<?php

namespace Tests\Feature\Http\Api;

use App\Models\Branch;
use App\Models\Plan;
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
            'role_account_id' => $user->userPlans()->first()->id,
        ];

        $response = $this->put('api/switch-account', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
