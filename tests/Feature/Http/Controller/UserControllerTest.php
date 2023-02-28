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

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_upload_image()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $base64Image = ' data:image/jpeg;base64,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';
        $data = [
            'profile_image' => json_encode($base64Image),
        ];

        $response = $this->post("api/upload-image/$user->id", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
