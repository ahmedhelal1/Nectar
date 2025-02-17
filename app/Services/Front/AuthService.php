<?php

namespace App\Services\Front;

use App\Models\{OtpCode, User};
use Carbon\Carbon;
use Doctrine\Common\Lexer\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;




class AuthService
{
    public function register(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
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
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully registered, please verify your email.',
            'user' => $user,
            'token' => $token

        ], 200);
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
}
