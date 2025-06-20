@extends('layouts.default')
@section('content')
    <table>
        <thead>
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
                $total = array_fill(0, count($dates), 0);
            @endphp
            @foreach ($productDetails as $productDetail)
                <tr>
                    <td><b>{{ $productDetail->product_name }}</b></td>
                    @foreach ($dates as $date)
                        @unless ($productDetail->$date == '')
                            @php $total[array_search($date, $dates)] += $productDetail->$date; @endphp
                        @endunless
                        <td style="text-align: center">{{ $productDetail->$date }}</td>
                    @endforeach
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <th>Total</th>
                @for ($i = 0; $i < count($dates); $i++)
                    <td style="text-align: center;">
                        @if ($total[$i] != 0)
                            <strong>{{ $total[$i] }}</strong>
                        @endif
                    </td>
                @endfor
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection
