@extends('layouts.page')
@section('content')
    <div style="height: 100%;">
        <div style="position: relative;">
            <div>
                {{-- Display saved pdf from s3 bucket using url --}}
                <embed src="{{ $url }}#toolbar=0" style="width: 100%; height: 100%;">
            </div>
            <div style="position: absolute;width: 100px;height: 100px;right: 12px;bottom: 12px;">
                {{-- Download button to download the pdf which redirects to report route with file url --}}
                <form method="post" action="{{ route('report', ['download' => $path ]) }}"
                    style="height: 100%;width:100%; position: relative;">
                    @csrf
                    <button type="submit" title="download"
                        style="position: absolute;;right: 14px;bottom: 2px;width: 80px;border-radius: 50%;height: 80px;background-color: rgba(96, 157, 159, 0.89);border:0;">
                        <i class="bi bi-download"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
