<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="" />
    <meta name="Description" content="" />

    <title>Materialista</title>

    {{--Common CSS--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        #footer {
            background-color: #F2F2F2;
            color: #4A4A4A;
            font-size: 14px;
        }
    </style>
    {{--Page related CSS--}}
    @yield('css')
    @if(\App::environment() == 'local')
        <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
        <style>
            h1 {
                font-family: 'Dancing Script', cursive;
                font-size: 50px;
            }
        </style>
    @endif
</head>
<body>
    @include('header')

    @yield('content')

    @include('footer')
    {{--Common JS--}}
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    {{--Page related JS--}}
    @yield('js')
</body>
</html>

