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
    public function weeklyReport() {
        // $product = DB::table('products')
        //     ->select('p_id', 'p_name',)
        //     ->whereColumn('p_id', 'product_reports.p_id');

        // $reports = DB::table('product_reports')
        //     ->joinLateral($product, 'report_date')->get();
        // return $reports;

        // $report = DB::table('products')
        //     ->join('product_reports', function (JoinClause $join) {
        //         $join->on('products.p_id', '=', 'product_reports.p_id')
        //             ->where('product_reports.report_date', '=', '2025-06-08')
        //             ->where('product_reports.report_date', '=', '2025-06-14');
        //     })
        //     ->get();
        // return $report;
        // $weekStartDate = Carbon::now()->startOfWeek();
        // $weekEndDate = Carbon::now()->endOfWeek();
        // // $productionData = ProductReport::whereBetween('report_date', [$weekStartDate, $weekEndDate])->get();
        // // return $productionData;
        // $product = Product::with(['product_reports' => function($query)
        //  use ($weekStartDate, $weekEndDate) {
        //     $query->whereBetween('report_date', [$weekStartDate, $weekEndDate]);
        // }])->get();

        // return $product;

        // $startDate = Carbon::now()->subDays(7);
        // $weeklyData = [];
        // for ($i = 0; $i < 7; $i++) {
        //     $date = $startDate->copy()->addDays($i);
        //     $weeklyData[$date->format('Y-m-d')] = [
        //         'p_name',
        //         'remaining_qty' => rand(1, 10),
        //     ];
        // }

        $days = [];
        $dates = [];
        $start = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $end = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $days[] = $day->format('l');
        }
        // return $days;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        // return $dates;

        $productDetails = DB::table('products')
            ->join('product_reports', 'products.p_id', '=', 'product_reports.p_id')
            ->select('products.p_name', 'product_reports.report_date', 'product_reports.remaining_qty')
            ->orderBy('products.p_name', 'asc')
            // ->orderBy('product_reports.report_date', 'asc')
            ->where('product_reports.report_date', '>=', $start->format('2025-06-15'))
            ->where('product_reports.report_date', '<=', $end->format('Y-m-d'))
            ->get();

        // return $productDetails;
        return view('report', [ 'days' => $days, 'dates' => $dates, 'productDetails' => $productDetails]);
    }
}
