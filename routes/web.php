<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MainPageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', [MainPageController::class,'getIndex']);

// Authorization
Route::get('/login', [AuthenticationController::class,'getLogin'])->name('login.form');
Route::post('/authenticate',[AuthenticationController::class,'authenticate'])->name('login.auth');
Route::get('/sign-out',[AuthenticationController::class,'logout'])->name('login.signout');
Route::get('/sign-up',[AuthenticationController::class,'signUp'])->name('login.signout');

//Email verification
Route::get('/email/verify',function () {
    return view('authorization_pages.email_verification');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Na twoje konto email wysłano wiadomość z linkiem aktywacynym');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');