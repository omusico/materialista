<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <title>@if(\App::environment() == 'local') Materialista | Login @else Valkiria | Acceso @endif</title>

    @if(\App::environment() == 'local')
        <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
    @endif
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/darkblue.css') }}" rel="stylesheet" type="text/css" id="style_color"/>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    <style>
        .login .content {
            margin: 10px auto 10px;
        }
        .login {
            background-color: rgb(255, 255, 255) !important;
        }
        .login .content {
            background-color: rgb(239, 239, 239);
        }
        .login .content h3 {
            color: #959595;
        }
        .login .content .form-control {
            background-color: #ffffff;
            height: 43px;
            color: #111111;
            border: 1px solid #919399;
        }
        .login .content .form-actions {
            border-width: 0;
        }
        .btn-warning {
            background-color: #F26721;
            border-color: #F26721;
        }

        .btn-warning:hover,
        .btn-warning:focus,
        .btn-warning.focus,
        .btn-warning:active,
        .btn-warning.active,
        .open > .dropdown-toggle.btn-warning {
            background-color: #ca561c !important;
            border-color: #ca561c !important;
        }

        @if(\App::environment() == 'local')
        #logo {
            text-decoration:none;
        }
        #logo > h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 75px;
            color:#4A4A4A;
        }
        @endif
    </style>
</head>
<body class="login">
    <div class="menu-toggler sidebar-toggler"></div>
    <div class="container">
        <div class="col-xs-offset-0 col-xs-12 col-sm-offset-2 col-sm-8 col-md-offset-4 col-md-4 text-center" style="margin-top:60px;">
            <a href="{{ route('home') }}" id="logo">
            @if(\App::environment() == 'local')
                <h1>Materialista</h1>
            @else
                <img width="100%" src="{{ asset('img/logo-valkiria.png') }}" alt=""/>
            @endif
            </a>
        </div>
    </div>
    <div class="content">
        <form class="login-form" action="{{ route('auth.doLogin') }}" method="post">
            {!! csrf_field() !!}
            <h3 class="form-title">Acceso</h3>
            @if($errors->count())
            <div class="alert alert-error alert-danger">
                @foreach ($errors->all() as $error)
                    {!! $error !!}<br/>
                @endforeach
            </div>
            @endif
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span>
                Introduzca su nombre de usuario y contrase&ntilde;a.</span>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Usuario</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Su e-mail" name="email"/>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Contrase&ntilde;a</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Su contrase&ntilde;a" name="password"/>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-warning uppercase">Entrar</button>
                {{--<label class="rememberme check">--}}
                    {{--<input type="checkbox" name="remember" value="1"/>Recordarme </label>--}}
                {{--<a href="javascript:;" id="forget-password" class="forget-password">He olvidado la contrase&ntilde;a</a>--}}
            </div>
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        {{--<form class="forget-form" action="TODO: forgotpassword controller" method="post">--}}
            {{--<input type="hidden" name="_token" value="{!! Session::getToken() !!}">--}}
            {{--<h3>He olvidado la contrase&ntilde;a</h3>--}}
            {{--<p>--}}
               {{--Introduzca su e-mail para restablecer su contrase&ntilde;a.--}}
            {{--</p>--}}
            {{--<div class="form-group">--}}
                {{--<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Su e-mail" name="email"/>--}}
            {{--</div>--}}
            {{--<div class="form-actions">--}}
                {{--<button type="button" id="back-btn" class="btn btn-default">Volver</button>--}}
                {{--<button type="submit" class="btn btn-warning uppercase pull-right">Enviar</button>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- END FORGOT PASSWORD FORM -->
    </div>
    <div class="copyright">
        2015-2016 © @if(\App::environment() == 'local') Materialista @else Valkiria @endif
    </div>
    <!--[if lt IE 9]>
    <script src="scripts3/respond.min.js"></script>
    <script src="scripts3/excanvas.min.js"></script>
    <![endif]-->
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.cokie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.uniform.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/metronic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/layout.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/login.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            Login.init();
            Demo.init();
        });
    </script>
</body>
</html>