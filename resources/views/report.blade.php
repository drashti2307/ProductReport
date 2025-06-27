@extends('layouts.default')
@section('content')
    <div>
        <div class="col-md-12 col-md-offset-1 mx-2">
            <div class="table-responsive">
                <table>
                    <thead>
                        {{-- This section generates the table header with the days of the week and the dates.
                It uses the $days array to display the days of the week and the $dates array for the dates. --}}
                        <tr>
                            <th></th>
                            @for ($i = 0; $i < count($days); $i++)
                                <th>{{ $days[$i] }}</th>
                            @endfor
                            <th rowspan="2">Result</th>
                        </tr>
                        <tr>
                            <th>Date</th>
                            @for ($i = 0; $i < count($dates); $i++)
                                <th>{{ $dates[$i] }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            echo '<script>
                                console.log(' . json_encode($productDetails, JSON_PRETTY_PRINT) . ');
                            </script>';

                            // format the product details array to have product IDs as keys
                            // and dates as sub-keys for each product generating a matrix like structure
                            $merged = [];
                            foreach ($productDetails as $report) {
                                $productName = $report['product_id'] ?? null;

                                // $products = array_diff($products, [$productName]);
                                foreach ($report as $key => $value) {
                                    if ($key !== 'product_id') {
                                        $merged[$productName][$key] =
                                            $value !== '' ? $value : $merged[$productName][$key] ?? '';
                                    }
                                }
                            }

                            // Debugging output to check the structure of formatted data
                            echo '<script>
                                console.log(' . json_encode($merged, JSON_PRETTY_PRINT) . ');
                            </script>';
                            $productDetails = $merged;
                        @endphp

                        {{-- This section generates the table rows for each remaining/throwable product and its corresponding dates.
                It uses the formatted $productDetails array to display the remaining product values for each date. --}}

                        @foreach ($products as $key => $productnamel)
                            <tr>
                                <td><b>{{ $products[$key] }}</b></td>
                                @foreach ($dates as $index => $date)
                                    <td style="text-align: center">{{ $productDetails[$key][$date] ?? '' }}</td>
                                @endforeach
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        {{-- This section generates the footer row that displays the total remaining products for each date.
                It uses the $querytotal array to get the total values for each date. --}}
                        <tr>
                            <th>Total</th>
                            @foreach ($dates as $date)
                                <td style="text-align: center;">
                                    <strong>{{ $querytotal[$date] ?? '' }}</strong>
                                </td>
                            @endforeach
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @if (!$download)
                <div class="row">
                    <div class="col-sm-12">
                        <form method="post" action='{{ route('report', ['download' => 'pdf']) }}'>
                            @csrf
                            <input type="hidden" name="week"
                                value='@php echo(json_encode([$dates[0] ,$dates[count($dates)-1] ])); @endphp'>
                            <button type="submit" title="download" class="download-btn"><i class="bi bi-download"></i></button>
                        </form>
                        {{-- <a href="{{ route('report', ['download' => 'pdf']) }}">download</a> --}}
                    </div>
                </div>
                <br>
            @endif
        </div>
    </div>
@endsection
