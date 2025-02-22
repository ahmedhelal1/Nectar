<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nette\Utils\Validators;
use App\Http\Requests\Api\Front\User\{RegisterRequest, SendCodeRequest, VerifyCodeRequest};
use App\Services\Front\AuthService;
use App\Http\Requests\Api\Front\User\LoginRequest;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = $this->authService->register($data);
        return $this->responseApi("Check on your email verify");
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        return $this->authService->login($data);
    }
    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }
    public function sendOtpCode(SendCodeRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authService->sendOtpCode($data);
            return $this->responseApi("Enter Code");
        } catch (\Exception $e) {
            return $this->responseApi($e->getMessage());
        }
    }

    public function verifyOtpCode(VerifyCodeRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authService->verifyOtpCode($data);
            return $this->responseApi("Code verified successfully");
        } catch (\Exception $e) {
            return $this->responseApi($e->getMessage());
        }
    }
}
