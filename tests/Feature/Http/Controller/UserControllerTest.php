<?php

namespace Tests\Feature\Http\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
    public function test_add_user()
    {
        $this->actingAs(User::factory()->create());
        $data = [
            'username' => $this->faker()->userName(),
            'email' => $this->faker()->email(),
        ];
        $response = $this->post('api/users', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
        $response->dump();
    }
}
