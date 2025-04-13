<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request);
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}