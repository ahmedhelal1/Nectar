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
        // $token = $user->createToken('auth_token')->plainTextToken;

    }
    public function login(array $data)
    {

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user['password'])) {

            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        if (Auth::attempt(['email' => $user['email'], 'password' => $data['password']])) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token
            ], 200);
        } else {
            return response()->json(['error' => 'wrong_credentials'], 401);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => "logout success"], 200);
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
    }
    public function verifyOtpCode(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $otpCode = OtpCode::where('user_id', $user->id)->where('code', $data['code'])->first();

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
    }
}
