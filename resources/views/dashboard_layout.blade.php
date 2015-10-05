<!DOCTYPE html>
<!--[if IE 8]> <html lang="es" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="es" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    @yield('title')

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simple-line-icons.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/uniform.default.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}" id="style_components" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/layout.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/darkblue.css') }}" id="style_color"/>

    @if(\App::environment() == 'local')
    <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
    <style>
        #logo {
            text-decoration: none;
            color: #FFF;
        }
        #logo > h2, h1 {
            font-family: 'Dancing Script', cursive;
        }
        h1 {
            font-size: 136px;
        }
    </style>
    @endif

    @yield('css')

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-style-square">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner">
            <div class="page-logo">
                <a id="logo" href="{{ route('home') }}" style="text-decoration:none;">
                    @if(\App::environment() == 'local')
                        <h2 style="margin:10px 0 0 0;padding:0;">Materialista</h2>
                    @else
                        <img src="{{ asset('img/logo-valkiria-2.png') }}" height="35" alt="Valkiria" style="margin-top:5px;"/>
                    @endif
                </a>
                <div class="menu-toggler sidebar-toggler hide">
                </div>
            </div>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="username username-hide-on-mobile">
                        @if(Auth::check())
                                {!! Auth::user()->name !!}
                            @else
                                Invitado
                            @endif
                        </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ url('/auth/logout') }}">
                                    <i class="icon-key"></i> Salir </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix">
    </div>

    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li class="sidebar-toggler-wrapper">
                        <div class="sidebar-toggler" style="margin-bottom:8px;">
                        </div>
                    </li>
                    <li class="start @if(Request::is('dashboard')) active open @endif ">
                        <a href="{{ route('dashboard.home') }}">
                            <i class="icon-home"></i>
                            <span class="title">Inicio</span>
                            @if(Request::is('dashboard')) <span class="selected"></span> @endif
                        </a>
                    </li>
                    <li class=" @if(Request::is('dashboard/newAd')) active open @endif ">
                        <a href="{{ route('dashboard.newAd') }}">
                            <i class="icon-plus"></i>
                            <span class="title">Nuevo anuncio</span>
                            @if(Request::is('dashboard/newAd')) <span class="selected"></span> @endif
                        </a>
                    </li>
                    <li class=" @if(Request::is('dashboard/editAd')) active open @endif ">
                        <a href="{{ route('dashboard.editAd') }}">
                            <i class="icon-pencil"></i>
                            <span class="title">Editar anuncios</span>
                            @if(Request::is('dashboard/editAd')) <span class="selected"></span> @endif
                        </a>
                    </li>
                    <li class=" @if(Request::is('dashboard/config')) active open @endif ">
                        <a href="{{ route('dashboard.config') }}">
                            <i class="icon-wrench"></i>
                            <span class="title">Configuración</span>
                            @if(Request::is('dashboard/config')) <span class="selected"></span> @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
            @yield('content')
            </div>
        </div>

    </div>

    <div class="page-footer">
        <div class="page-footer-inner">
            @if(\App::environment() == 'local') Materialista @else Valkiria @endif &copy; 2015-2016. Gestor de contenidos v0.1
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>

    <!--[if lt IE 9]>
    <script src="{{ asset('js/respond.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/excanvas.min.js') }}" type="text/javascript"></script>
    <![endif]-->
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-migrate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.blockui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.cokie.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toastr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/metronic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/layout.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/quick-sidebar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/demo.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            // initiate layout and plugins
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            QuickSidebar.init(); // init quick sidebar
            Demo.init(); // init demo features
        });
    </script>

    @if(Session::has('success'))
        <input type="hidden" name="Stitle" value="{{ session('success')['Stitle'] }}">
        <input type="hidden" name="Smsg" value="{{ session('success')['Smsg'] }}">
        <script>
            jQuery(document).ready(function() {
                var sessionTitle = $('input[name=Stitle]').val();
                var sessionMsg = $('input[name=Smsg]').val();
                toastr['success'](sessionMsg,sessionTitle,{
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            });
        </script>
    @endif
    @if(\Session::has('info'))
        <input type="hidden" name="Ititle" value="{{ session('info')['Ititle'] }}">
        <input type="hidden" name="Imsg" value="{{ session('info')['Imsg'] }}">
        <script>
            jQuery(document).ready(function() {
                var sessionTitle = $('input[name=Ititle]').val();
                var sessionMsg = $('input[name=Imsg]').val();
                toastr['info'](sessionMsg,sessionTitle,{
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            });
        </script>
    @endif
    @if (\Session::get('warning'))
        <input type="hidden" name="Wtitle" value="{{ session('warning')['Wtitle'] }}">
        <input type="hidden" name="Wmsg" value="{{ session('warning')['Wmsg'] }}">
        <script>
            jQuery(document).ready(function() {
                var sessionTitle = $('input[name=Wtitle]').val();
                var sessionMsg = $('input[name=Wmsg]').val();
                toastr['warning'](sessionMsg,sessionTitle,{
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            });
        </script>
    @endif
    @if (\Session::get('error'))
        <input type="hidden" name="title" value="{{ session('error')['Etitle'] }}">
        <input type="hidden" name="msg" value="{{ session('error')['Emsg'] }}">
        <script>
            jQuery(document).ready(function() {
                var sessionTitle = $('input[name=title]').val();
                var sessionMsg = $('input[name=msg]').val();
                toastr['error'](sessionMsg,sessionTitle,{
                    "closeButton": true,
                    "debug": false,
                    "positionClass": "toast-bottom-right",
                    "onclick": null,
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            });
        </script>
    @endif

    @yield('js')

</body>
</html>
