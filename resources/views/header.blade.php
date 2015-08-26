<div class="container">
    <div class="row">
        <div class="col-xs-6">
            @if(\App::environment() == 'local')
                <h1>Materialista</h1>
            @else
                <div style="display:inline-block;height:100px;width:215px;
                        background-image: url('{{ asset('img/logo-valkiria.png') }}');
                        background-size: contain;">
                </div>
            @endif
        </div>
        <div class="col-xs-6 text-right">
            {{--TODO: change language--}}
        </div>
    </div>
</div>