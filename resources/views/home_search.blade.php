@extends('layout')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/uniform.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}">

    @if(\App::environment() == 'local')
    <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
    <style>
        h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 50px;
        }
        h4 {
            font-family: 'Dancing Script', cursive;
            font-size:30px;
        }
        .list-group {
            border: 1px solid #a5a5a5;
            height: 259px;
            background-color: #FFF;
        }
        #list-admin_lvl_2, #list-locality {
            overflow-y: scroll;
        }
        .list-group-item.active, .list-group-item.active:focus,
        .list-group-item.active:hover {
            text-shadow: 0px -1px 0px #F26721;
            background-image: linear-gradient(to bottom, #F9A266 0px, #F26721 100%);
            background-repeat: repeat-x;
            border-color: #F26721;
            color: #FFFFFF;
        }
        .list-group-item {
            padding: 6px 15px;
            min-height: 33px;
        }
        #list-typology > .list-group-item,
        #list-operation > .list-group-item {
            height: 33px;
        }
    </style>
    @endif

@endsection

@section('content')
    <label><input class="hidden" name="_token" value="{{ Session::token() }}"></label>
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
    <div class="container-fluid"  style="height:400px;
            background-image: url('{{ asset('img/frenchhouse.jpg') }}');
            background-position: 0% 50%;
            background-size: cover;">
        <div class="row">
            <div class="col-xs-12">&nbsp;</div>
        </div>
    </div>
    <div class="container" style="padding:20px 20px 0 20px;margin-top:-278px;
            background-color: rgba(206, 206, 206, 0.7);">
        <div class="row">
            <div class="col-xs-3">
                <ul class="list-group" id="list-operation">
                    <a href="javascript:" data-value="0" class="list-group-item active">Comprar</a>
                    <a href="javascript:" data-value="1" class="list-group-item">Alquilar</a>
                    <a href="javascript:" data-value="2" class="list-group-item">Compartir</a>
                </ul>
            </div>
            <div class="col-xs-3">
                <ul class="list-group" id="list-typology">
                    <a href="javascript:" data-value="0" class="list-group-item hidden">Obra nueva</a>
                    <a href="javascript:" data-value="1" class="list-group-item active">Viviendas</a>
                    <a href="javascript:" data-value="2" class="list-group-item disabled">Vacacional</a>
                    <a href="javascript:" data-value="3" class="list-group-item disabled">Habitación</a>
                    <a href="javascript:" data-value="4" class="list-group-item">Oficinas</a>
                    <a href="javascript:" data-value="5" class="list-group-item">Locales o naves</a>
                    <a href="javascript:" data-value="6" class="list-group-item">Garajes</a>
                    <a href="javascript:" data-value="7" class="list-group-item">Terrenos</a>
                </ul>
            </div>
            <div class="col-xs-3">
                <ul class="list-group" id="list-admin_lvl_2">
                    <?php $i=0; ?>
                    @foreach(\App\HomeLib::getAdminLvl2List(0,1) as $l)
                        <a href="javascript:" data-value="{{ $l->admin_area_lvl2 }}" class="list-group-item @if($i==0) active @endif ">{{ $l->admin_area_lvl2 }}</a>
                        <?php ++$i; ?>
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-3">
                <ul class="list-group" id="list-locality">
                    <?php $i=0; ?>
                    @foreach(\App\HomeLib::getLocalityList(0,1,'Barcelona') as $l)
                        <a href="javascript:" data-value="{{ $l->locality }}" class="list-group-item @if($i==0) active @endif "><span class="badge">{{ $l->total }}</span>{{ $l->locality }}</a>
                        <?php ++$i; ?>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var updateInProgress = false;
        $('.list-group').on('click','a',function(){
            if(updateInProgress)
                return false;
            updateInProgress = true;
            if($(this).hasClass('disabled'))
                return false;
            $(this).parent().find('a.active').removeClass('active');
            $(this).addClass('active');
            if($(this).parent().attr('id') == 'list-operation') {
                var listTypology = $('#list-typology');
                switch ($(this).attr('data-value')) {
                    case '0':
                        listTypology.children().each(function(){
                            if ($(this).attr('data-value') != '2' && $(this).attr('data-value') != '3') {
                                $(this).removeClass('disabled');
                            } else {
                                if($(this).hasClass('active')) {
                                    $(this).removeClass('active');
                                    $(this).siblings('a[data-value=1]').addClass('active');
                                }
                                $(this).addClass('disabled');
                            }
                        });
                        break;
                    case '1':
                        listTypology.children().removeClass('disabled');
                        break;
                    case '2':
                        listTypology.children().each(function(){
                            if ($(this).attr('data-value') != '1') {
                                $(this).removeClass('active').addClass('disabled');
                            } else {
                                $(this).addClass('active');
                            }
                        });
                        break;
                }
            } else if($(this).parent().attr('id') == 'list-locality') {
                return false;
            }
            var operation = 0;
            var typology = 1;
            var adminLvl2 = '';
            var locality = '';
            $('.list-group').find('a.active').each(function(){
                switch ($(this).parent().attr('id')) {
                    case 'list-operation':
                        operation = $(this).attr('data-value');
                        break;
                    case 'list-typology':
                        typology = $(this).attr('data-value');
                        break;
                    case 'list-admin_lvl_2':
                        adminLvl2 = $(this).attr('data-value');
                        break;
                    case 'list-locality':
                        locality = $(this).attr('data-value');
                        break;
                }
            });
            //console.log('Op: '+operation+' Ty: '+typology+' Ad: '+adminLvl2+' Lo: '+locality);
            if($(this).parent().attr('id') == 'list-admin_lvl_2') {
                $('#list-locality').empty();
                $.post('updateLocalities', {
                    _token: $('input[name=_token]').val(),
                    operation: operation,
                    typology: typology,
                    adminLvl2: adminLvl2
                }, function(response) {
                    $.each(response.localities, function(i,val){
                        if(i!=0)
                            $('#list-locality').append("<a href='javascript:' data-value='"+val.locality+"' class='list-group-item'><span class='badge'>"+val.total+"</span>"+val.locality+"</a>");
                        else
                            $('#list-locality').append("<a href='javascript:' data-value='"+val.locality+"' class='list-group-item active'><span class='badge'>"+val.total+"</span>"+val.locality+"</a>");
                    });
                    updateInProgress = false;
                }, 'json');
            } else {
                $('#list-admin_lvl_2').empty();
                $('#list-locality').empty();
                $.post('updateAdminsAndLocalities', {
                    _token: $('input[name=_token]').val(),
                    operation: operation,
                    typology: typology,
                    adminLvl2: adminLvl2
                }, function(response) {
                    $.each(response.admins, function(i,val){
                        if(i!=0)
                            $('#list-admin_lvl_2').append("<a href='javascript:' data-value='"+val.admin_area_lvl2+"' class='list-group-item'>"+val.admin_area_lvl2+"</a>");
                        else
                            $('#list-admin_lvl_2').append("<a href='javascript:' data-value='"+val.admin_area_lvl2+"' class='list-group-item active'>"+val.admin_area_lvl2+"</a>");
                    });
                    $.each(response.localities, function(i,val){
                        if(i!=0)
                            $('#list-locality').append("<a href='javascript:' data-value='"+val.locality+"' class='list-group-item'><span class='badge'>"+val.total+"</span>"+val.locality+"</a>");
                        else
                            $('#list-locality').append("<a href='javascript:' data-value='"+val.locality+"' class='list-group-item active'><span class='badge'>"+val.total+"</span>"+val.locality+"</a>");
                    });
                    updateInProgress = false;
                }, 'json');
            }
        });
    </script>
@endsection
