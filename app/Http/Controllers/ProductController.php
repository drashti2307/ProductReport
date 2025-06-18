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

        $productDetails = DB::table('products')
            ->join('product_reports', 'products.p_id', '=', 'product_reports.p_id')
            ->select('products.p_name', 'product_reports.report_date', 'product_reports.remaining_qty')
            ->orderBy('products.p_name', 'asc')
            ->orderBy('product_reports.report_date', 'asc')
            ->where('product_reports.report_date', '>=', $start->format('Y-m-d'))
            ->where('product_reports.report_date', '<=', $end->format('Y-m-d'))
            ->get();

        $transformed = $this->transformProductDetails($productDetails, $dates);
        $total = $this->totalRemainings($transformed, $dates);
        // return $transformed;
        // return $total;
        // return view('report', ['days' => $days, 'dates' => $dates, 'productDetails' => $transformed, 'total' => $total]);
        $pdf = PDF::loadView('report', ['days' => $days, 'dates' => $dates, 'productDetails' => $transformed, 'total' => $total]);
        return $pdf->stream('ProductReport.pdf');
    }


    /**
     * Transform product details to group by product name and map remaining_qty to week days.
     *
     * @param array $productDetails
     * @param array $dates
     * @return array
     */
    public function transformProductDetails($productDetails, $dates)
    {
        $result = [];
        foreach ($productDetails as $item) {
            $p_name = $item->p_name;
            if (!isset($result[$p_name])) {
                $result[$p_name] = [
                    'p_name' => $p_name,
                    'remaining_qty' => array_fill(0, count($dates), ""),
                ];
            }
            $dateIndex = array_search($item->report_date, $dates);
            if ($dateIndex !== false) {
                $result[$p_name]['remaining_qty'][$dateIndex] = $item->remaining_qty;
            }
        }
        return array_values($result);
    }


    public function totalRemainings($transformed, $dates)
    {
        $total = array_fill(0, count($dates), 0);
        foreach ($transformed as $productDetail) {
            for ($i = 0; $i < count($dates); $i++) {
                if ($productDetail['remaining_qty'][$i] !== "")
                    $total[$i] = array_sum(array($total[$i], $productDetail['remaining_qty'][$i]));
            }
        }
        return $total;
    }
}
