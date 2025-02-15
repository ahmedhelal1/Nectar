<?php

namespace App\Http\Controllers\Api\Front;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \Laravel\Socialite\Two\GoogleProvider;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {


        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $findUser = User::where('social_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();
            if ($findUser) {
                Auth::login($findUser);
                return response()->json($findUser);
            } else {
                $findUser = User::create(
                    [
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        "social_id" => $googleUser->id,
                        'social_type' => 'google',
                        'account_type' => User::CLIENT,
                        'password' => Hash::make(uniqid())
                    ]
                );
                Auth::login($findUser);
                return response()->json($findUser);
            }

            $token = $findUser->createToken('API Token')->plainTextToken;
            return response()->json(['user' => $findUser, 'token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed', 'message' => $e->getMessage()], 500);
        }
    }
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            $findUser = User::where('social_id', $facebookUser->id)->orWhere('email', $facebookUser->email)->first();
            if ($findUser) {
                Auth::login($findUser);
                return response()->json($findUser);
            } else {
                $findUser = User::create(
                    [
                        'name' => $facebookUser->name,
                        'email' => $facebookUser->email,
                        "social_id" => $facebookUser->id,
                        'social_type' => 'facebook',
                        'account_type' => User::CLIENT,
                        'password' => Hash::make(uniqid())
                    ]
                );
                Auth::login($findUser);
                return response()->json($findUser);
            }

            $token = $findUser->createToken('API Token')->plainTextToken;
            return response()->json(['user' => $findUser, 'token' => $token]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed', 'message' => $e->getMessage()], 500);
        }
    }
}
