<?php

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\weekCalculate;
use  App\Http\Controllers\WeeklyData;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home', ['arr' => weekCalculate::getWeek()]);
});

Route::get('/report/{query}', [WeeklyData::class, 'showData']);
