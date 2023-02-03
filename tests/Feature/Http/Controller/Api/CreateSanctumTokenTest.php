<?php

namespace Tests\Feature\Http\Controller\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSanctumTokenTest extends TestCase
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
     *  @test
     *
     * @return void
     */
    public function test_generate_sanctum_token()
    {
        $data = [
            'username' => 'superadmin',
            'password' => 'password',
        ];

        $response = $this->post('api/login', $data, ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(200);
    }

    /**
     *  @test
     *
     * @return void
     */
    public function test_access_protected_route()
    {
        $response = $this->get('api/branches', ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(401);
    }
}
