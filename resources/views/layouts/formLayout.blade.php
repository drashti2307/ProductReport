<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body>
    <main>
        <form action="report">
            @method('get')
            @yield('content')
            <button type="submit">Get Report</button>
        </form>
    </main>
</body>
</html>
