<?php

namespace App\Services\Front;

use App\Models\{OtpCode, User};
use Carbon\Carbon;
use Doctrine\Common\Lexer\Token;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationData;

class AuthService
{
    public function register(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'account_type' => User::CLIENT,
            'language' => request()?->header('X-Language') ?? 'en'
        ]);

        $otp = OtpCode::generateCode();
        $otpCode = OtpCode::create([
            'code' => $otp,
            'type' => 'email',
            'user_id' => $user->id,
            'usage' => 'verify',
            'is_used' => 0,
            'expires_at' => Carbon::now()->addMinute()
        ]);
        return $user;
    }
    public function login(array $data)
    {

        $user = User::where('email', $data['email'])->where('is_first_login', 1)->first();
        if (!$user || !Hash::check($data['password'], $user['password'])) {

            return response()->json(['error' => 'Invalid email or password '], 401);
        }
        if ($user->is_first_login == 0) {
            return response()->json(['error' => 'You need to complete the first login process'], 403);
        }
        if (Auth::attempt(['email' => $user['email'], 'password' => $data['password']])) {
            $token = $user->createToken('auth_token')->plainTextToken;
        } else {
            return response()->json(['error' => 'wrong_credentials'], 401);
        }
        return ['user' => $user, 'token' => $token];
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
    public function sendOtpCode(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $otp = OtpCode::generateCode();
        $otpCode = OtpCode::create([
            'code' => $otp,
            'type' => 'email',
            'user_id' => $user->id,
            'usage' => 'verify',
            'is_used' => 0,
            'expires_at' => Carbon::now()->addMinute()
        ]);
        return $otp;
    }
    public function verifyOtpCode(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $otpCode = OtpCode::where('user_id', $user->id)->where('code', $data['code'])->latest()->first();

        if (!$otpCode) {
            return response()->json(['error' => 'Invalid OTP code'], 400);
        }
        if ($otpCode->usage != 'verify') {
            return response()->json(['error' => 'OTP code not meant for this purpose'], 400);
        }
        if (Carbon::parse($otpCode->expires_at)->isPast()) {
            return response()->json(['error' => 'OTP code expired'], 400);
        }
        if ($otpCode->is_used) {
            return response()->json(['error' => 'OTP code already used'], 400);
        }
        $otpCode->is_used = 1;
        $otpCode->save();
        $user->is_email_verified = 1;
        $user->email_verified_at = now();
        $user->is_first_login = 1;
        $user->save();
        $token = $user->createToken('auth_token')->plainTextToken;
        return  $token;
    }

    public function forgotPassword(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $otp = OtpCode::generateCode();
        $otpCode = OtpCode::create([
            'code' => $otp,
            'type' => 'email',
            'user_id' => $user->id,
            'usage' => 'forget_password',
            'is_used' => 0,
            'expires_at' => Carbon::now()->addMinute()
        ]);
        return $otp;
    }
}
