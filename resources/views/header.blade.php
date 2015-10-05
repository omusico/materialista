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
                <div style="display:inline-block;height:120px;width:258px;
                        background-image: url('{{ asset('img/logos') }}/{!! $options->public_logo !!}');
                        background-size: contain;position:relative;">
                    <a href="{{route('home')}}" style="text-decoration:none;position:absolute;width:100%;height:100%;">
                    </a>
                </div>
            @endif
        </div>
        <div class="col-xs-6 text-right">
            {{--TODO: change language--}}
        </div>
    </div>
</div>