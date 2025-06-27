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
})->name('home');

Route::post('/report', [ProductController::class, 'weeklyReport'])->name('report');

Route::get('/report', function () {
    return redirect()->route('home');
});
