<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nette\Utils\Validators;
use App\Http\Requests\Api\Front\User\{
    RegisterRequest,
    SendCodeRequest,
    VerifyCodeRequest,
    ForgetPasswordRequest,
    ResetPasswordRequest
};
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
        $user = $this->authService->login($data);
        return $this->responseApi("Login is successful", $user);
    }
    public function logout(Request $request)
    {
        $data = $this->authService->logout($request);
        return $this->responseApi("logout is successful");
    }
    public function sendOtpCode(SendCodeRequest $request)
    {
        try {
            $data = $request->validated();
            $otp = $this->authService->sendOtpCode($data);
            return $this->responseApi(" OTP sent successfully", $otp);
        } catch (\Exception $e) {
            return $this->responseApi($e->getMessage());
        }
    }

    public function verifyOtpCode(VerifyCodeRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->authService->verifyOtpCode($data);
            return $this->responseApi("OTP code verified successfully", $user);
        } catch (\Exception $e) {
            return $this->responseApi($e->getMessage());
        }
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authService->forgetPassword($data);
            return $this->responseApi("successfully sent OTP code");
        } catch (\Exception $e) {
            return $this->responseApi($e->getMessage());
        }
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $response =  $this->authService->resetPassword($data);
            return $this->responseApi("Password reset successfully", $response);
        } catch (\Exception $e) {
            return $this->responseApi($e->getMessage());
        }
    }
}
