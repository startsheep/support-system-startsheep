<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Startsheep Support System</title>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    @vite('resources/css/app.css')
</head>

<body>
    @yield('content')

    @vite('resources/js/app.js')
</body>

</html>
