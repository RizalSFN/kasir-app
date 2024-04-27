<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kasir - App</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/bootstrap-icons.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.number.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
</head>
<body class="{{ $page == 'auth' ? 'bg-blue-500' : 'bg-white' }}">
    @yield('component')
</body>
</html>
