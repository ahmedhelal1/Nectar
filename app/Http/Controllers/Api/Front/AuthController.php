<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nette\Utils\Validators;
use App\Http\Requests\Api\Front\User\RegisterRequest;
use App\Services\Front\AuthService;
use App\Http\Requests\Api\Front\User\LoginRequest;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $this->authService->register($data);
        return response()->json([
            'message' => 'Successfully registered, please verify your email.'
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        return $this->authService->login($data);
    }
}
