<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BeneficiaryControllerTest extends TestCase
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
    public function test_create_beneficiary()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $data = Beneficiary::factory()->create()->toArray();

        $response = $this->post('api/beneficiaries', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);

        $this->assertDatabaseHas('beneficiaries', [
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'relationship' => $data['relationship'],
            'birthdate' => $data['birthdate'],
            'user_id' => $data['user_id'],
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_beneficiary()
    {
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();
        $beneficiary = Beneficiary::factory()->create();
        $data = [
            'firstname' => $this->faker()->firstName().'updated',
            'middlename' => $this->faker()->lastName().'updated',
            'lastname' => $this->faker()->lastName().'updated',
            'relationship' => 'Child'.'updated',
            'birthdate' => $this->faker()->date(),
            'user_id' => $user->id,
        ];

        $response = $this->put("api/beneficiaries/$beneficiary->id", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);

        $this->assertDatabaseHas('beneficiaries', [
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'relationship' => $data['relationship'],
            'birthdate' => $data['birthdate'],
            'user_id' => $data['user_id'],
        ]);
    }
}
