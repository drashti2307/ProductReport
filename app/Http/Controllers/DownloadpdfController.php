<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class DownloadpdfController extends Controller
{
    /**
     * Handle the incoming request to download the PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response / downloaded file
     */
    public function __invoke(Request $request)
    {
        // Check if the request has a 'download' parameter
        if ($request->has('download')) {
            $path = $request->input('download');
            return response()->streamDownload(function () use ($path) {
                echo file_get_contents($path);
            }, 'ProductReport.pdf');

        // If 'download' parameter is not provided, throw an exception
        throw new Exception('Path for downloading pdf not provided.',400);
    }
}
}
