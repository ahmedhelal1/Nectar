<?php

namespace App\Services\Front;

use App\Models\{OtpCode, User};
use Carbon\Carbon;


class AuthService
{
    public function register(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
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
}
