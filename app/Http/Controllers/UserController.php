<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 *
 */
class UserController extends Controller
{
    /**
     * @param UserService $service
     */
    public function __construct(protected UserService $service)
    {
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function profile(Request $request): UserResource
    {
        $response = $this->service->profile($request);
        return UserResource::make($response);
    }
}