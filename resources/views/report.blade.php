@extends('layouts.default')
@section('content')
<table class="table table-bordered border-black">
    <thead>
        <tr>
            <th></th>
            @foreach($days as $day)
                <th scope="col">{{ $day }}</th>
            @endforeach

            @foreach($dates as $date)
                <th scope="col">{{ $date }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($productDetails as $productDetail)
                <td>{{ $productDetail->p_name }}</th>
                <td>{{ $productDetail->remaining_qty }}</th>
            @endforeach
        </tr>
    </tbody>
</table>
@endsection
