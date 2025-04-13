<?php
declare(strict_types=1);


namespace Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class UserTest extends TestCase
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
    }

    /**
     * @return void
     */
    public function test_profile_without_token(): void
    {
        $response = $this->getJson('/api/users/profile');
        $response->assertStatus(401);
    }

    /**
     * @return void
     */
    public function test_profile(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->getJson('/api/users/profile');

        $response->assertStatus(200)
            ->assertExactJsonStructure([
                'data' => [
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}
