<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Report</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    @include('includes.style')
</head>

<body>
    <main>
        <div class="card mt-5 p-5 shadow mb-5 bg-white rounded" id="weekForm">
            <h4 class="card-title">Select Week</h4>
            <form action="report" method="POST">
                @csrf
                <div class="card-body">
                    {{-- Selection of week interval --}}
                    <select name="week" class="form-select mb-3">
                        @foreach ($arr as $i)
                            <option value='@php echo json_encode([ $i[0] ,$i[1] ]); @endphp'>
                                {{ $i[0] }} - {{ $i[1] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mx-auto">
                    <button type="submit" class="btn btn-success">Get Report</button>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
</body>

</html>
