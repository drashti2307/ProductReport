@extends('layouts.default')
@section('content')
    <table>
        <thead>
            <tr>
                <th></th>
                @foreach ($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
                <th rowspan="2">Result</th>
            </tr>
            <tr>
                <th>Date</th>
                @foreach ($dates as $date)
                    <th>{{ $date }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($productDetails as $productDetail)
                <tr>
                    <td>{{ $productDetail['p_name'] }}</td>
                    @for ($i = 0; $i < count($dates); $i++)
                        <td style="text-align: center">{{ $productDetail['remaining_qty'][$i] }}</td>
                    @endfor
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <th>Total</th>
                @foreach ($total as $cell)
                    <td style="text-align: center">
                        @if ($cell != 0)
                            {{ $cell }}
                        @endif
                    </td>
                @endforeach
                <td></td>
            </tr>
        </tbody>
    </table>
@endsection
