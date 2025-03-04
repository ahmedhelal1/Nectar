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
    Route::Post('send-code', 'sendOtpCode')->name('send-code');
    Route::Post('verify', 'verifyOtpCode')->name('verify');
    Route::post('forget-password', 'forgetPassword')->name('forget-password');
    Route::post('reset-password', 'resetPassword')->name('reset-password');
});

Route::prefix('address')->controller(AddressController::class)->group(
    function () {
        Route::get('governorates', 'getGovernorates')->name('governorates');
        Route::get('cities', 'getCities')->name('cities');
        Route::get('address', 'getAddress')->middleware('auth:sanctum');
        Route::Post('create-address', 'store')->middleware('auth:sanctum');
    }
);

Route::get('get-category', [CategoryController::class, 'index']);
Route::get('index_product', [ProductController::class, 'index']);
Route::get('get-product/{id}', [ProductController::class, 'getProduct']);
Route::post('create-product', [ProductController::class, 'store'])->middleware('auth:sanctum');;
Route::prefix('cart')->middleware('auth:sanctum')->controller(CartController::class)->group(
    function () {
        Route::get('get-cart', 'getCart')->name('get-cart');
        Route::post('add-to-cart', 'addToCart')->name('add-to-cart');
        Route::delete('remove-from-cart', 'removeFromCart')->name('remove-from-cart');
        Route::post('update-cart', 'updateCartQuantity')->name('update-cart');

        // Route::post('applyCoupon', 'applyCoupon');
        // Route::post('checkout', 'checkout');
    }
);
