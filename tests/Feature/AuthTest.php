<?php
declare(strict_types=1);


namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class AuthTest extends TestCase
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
            ->create([
                'password' => Hash::make('password')
            ]);
    }

    /**
     * @return void
     */
    public function test_login(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertExactJsonStructure([
                'data' => [
                    'tipo',
                    'token',
                ]
            ]);
    }
}
