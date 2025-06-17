<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WeeklyData extends Controller
{
    public static function showData(string $query): View
    {
        /**
         * get data from url query and pass to db query
         * db query fetches some output
         * show fetched data on screen
         */
        return view("report");
    }
}
