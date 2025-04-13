<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    /**
     * @param array $data
     * @return array
     * @throws ModelNotFoundException
     */
    public function login(array $data): array
    {
        $user = User::query()
            ->where('email', data_get($data, 'email'))
            ->firstOrFail();

        if (!Hash::check(data_get($data, 'password'), $user->password)) {
            throw new UnauthorizedHttpException('login');
        }

        return [
            'token' => $user->createToken(
                name: 'auth_token',
                expiresAt: Carbon::now()->addMinutes(60)
            )->plainTextToken,
        ];
    }
}