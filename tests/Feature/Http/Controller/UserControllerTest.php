<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Beneficiary;
use App\Models\Branch;
use App\Models\Role;
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

    public function test_list_of_encoder_staff_per_branch()
    {
        $this->actingAs(User::factory()->create());

        $branch = Branch::first();
        $user = User::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $role = Role::ofName(Role::ROLE_ADMIN);
        $user->roles()->attach($role->id);

        $response = $this->get("api/users-branch/$branch->id", ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_user()
    {
        $this->actingAs(User::factory()->create());

        $beneficiaries = Beneficiary::factory()->count(2)->make();
        unset($beneficiaries[0]['user_id']);
        unset($beneficiaries[1]['user_id']);

        $data = [
            'firstname' => $this->faker()->firstName(),
            'middlename' => $this->faker()->lastName(),
            'lastname' => $this->faker()->lastName(),
            'email' => 'test@test.com',
            'role' => Role::ROLE_PLANHOLDER,
            'beneficiaries' => $beneficiaries->toArray(),
        ];

        $response = $this->post('api/users', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);
    }
}
