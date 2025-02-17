<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\TextUI\Configuration\GroupCollection;
use App\Http\Controllers\Api\Front\AuthController;
use App\Http\Controllers\Api\Front\SocialAuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//this is route to social login
Route::prefix('auth')->controller(SocialAuthController::class)->group(function () {
    Route::get('google', 'redirectToGoogle')->name('social.google.redirect');
    Route::get('google/callback', 'handleGoogleCallback')->name('social.google.callback');
    Route::get('facebook', 'redirectToFacebook')->name('social.facebook.redirect');
    Route::get('facebook/callback', 'handleFacebookCallback')->name('social.facebook.callback');
});
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');
});
