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
            @foreach ($productDetails as $productDetail)
                <tr>
                    <td><b>{{ $productDetail['product_name'] }}</b></td>
                    @for ($i = 0; $i < count($dates); $i++)
                        <td style="text-align: center">{{ $productDetail['remaining_qty'][$i] }}</td>
                    @endfor
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