<?php

namespace App\Http\Controllers;

class weekCalculateController extends Controller
{
    /**
     * get weeek intervals of current month and returns as json array.
     *
     * @return array
     */
    static function getWeek(): array
    {
        $month = date('06');
        $year = date('Y');
        $week = date('W', strtotime(date('Y-06-2')));

        $arr = [];
        $start = date('06/01/Y');
        $unix = strtotime($year . 'W' . $week . '+6 days');
        while (date('m', $unix) == $month) {
            $end = date('m/d/Y', $unix - 86400);
            $arr[] = [$start, $end];
            $start = date('m/d/Y', $unix);
            $unix = $unix + 86400 * 7;
        }
        $end = date('m/d/Y', strtotime('last day of ' . $year . '-' . $month));
        $arr[] = [$start, $end];
        return $arr;
    }
}
