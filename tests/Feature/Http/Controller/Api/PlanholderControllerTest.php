<?php

namespace Tests\Feature;

use App\Models\Beneficiary;
use App\Models\Branch;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlanholderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_get_planholders()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->userPlans()->attach(Plan::first()->id);
        $user->roles()->attach(Role::ofName('Planholder')->id);

        $response = $this->get('api/planholders', ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(200);
    }

    public function test_register_as_agent()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->userPlans()->attach(Plan::first()->id);
        $user->roles()->attach(Role::ofName('Planholder')->id);

        $data = [
            'user_id' => $user->id,
            'branch_id' => $user->branch_id,
            'role' => 'Agent',
        ];
        $response = $this->post('api/register-as-agent', $data, ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(201);

        $this->assertDatabaseHas('user_roles', [
            'user_id' => $data['user_id'],
            'role_id' => Role::ofName('Agent')->id,
            'is_active' => false,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_planholder()
    {
        $this->actingAs($user = User::factory()->create());

        $beneficiaries = Beneficiary::factory()->count(2)->make();
        unset($beneficiaries[0]['user_id']);
        unset($beneficiaries[1]['user_id']);

        $data = [
            'firstname' => $this->faker()->firstName(),
            'middlename' => $this->faker()->lastName(),
            'lastname' => $this->faker()->lastName(),
            'email' => $this->faker()->email(),
            'role' => Role::ROLE_PLANHOLDER,
            'beneficiaries' => $beneficiaries->toArray(),
            'branch_id' => Branch::first()->id,
            'plan_id' => Plan::first()->id,
            'billing_method' => Plan::ANNUAL,
            'referred_by_id' => $user->id,
        ];

        $response = $this->post('api/planholders', $data, ['Accept' => 'application/json']);
        $response->dump();
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'branch_id' => $data['branch_id'],
        ]);

        foreach ($beneficiaries as $beneficiary) {
            $this->assertDatabaseHas('beneficiaries', [
                'firstname' => $beneficiary->firstname,
                'lastname' => $beneficiary->lastname,
                'relationship' => $beneficiary->relationship,
                'birthdate' => $beneficiary->birthdate,
            ]);
        }

        $this->assertDatabaseHas('user_plan', [
            'plan_id' => $data['plan_id'],
            'is_active' => true,
            'is_transferrable' => true,
            'billing_method' => $data['billing_method'],
        ]);

        $this->assertDatabaseHas('user_roles', [
            'role_id' => Role::ofName($data['role'])->id,
            'is_active' => true,
        ]);
    }
}
