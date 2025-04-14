<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    /**
     * @param AuthService $service
     */
    public function __construct(protected AuthService $service)
    {
    }

    /**
     * @param LoginRequest $request
     * @return LoginResource
     */
    public function login(LoginRequest $request): LoginResource
    {
        $response = $this->service->login($request->validated());
        return LoginResource::make($response);
    }
}