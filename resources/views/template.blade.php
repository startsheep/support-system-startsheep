<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Startsheep Support System</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('assets/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    @yield('content')

    @vite('resources/js/app.js')
    <script src="{{ asset('assets/app.js') }}"></script>
    <script src="{{ asset('assets/jquery-3.6.1.min.js') }}"></script>
</body>

</html>
