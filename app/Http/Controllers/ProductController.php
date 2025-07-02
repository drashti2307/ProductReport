<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * get weeek interval using request to fetch weekly remaining quantity for each product
     * and daily total from daabase.
     *
     * @return view
     */
    static public function weeklyReport(Request $request)
    {
        // Decode the week interval from the request
        $weekInterval = json_decode($request->input('week'));

        $days = $dates = [];

        // Create CarbonPeriod to iterate through the week
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
        $week = ProductReport::with('product')
            ->whereDate('report_date', '>=', $start->format('Y-m-d'))
            ->whereDate('report_date', '<=', $end->format('Y-m-d'));

        $productDetails = $week
            // ->orderBy(Product::select('products.product_name')->whereColumn('products.id', 'product_reports.product_id'))
            ->get()
            ->map(function ($report) use ($dates) {
                $data = ['product_id' => $report->product->id];
                foreach ($dates as $date) {
                    if ($report->report_date == $date)
                        $data[$date] = $report->remaining_qty;
                }
                return ($data);
            });

        /* Calculate the total remaining quantity for each date in the week and ordered by
        report_date The result will be a collection of total quantities indexed by report_date */

        $total = $week
            ->reorder()
            ->Select('report_date', DB::raw('SUM(remaining_qty) as total'))
            ->groupBy('report_date')
            ->orderBy('report_date')
            ->get()
            ->pluck('total', 'report_date');

        // Prepare the product names and IDs for the view
        $product = Product::select('product_name', "id")
            ->orderBy('product_name')
            ->pluck('product_name', "id")->toArray();

        // Load view into PDF using the data collected
        $pdf = PDF::loadView(
            'report',
            [
                'days' => $days,
                'dates' => $dates,
                'productDetails' => $productDetails,
                "products" => $product,
                'querytotal' => $total,
            ]
        );

        // Get the content of the PDF
        $content = $pdf->output();

        // Define the path where the PDF will be stored And upload it to the S3 storage
        $uploadedPath = 'pdfs/report(week-' . $start->weekNumberInMonth . ').pdf';
        Storage::disk('s3')->put($uploadedPath, $content);
        $url = Storage::cloud()->url($uploadedPath);

        $assignedUrl = $url;
        $disk = Storage::disk('s3');
        if(method_exists($disk, 'temporaryUrl'))
            $assignedUrl = $disk->temporaryUrl($uploadedPath, now()->addMinutes(30));

        return redirect($assignedUrl);
    }
}
