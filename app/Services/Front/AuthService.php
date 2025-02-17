<?php

namespace App\Services\Front;

use App\Models\{OtpCode, User};
use Carbon\Carbon;
use Doctrine\Common\Lexer\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



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

        return $user;
    }
    public function login(array $data)
    {

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user['password'])) {

            return response()->json(['error' => 'Check your data'], 401);
        }

        if (Auth::attempt(['email' => $user['email'], 'password' => $data['password']])) {
            $token = $user->createToken('auth_token')->plainTextToken;
            Auth::login($user);
            return response()->json([
                'message' => 'login_success',
                'user' => Auth::user(),
                'token' => $token
            ], 201);
        } else {
            return response()->json(['error' => 'wrong_credentials'], 401);
        }
    }
}
