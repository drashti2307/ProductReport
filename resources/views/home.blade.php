    @extends('layouts.formLayout')
    @section('content')
        <select name="week" class="selection">
            @foreach ($arr as $i)
                <option value="{{ $i[0] }} - {{ $i[1] }}">{{ $i[0] }} - {{ $i[1] }}</option>
            @endforeach
        </select>
    @endsection
