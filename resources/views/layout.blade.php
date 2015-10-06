<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="" />
    <meta name="Description" content="" />

    <title>@if(\App::environment() == 'local') Materialista @else {!! $options->company_name !!} | {!! $options->company_description !!} @endif</title>

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
        #cookieBanner {
            background-color: #F2F2F2;
            display: none;
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
    <div class="alert alert-dismissible alert-cookies" id="cookieBanner" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Cerrar</span>
        </button>
        Este sitio web utiliza cookies propias y de terceros para mejorar la experiencia de usuario y mostrarle publicidad relacionada con sus preferencias mediante el análisis de sus hábitos de navegación.
        Si está de acuerdo pulse <a href="javascript:;">Acepto</a> o siga navegando. Puede cambiar la configuración u obtener más información haciendo click en <a class="noconsent" href="http://politicadecookies.com/cookies.php" target="_blank">más información</a>.
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                @if(\App::environment() == 'local')
                    <h1><a href="{{route('home')}}" style="text-decoration:none;color:#4A4A4A;">Materialista</a></h1>
                @else
                    @if($options->pl_height > $options->pl_width)
                        <div style="display:inline-block;height:120px;width:{{ $options->pl_width * 120 / $options->pl_height }}px;
                                background-image: url('{{ asset('img/logos') }}/{!! $options->public_logo !!}');
                                background-size: contain;position:relative;">
                            <a href="{{route('home')}}" style="text-decoration:none;position:absolute;width:100%;height:100%;">
                            </a>
                        </div>
                    @else
                        <div style="display:inline-block;height:{{ $options->pl_height * 258 / $options->pl_width }}px;width:258px;
                                background-image: url('{{ asset('img/logos') }}/{!! $options->public_logo !!}');
                                background-size: contain;position:relative;">
                            <a href="{{route('home')}}" style="text-decoration:none;position:absolute;width:100%;height:100%;">
                            </a>
                        </div>
                    @endif
                @endif
            </div>
            <div class="col-xs-6 text-right">
                {{--TODO: change language--}}
            </div>
        </div>
    </div>

    @yield('content')

    <div class="container-fluid" id="footer">
        <div class="row">
            <div class="col-xs-12" style="padding-top:50px;padding-bottom:10px;">
                @if(\App::environment() == 'local')
                    <b>Materialista</b>
                @else
                    <b>{!! $options->company_name !!}</b>
                    @endif
                    &copy;
                    @if(\Carbon\Carbon::now()->format('Y') > $options->starting_year)
                        {!! $options->starting_year !!}-{!! \Carbon\Carbon::now()->format('Y') !!}
                    @else
                        {!! $options->starting_year !!}
                    @endif
            </div>
        </div>
    </div>

    {{--Common JS--}}
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/consent.js') }}"></script>

    {{--Page related JS--}}
    @yield('js')

</body>
</html>

