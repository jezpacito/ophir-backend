<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Branch;
use App\Models\Plan;
use App\Models\User;
use App\Types\Payments\PeriodType;
use App\Types\Plans\Types;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlanControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private const PLANS_COMMISSIONS = [
        'St. Ferdinand' => [
            ['position' => 'Agent', 'amount' => 70],
            ['position' => 'Manager', 'amount' => 30],
            ['position' => 'Director', 'amount' => 10],
        ],
        'St. Mercy' => [
            ['position' => 'Agent', 'amount' => 400],
            ['position' => 'Manager', 'amount' => 100],
            ['position' => 'Director', 'amount' => 50],
        ],
    ];

    public function test_add_another_plan()
    {
        $this->actingAs(User::factory()->create(['branch_id' => Branch::first()->id]));

        $reffered = User::factory()->create();
        $data = [
            'user_id' => auth()->user()->id,
            'plan_id' => Plan::first()->id,
            'billing_occurrence' => PeriodType::ANNUAL->label(),
            'referred_by_id' => $reffered->id,
            'payment_type' => 'Online',
            'amount' => 0,
        ];
        $response = $this->post('api/add-plan', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_plans()
    {
        $this->actingAs(User::factory()->create());
        $count = 5;
        Plan::factory()->count(5)->create();

        $response = $this->get('api/plans', ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_plan()
    {
        $this->actingAs(User::factory()->create([
            'is_verified' => false,
        ]));
        $dataPlan = Plan::factory()->make(
            ['commission' => json_encode(self::PLANS_COMMISSIONS[Types::ST_MERCY->label()])]
        )->toArray();

        $pricing = [
            'pricing' => [
                'annual' => 100,
                'semi_annualy' => 50,
                'quarterly' => 25,
                'monthly' => 8,
            ],
        ];

        $data = array_merge($pricing, $dataPlan);
        $response = $this->post('api/plans', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_plan()
    {
        $this->actingAs(User::factory()->create());
        $dataPlan = Plan::factory()->make(
            ['commission' => json_encode(self::PLANS_COMMISSIONS[Types::ST_MERCY->label()])]
        )->toArray();

        $pricing = [
            'pricing' => [
                'annual' => 100,
                'semi_annualy' => 50,
                'quarterly' => 25,
                'monthly' => 8,
            ],
        ];

        $data = array_merge($pricing, $dataPlan);
        $plan = Plan::create(array_merge($dataPlan, ['pricing' => json_encode($pricing)]));

        $response = $this->put("api/plans/$plan->id", $data, ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
