<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MainPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainPageController::class,'getIndex']);
Route::get('/login', [AuthenticationController::class,'getLogin'])->name('login.form');


Route::post('/authenticate',[AuthenticationController::class,'authenticate'])->name('login.auth');