<?php

namespace App\Http\Controllers;

class weekCalculateController extends Controller
{
    static function getWeek() : array {
        $month = date('m');
        $year = date('Y');
        $week = date('W', strtotime(date('Y-m-2')));

        $arr = [];
        $start = date('1/m/Y');
        $unix = strtotime($year . 'W' . $week . '+6 days');
        while (date('m', $unix) == $month) {
            $end = date('d/m/Y', $unix - 86400);
            $arr[] = [$start, $end];
            $start = date('d/m/Y', $unix);
            $unix = $unix + 86400 * 7;
        }
        $end = date('d/m/Y', strtotime('last day of ' . $year . '-' . $month));
        $arr[] = [$start, $end];
        return $arr;
    }
}
