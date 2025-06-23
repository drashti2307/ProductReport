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
     * get weeek interval using request to fetch weekly remaining quantity for each product
     * and daily total from daabase.
     *
     * @return view
     */
    public function weeklyReport(Request $request)
    {
        // Decode the week interval from the request
        $weekInterval = json_decode($request->input('week'));

        $days = $dates = [];

        // Create a CarbonPeriod to iterate through the week
        $start =  Carbon::parse($weekInterval[0]); // Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $end =  Carbon::parse($weekInterval[1]); // Carbon::now()->endOfWeek(Carbon::SATURDAY);

        // Collect the names of the days in given week interval
        for ($day = $start->copy(); $day->lte($end); $day->addDay()) {
            $days[] = $day->format('l');
        }
        // return $days;

        // Collect the dates in given week interval
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        // return $dates;

        // Fetch product reports within the specified date range
        // and map them to the required format

        $productDetails = ProductReport::with('product')
            ->whereDate('report_date', '>=', $start->format('Y-m-d'))
            ->whereDate('report_date', '<=', $end->format('Y-m-d'))
            ->orderBy(Product::select('products.product_name')->whereColumn('products.id', 'product_reports.product_id'))
            ->get()
            ->map(function ($report) use ($dates) {
                $data = ['product_id' => $report->product->id];
                foreach ($dates as $date) {
                    if ($report->report_date == $date)
                        $data[$date] = $report->remaining_qty;
                }
                return ($data);
            });

        // Calculate the total remaining quantity for each date in the week and ordered by report_date
        // The result will be a collection of total quantities indexed by report_date

        $total = ProductReport::with('product')
            ->whereDate('report_date', '>=', $start->format('Y-m-d'))
            ->whereDate('report_date', '<=', $end->format('Y-m-d'))
            ->select('report_date', DB::raw('SUM(remaining_qty) as total'))
            ->groupBy('report_date')
            ->orderBy('report_date')
            ->get()
            ->pluck('total', 'report_date');

        // Prepare the product names and IDs for the view
        $product = Product::select('product_name', "id")
            ->orderBy('product_name')
            ->pluck('product_name', "id")->toArray();

        // return a view with the data
        return view('report', ['days' => $days, 'dates' => $dates, 'productDetails' => $productDetails, "products" => Product::pluck('product_name', "id")->toArray(), 'querytotal' => $total]);

        // Generate a PDF from the view and stream it to the browser
        $pdf = PDF::loadView('report', ['days' => $days, 'dates' => $dates, 'productDetails' => $productDetails, "products" => $product, 'querytotal' => $total]);
        return $pdf->stream('ProductReport.pdf');
        // return $pdf->download('ProductReport.pdf');
    }
}
