@extends('layouts.page')
@section('content')
    <div style="height: 100%;">
        <div style="position: relative;">
            <div>
                <iframe src="https://product-report-123456.s3.eu-north-1.amazonaws.com/report.pdf" style="width: 100%; height: 100%;">
            </div>
            <div style="position: absolute;width: 100px;height: 100px;right: 12px;bottom: 12px;">
                <form method="post" action="{{ route('report', ['download' => 'pdf']) }}"
                    style="height: 100%;width:100%; position: relative;">
                    @csrf
                    <input type="hidden" name="week" value='@php echo(json_encode([$week[0] ,$week[1] ])); @endphp'>
                    <button type="submit" title="download"
                        style="position: absolute;;right: 14px;bottom: 2px;width: 80px;border-radius: 50%;height: 80px;background-color: rgba(96, 157, 159, 0.89);border:0;">
                        <i class="bi bi-download"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
