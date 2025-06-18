@extends('layouts.default')
@section('content')
    <table class="table table-bordered border-black">
        <thead>
            <tr>
                <th></th>
                @foreach ($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
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
                        <td>{{ $productDetail['remaining_qty'][$i] }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
