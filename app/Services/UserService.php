<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

/**
 *
 */
class UserService
{
    /**
     * @param Request $request
     * @return User
     */
    public function profile(Request $request): User
    {
        return $request->user();
    }
}