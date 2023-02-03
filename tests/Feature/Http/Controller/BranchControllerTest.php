<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BranchControllerTest extends TestCase
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
    public function test_create_branch()
    {
        $this->actingAs(User::factory()->create());
        $data = [
            'name' => $this->faker()->company(),
            'address' => $this->faker()->address(),
        ];
        $response = $this->post('api/branches', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
        $response->dump();

        $this->assertDatabaseHas('branches', [
            'name' => $data['name'],
            'address' => $data['address'],
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_branch()
    {
        $this->actingAs(User::factory()->create());

        $branch = Branch::factory()->create();
        $data = [
            'name' => $this->faker()->company().'- updated',
            'address' => $this->faker()->address().'- updated',
        ];

        $response = $this->put("api/branches/$branch->id", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $response->dump();

        $this->assertDatabaseHas('branches', [
            'name' => $data['name'],
            'address' => $data['address'],
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_branch()
    {
        $this->actingAs(User::factory()->create());

        $branch = Branch::factory()->create();

        $response = $this->delete("api/branches/$branch->id", ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $response->dump();

        $this->assertModelMissing($branch);
    }
}
