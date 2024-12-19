<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/menthor/inscription', [AuthController::class, 'registerMenthor']);
Route::post('/menthorer/inscription', [AuthController::class, 'registerMenthorer']);
Route::post('/menthorer/login', [AuthController::class, 'loginMenthorer']);


