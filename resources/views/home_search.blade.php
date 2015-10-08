@extends('layout')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/uniform.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap.min.css') }}">
    <style>
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
        #col-i-look-for-txt {
            height: 35px;
            padding-bottom: 25px;
            line-height: 17px;
            color: #4A4A4A;
            font-size: 18px;
        }
        #col-i-look-for-txt > span {
            font-weight: bold;
            font-size: 20px;
        }
        #col-btn-search {
            height: 35px;
            padding-bottom: 25px;
        }
        #col-btn-search > a.btn {
            margin-top: -13px;
            font-size: 20px;
            font-weight: bold;
            line-height: 26px;
        }
        #col-proximity-search h4 {
            color: #4A4A4A;
            font-weight: bold;
            font-size: 20px;
        }
        .help-block {
            color: #676767;
            margin: 2px 0 0 4px;
            font-style: italic;
        }
        .form-inline > button,
        .form-inline > div > button {
            font-weight: bold;
            font-size: 18px;
            line-height: 14px;
            height: 34px;
        }
        .select2-results .select2-highlighted {
            color: #FFF;
            background-color: #F26721;
        }
        #container-search-by-proximity {
            padding-top: 50px;
            padding-bottom: 100px;
        }
        #container-servicios-tecnicos {
            padding-bottom: 50px;
            background-color: #f8f8f8;
        }
        #container-servicios-agrarios {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .h2-servicios {
            font-weight: bold;
            color: #F26721;
        }
        .ul-servicios {

        }
        .ul-servicios > li {
            color: #4A4A4A;
            font-size: 18px;
            line-height: 25px;
            margin-top: 20px;
        }
        .btn-contact-us {
            font-weight: bold;
            font-size: 18px;
        }
        @media (max-width: 750px) {
            .h2-servicios, .ul-servicios { padding-left: 10px; }
            .btn-contact-us { margin-left:10px; }
        }
    </style>
@endsection

@section('content')
    <input class="hidden" name="_token" value="{{ Session::token() }}">
    <div class="container-fluid"  style="height:400px;
            background-image: url('{{ asset('img/frenchhouse.jpg') }}');
            background-position: 0% 50%;
            background-size: cover;">
        <div class="row">
            <div class="col-xs-12">
            </div>
        </div>
    </div>
    <div class="container" style="padding:20px 20px 0 20px;margin-top:-278px;
            background-color: rgba(206, 206, 206, 0.7);">
        <div class="row">
            <div class="col-xs-6 col-sm-3">
                <ul class="list-group" id="list-operation">
                    <a href="javascript:" data-value="0" data-txt="Comprar" class="list-group-item active">Comprar</a>
                    <a href="javascript:" data-value="1" data-txt="Alquilar" class="list-group-item">Alquilar</a>
                    <a href="javascript:" data-value="2" data-txt="Compartir" class="list-group-item">Compartir</a>
                </ul>
            </div>
            <div class="col-xs-6 col-sm-3">
                <ul class="list-group" id="list-typology">
                    <a href="javascript:" data-value="0" data-txt="Obra nueva" class="list-group-item">Obra nueva</a>
                    <a href="javascript:" data-value="1" data-txt="Vivienda" class="list-group-item active">Viviendas</a>
                    <a href="javascript:" data-value="2" data-txt="Vacacional" class="list-group-item disabled">Vacacional</a>
                    <a href="javascript:" data-value="3" data-txt="Habitación" class="list-group-item disabled">Habitación</a>
                    <a href="javascript:" data-value="4" data-txt="Oficinas" class="list-group-item">Oficinas</a>
                    <a href="javascript:" data-value="5" data-txt="Local o nave" class="list-group-item">Locales o naves</a>
                    <a href="javascript:" data-value="6" data-txt="Garaje" class="list-group-item">Garajes</a>
                    <a href="javascript:" data-value="7" data-txt="Terreno" class="list-group-item">Terrenos</a>
                </ul>
            </div>
            <div class="col-xs-6 col-sm-3">
                <ul class="list-group" id="list-admin_lvl_2">
                    <?php $i=0; ?>
                    @foreach(\App\HomeLib::getAdminLvl2List(0,1) as $l)
                        <a href="javascript:" data-value="{{ $l->admin_area_lvl2 }}" class="list-group-item @if($i==0) active @endif ">{{ $l->admin_area_lvl2 }}</a>
                        <?php ++$i; ?>
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-6 col-sm-3">
                <ul class="list-group" id="list-locality">
                    <?php $i=0; ?>
                    @foreach(\App\HomeLib::getLocalityList(0,1,'Barcelona') as $l)
                        <?php if($i==0) { $firstLocality = $l->locality; } ?>
                        <a href="javascript:" data-value="{{ $l->locality }}" class="list-group-item @if($i==0) active @endif "><span class="badge">{{ $l->total }}</span>{{ $l->locality }}</a>
                        <?php ++$i; ?>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="hidden-xs col-sm-9" id="col-i-look-for-txt">
                Busco <span class="txt-operation">Comprar</span> <span class="txt-typology">Vivienda</span> en <span class="txt-locality">@if(isset($firstLocality)) {{ $firstLocality }} @endif</span>
            </div>
            <div class="col-xs-12 col-sm-3 text-right" id="col-btn-search">
                <a class="btn btn-primary btn-block" id="btn-search-by-locality" href="javascript:">Buscar</a>
            </div>
        </div>
    </div>
    <div class="container" id="container-search-by-proximity">
        <div class="row">
            <div class="col-xs-offset-0 col-xs-12 col-lg-offset-2 col-lg-8" id="col-proximity-search">
                <h4 style="padding-left:5px;">Buscar por cercanía:</h4>
                <div class="radio-list col-xs-12" style="padding: 0 0 10px 0;" id="radio-operation">
                    <label class="checkbox" style="display: inline;"><input type="radio" name="operation" value="0" data-title="Comprar" checked="checked"> Comprar</label>
                    <label class="checkbox" style="display: inline;"><input type="radio" name="operation" value="1" data-title="Alquilar"> Alquilar</label>
                </div>
                <div class="form-inline">
                    <div class="form-group col-xs-12 col-sm-3" style="padding:0 5px;vertical-align: top;">
                        <select name="typology" class="form-control" style="width:100%;" id="select-typology">
                            <option value="0">Obra nueva</option>
                            <option value="1">Viviendas</option>
                            <option value="2">Vacacional</option>
                            <option value="3">Habitación</option>
                            <option value="4">Oficinas</option>
                            <option value="5">Locales o naves</option>
                            <option value="6">Garajes</option>
                            <option value="7">Terrenos</option>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6" style="padding:0 5px;vertical-align: top;">
                        <input type="text" placeholder="Escriba la dirección donde centrar la búsqueda" class="form-control" name="customAddress" style="width:100%;">
                        <span class="help-block">Ej.: Calle Mayor 1, Martorell, Barcelona</span>
                    </div>
                    <div class="col-xs-12 col-sm-3" style="padding:0 5px;">
                        <button class="btn inline btn-default" id="btn-search-by-proximity" style="width: 100%;vertical-align: top;">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="container-servicios-tecnicos">
        <div class="row hidden-xs" style="height:50px;">&nbsp;</div>
        <div class="row">
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-4" style="height: 275px;
                background-image: url('{{ asset('img/appraisal.jpg') }}');
                background-position: 50% 50%;
                background-size: cover;">
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="row hidden-sm hidden-md hidden-lg" style="height:20px;">
                </div>
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-11">
                        <h2 class="h2-servicios">Servicios técnicos</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-5">
                        <ul class="ul-servicios fa-ul">
                            <li><i class="fa-li fa fa-check-square"></i>Certificados técnicos</li>
                            <li><i class="fa-li fa fa-check-square"></i>Tasaciones</li>
                            <li class="hidden-sm hidden-md hidden-lg"><i class="fa-li fa fa-check-square"></i>Asesoramiento técnico</li>
                            <li class="hidden-sm hidden-md hidden-lg"><i class="fa-li fa fa-check-square"></i>Proyectos de reformas</li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <ul class="ul-servicios fa-ul">
                            <li class="hidden-xs"><i class="fa-li fa fa-check-square"></i>Asesoramiento técnico</li>
                            <li class="hidden-xs"><i class="fa-li fa fa-check-square"></i>Proyectos de reformas</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-11" style="margin-top:35px;">
                        <a href="mailto:{!! $options->company_email !!}" class="hidden-xs btn btn-primary btn-contact-us">Contacte con nuestro equipo experto</a>
                        <a href="mailto:{!! $options->company_email !!}" class="hidden-sm hidden-md hidden-lg btn btn-primary btn-contact-us">Contáctenos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="container-servicios-agrarios">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-push-7" style="height: 275px;
                    background-image: url('{{ asset('img/fields.jpg') }}');
                    background-position: 50% 50%;
                    background-size: cover;">
            </div>
            <div class="col-xs-offset-0 col-xs-12 col-sm-offset-1 col-sm-6 col-sm-pull-4">
                <div class="row hidden-sm hidden-md hidden-lg" style="height:20px;">
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="h2-servicios">Servicios agrarios</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <ul class="ul-servicios fa-ul">
                            <li><i class="fa-li fa fa-check-square"></i>Levantamientos topográficos</li>
                            <li><i class="fa-li fa fa-check-square"></i>Nivelaciones</li>
                            <li><i class="fa-li fa fa-check-square"></i>Trabajos agrícolas</li>
                            <li class="hidden-sm hidden-md hidden-lg"><i class="fa-li fa fa-check-square"></i>Gestión de purines</li>
                            <li class="hidden-sm hidden-md hidden-lg"><i class="fa-li fa fa-check-square"></i>Asesoramiento de fincas</li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <ul class="ul-servicios fa-ul">
                            <li class="hidden-xs"><i class="fa-li fa fa-check-square"></i>Gestión de purines</li>
                            <li class="hidden-xs"><i class="fa-li fa fa-check-square"></i>Asesoramiento de fincas</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="margin-top:35px;">
                        <a href="mailto:{!! $options->company_email !!}" class="hidden-xs btn btn-primary btn-contact-us">Contacte con nuestro equipo experto</a>
                        <a href="mailto:{!! $options->company_email !!}" class="hidden-sm hidden-md hidden-lg btn btn-primary btn-contact-us">Contáctenos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/metronic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2_locale_es.js') }}"></script>
    <script>
        $(document).ready(function() {
            Metronic.init(); // init metronic core components >> uniform checkboxes

            $('#btn-search-by-locality').click(function(){
                searchByLocality();
            });
            var searchByLocality = function() {
                //default values
                var operation = 0;
                var typology = 1;
                var locality = 'Barcelona';
                $('.list-group').find('a.active').each(function () {
                    switch ($(this).parent().attr('id')) {
                        case 'list-operation':
                            operation = $(this).attr('data-value');
                            break;
                        case 'list-typology':
                            typology = $(this).attr('data-value');
                            break;
                        case 'list-locality':
                            locality = $(this).attr('data-value');
                            break;
                    }
                });
                window.location.href = '/resultados?' + $.param({
                    operation: operation,
                    typology: typology,
                    locality: locality,
                    search_type: '0'
                });
            };

            $('#btn-search-by-proximity').click(function(){
                searchByProximity();
            });
            var proximityContainer = $('#container-search-by-proximity');
            var searchByProximity = function() {
                window.location.href = '/resultados?' + $.param({
                    operation: proximityContainer.find('input[name=operation]:checked').val(),
                    typology: proximityContainer.find('select[name=typology]').val(),
                    address: proximityContainer.find('input[name=customAddress]').val(),
                    search_type: '1'
                });
            };

            $('#radio-operation').on('change','input:radio',function(){
                var selectTypology = $('#select-typology');
                if($(this).val() == '0') {
                    if(selectTypology.val() == '2' || selectTypology.val() == '3')
                        selectTypology.select2("val", "1");
                    selectTypology.find('option').each(function () {
                        if ($(this).val() == '2' || $(this).val() == '3') {
                            $(this).addClass('hidden');
                        }
                    });
                } else {
                    selectTypology.find('option').each(function(){ $(this).removeClass('hidden'); });
                }
            });

            $('#select-typology').select2({
                minimumResultsForSearch: -1,
                width: 'style',
                placeholder: "Seleccione",
                allowClear: true,
                escapeMarkup: function (m) {
                    return m;
                }
            }).select2("val", "1");

            var updateInProgress = false;
            $('.list-group').on('click', 'a', function () {
                if (updateInProgress || $(this).hasClass('disabled'))
                    return false;
                $(this).parent().find('a.active').removeClass('active');
                $(this).addClass('active');
                var listId = $(this).parent().attr('id');
                if (listId == 'list-locality') {
                    updateSearchMsg();
                    return false;
                } else if (listId == 'list-operation') {
                    var listTypology = $('#list-typology');
                    switch ($(this).attr('data-value')) {
                        case '0':
                            listTypology.children().each(function () {
                                if ($(this).attr('data-value') != '2' && $(this).attr('data-value') != '3') {
                                    $(this).removeClass('disabled');
                                } else {
                                    if ($(this).hasClass('active')) {
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
                            listTypology.children().each(function () {
                                if ($(this).attr('data-value') != '1') {
                                    $(this).removeClass('active').addClass('disabled');
                                } else {
                                    $(this).addClass('active');
                                }
                            });
                            break;
                    }
                }
                updateInProgress = true; //important to keep this AFTER the last else if !!!
                var operation = 0;
                var typology = 1;
                var adminLvl2 = '';
                $('.list-group').find('a.active').each(function () {
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
                    }
                });
                if (listId == 'list-admin_lvl_2') {
                    $('#list-locality').empty();
                    $.post('updateLocalities', {
                        _token: $('input[name=_token]').val(),
                        operation: operation,
                        typology: typology,
                        adminLvl2: adminLvl2
                    }, function (response) {
                        $.each(response.localities, function (i, val) {
                            if (i != 0)
                                $('#list-locality').append("<a href='javascript:' data-value='" + val.locality + "' class='list-group-item'><span class='badge'>" + val.total + "</span>" + val.locality + "</a>");
                            else
                                $('#list-locality').append("<a href='javascript:' data-value='" + val.locality + "' class='list-group-item active'><span class='badge'>" + val.total + "</span>" + val.locality + "</a>");
                        });
                    }, 'json').always(function () {
                        updateInProgress = false;
                        updateSearchMsg();
                    });
                } else {
                    $('#list-admin_lvl_2').empty();
                    $('#list-locality').empty();
                    $.post('updateAdminsAndLocalities', {
                        _token: $('input[name=_token]').val(),
                        operation: operation,
                        typology: typology
                    }, function (response) {
                        $.each(response.admins, function (i, val) {
                            if (i != 0)
                                $('#list-admin_lvl_2').append("<a href='javascript:' data-value='" + val.admin_area_lvl2 + "' class='list-group-item'>" + val.admin_area_lvl2 + "</a>");
                            else
                                $('#list-admin_lvl_2').append("<a href='javascript:' data-value='" + val.admin_area_lvl2 + "' class='list-group-item active'>" + val.admin_area_lvl2 + "</a>");
                        });
                        $.each(response.localities, function (i, val) {
                            if (i != 0)
                                $('#list-locality').append("<a href='javascript:' data-value='" + val.locality + "' class='list-group-item'><span class='badge'>" + val.total + "</span>" + val.locality + "</a>");
                            else
                                $('#list-locality').append("<a href='javascript:' data-value='" + val.locality + "' class='list-group-item active'><span class='badge'>" + val.total + "</span>" + val.locality + "</a>");
                        });
                    }, 'json').always(function () {
                        updateInProgress = false;
                        updateSearchMsg();
                    });
                }
            });
            function updateSearchMsg() {
                $('span.txt-operation').text($('#list-operation').find('a.active').attr('data-txt'));
                $('span.txt-typology').text($('#list-typology').find('a.active').attr('data-txt'));
                $('span.txt-locality').text($('#list-locality').find('a.active').clone().children().remove().end().text());
            }
        });
    </script>
@endsection
