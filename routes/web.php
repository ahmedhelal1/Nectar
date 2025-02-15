<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Front\SocialAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('auth')->controller(SocialAuthController::class)->group(function () {
    Route::get('google', 'redirectToGoogle')->name('social.google.redirect');
    Route::get('google/callback', 'handleGoogleCallback')->name('social.google.callback');
    Route::get('facebook', 'redirectToFacebook')->name('social.facebook.redirect');
    Route::get('facebook/callback', 'handleFacebookCallback')->name('social.facebook.callback');
});
