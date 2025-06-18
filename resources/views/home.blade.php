    @extends('layouts.formLayout')
    @section('content')
        <select name="week" class="selection">
            @foreach ($arr as $i)
                <option
                    value='@php echo json_encode([ $i[0] ,$i[1] ]); @endphp'>
                    {{ $i[0] }} - {{ $i[1] }}</option>
            @endforeach
        </select>
    @endsection
