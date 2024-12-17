<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MainPageController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::middleware(['main-group'])->group(function(){
    Route::get('/', [MainPageController::class,'getIndex'])->name('home');
    Route::get('/contact', [MainPageController::class,'getContact'])->name('contact');
    Route::get('/services', [MainPageController::class,'getServices'])->name('services');
});

// Authorization
Route::get('/login', [AuthenticationController::class,'getLogin'])->name('login.form');
Route::post('/authenticate',[AuthenticationController::class,'authenticate'])->name('login.auth');
Route::get('/sign-up',[AuthenticationController::class,'getSignUp'])->name('login.signup');
Route::post('/create-user',[AuthenticationController::class,'createUser'])->name('login.create-user');
Route::get('/sign-out',[AuthenticationController::class,'logout'])->name('login.signout');

//Email verification
Route::get('/email/verify',[AuthenticationController::class,'sendEmailVerification'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}',[AuthenticationController::class,'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
//Resend verification mail
Route::post('/email/verification-notification',[AuthenticationController::class,'resendEmailVerification'] )->middleware(['auth', 'throttle:6,1'])->name('verification.send');