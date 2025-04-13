<?php
declare(strict_types=1);


namespace Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class OrderTest extends TestCase
{
    use RefreshDatabase;

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
            ->create([
                'password' => Hash::make('password')
            ]);

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
            ->getJson("/orders");

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
                    ],
                ],
            ],
            'links',
            'meta'
        ]);
    }
}
