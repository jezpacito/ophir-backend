<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StaffControllerTest extends TestCase
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
    public function test_create_staff()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $data = [
            'user_id' => $user->id,
            'type' => Staff::STAFF_AGENT,
        ];

        $response = $this->post('api/staffs', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
        $response->dump();
    }

    public function test_update_staff()
    {
        $this->actingAs(User::factory()->create());

        $staff = Staff::create([
            'user_id' => 1,
            'type' => Staff::STAFF_AGENT,
        ]);

        $data = [
            'type' => Staff::STAFF_DIRECTOR,
        ];

        $response = $this->put("api/staffs/$staff->id", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $response->dump();
    }

    public function test_delete_staff()
    {
        $this->actingAs(User::factory()->create());

        $staff = Staff::factory()->create();

        $response = $this->delete("api/staffs/$staff->id", ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $response->dump();

        $this->assertModelMissing($staff);
    }
}
