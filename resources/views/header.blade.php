<div class="container">
    <div class="row">
        <div class="col-xs-6">
            @if(\App::environment() == 'local')
                <h1><a href="{{route('home')}}" style="text-decoration:none;color:#4A4A4A;">Materialista</a></h1>
            @else
                <div style="display:inline-block;height:100px;width:215px;
                        background-image: url('{{ asset('img/logo-valkiria.png') }}');
                        background-size: contain;position:relative;">
                    <a href="{{route('home')}}" style="text-decoration:none;position:absolute;width:100%;height:100%;">&nbsp;</a>
                </div>
            @endif
        </div>
        <div class="col-xs-6 text-right">
            {{--TODO: change language--}}
        </div>
    </div>
</div>