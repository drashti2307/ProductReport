<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{

    /**
     * get weeek interval from query to fetch remaining quantity data from db.
     *
     * @return view
     */
    public function weeklyReport()
    {
        $weekInterval = json_decode($_GET['week']);
        // return $weekInterval;
        $days = [];
        $dates = [];
        $start =  Carbon::parse($weekInterval[0]); // Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $end =  Carbon::parse($weekInterval[1]); // Carbon::now()->endOfWeek(Carbon::SATURDAY);
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $days[] = $day->format('l');
        }
        // return $days;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        // return $dates;
        $select = ['products.product_name'];
        foreach ($dates as $date) {
            $select[] = DB::raw("MAX(CASE WHEN report_date = '" . $date . "' THEN remaining_qty ELSE '' END) AS `" . $date . "`");
        }
        $productDetails = DB::table('products')
            ->join('product_reports', 'products.id', '=', 'product_reports.product_id')
            ->select($select)
            ->groupBy('products.product_name')
            ->get();

        // return $productDetails;
        // return view('report', ['days' => $days, 'dates' => $dates, 'productDetails' => $productDetails]);
        $pdf = PDF::loadView('report', ['days' => $days, 'dates' => $dates, 'productDetails' => $productDetails]);
        return $pdf->stream('ProductReport.pdf');
    }
}
