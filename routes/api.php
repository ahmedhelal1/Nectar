<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use PHPUnit\TextUI\Configuration\GroupCollection;
use App\Http\Controllers\Api\Front\{
    AuthController,
    SocialAuthController,
    AddressController,
    CategoryController,
    ProductController,
    CartController
};

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// //this is route to social login
// Route::prefix('auth')->controller(SocialAuthController::class)->group(function () {
//     Route::get('google', 'redirectToGoogle')->name('social.google.redirect');
//     Route::get('google/callback', 'handleGoogleCallback')->name('social.google.callback');
//     Route::get('facebook', 'redirectToFacebook')->name('social.facebook.redirect');
//     Route::get('facebook/callback', 'handleFacebookCallback')->name('social.facebook.callback');
// });

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:sanctum');
    Route::Post('sendCode', 'sendOtpCode')->name('sendCode');
    Route::Post('verify', 'verifyOtpCode')->name('verify');
    Route::post('forgetPassword', 'forgetPassword')->name('forgetPassword');
    Route::post('resetPassword', 'resetPassword')->name('resetPassword');
});

Route::prefix('address')->controller(AddressController::class)->group(
    function () {
        Route::get('getGovernorates', 'getGovernorates');
        Route::get('getCities', 'getCities');
        Route::get('getAddress', 'getAddress')->middleware('auth:sanctum');
        Route::Post('createAddress', 'store')->middleware('auth:sanctum');
    }
);
Route::get('getCategory', [CategoryController::class, 'index']);
Route::get('indexProduct', [ProductController::class, 'index']);
Route::get('getProduct/{id}', [ProductController::class, 'getProduct']);
Route::post('createProduct', [ProductController::class, 'store'])->middleware('auth:sanctum');;
Route::prefix('cart')->middleware('auth:sanctum')->controller(CartController::class)->group(
    function () {
        Route::get('getCart', 'getCart')->name('getCart');
        Route::post('addToCart', 'addToCart')->name('addToCart');
        Route::delete('removeFromCart', 'removeFromCart')->name('removeFromCart');

        // Route::post('updateCart', 'updateCart');
        // Route::post('applyCoupon', 'applyCoupon');
        // Route::post('checkout', 'checkout');
    }
);
