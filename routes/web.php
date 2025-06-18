<?php

use Illuminate\Contracts\View\View;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\weekCalculateController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home', ['arr' => weekCalculateController::getWeek()]);
});

Route::get('/report', [ProductController::class, 'weeklyReport']);