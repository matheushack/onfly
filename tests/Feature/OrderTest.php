<?php
declare(strict_types=1);


namespace Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;

/**
 *
 */
class OrderTest extends TestCase
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()
            ->create();

        $this->order = Order::factory()
            ->for($this->user, 'user')
            ->create();
    }

    /**
     * @return void
     */
    public function test_index(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->getJson("/api/orders");

        $response->assertStatus(200);

        $response->assertExactJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'passenger',
                    'destination',
                    'departure_at',
                    'return_at',
                    'created_at',
                    'updated_at',
                    'status' => [
                        'code',
                        'name'
                    ]
                ],
            ],
            'links',
            'meta'
        ]);
    }

    /**
     * @return void
     */
    public function test_show(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->getJson("/api/orders/{$this->order->id}");

        $response->assertStatus(200);

        $response->assertExactJsonStructure([
            'data' => [
                'id',
                'passenger',
                'destination',
                'departure_at',
                'return_at',
                'created_at',
                'updated_at',
                'status' => [
                    'code',
                    'name'
                ]
            ],
        ]);
    }

    /**
     * @return void
     */
    public function test_create(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->postJson("/api/orders", [
                'passenger' => fake()->name(),
                'destination' => fake()->name(),
                'departure_at' => Carbon::now()->format('Y-m-d'),
                'return_at' => Carbon::now()->addDays(30)->format('Y-m-d'),
            ]);

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function test_change_own_order(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->patchJson("/api/orders/{$this->order->id}/status", [
                'status' => OrderStatus::APPROVED->value,
            ]);

        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_approved(): void
    {
        $user = User::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/orders/{$this->order->id}/status", [
                'status' => OrderStatus::APPROVED->value,
            ]);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_canceled(): void
    {
        $user = User::factory()
            ->create();

        $response = $this
            ->actingAs($user)
            ->patchJson("/api/orders/{$this->order->id}/status", [
                'status' => OrderStatus::CANCELED->value,
            ]);

        $response->assertStatus(200);
    }
}
