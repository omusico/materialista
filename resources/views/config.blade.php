@extends('dashboard_layout')

@section('title')
    <title>Panel de control | Configuración</title>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fileinput.min.css') }}">
    <style>
        .portlet > .portlet-title > .caption > i {
            margin-top: 2px;
            font-size: 15px;
        }
        .fa {
            vertical-align: middle;
        }
        .fa-check-circle {
            color: #35AA47;;
        }
        .fa-times-circle {
            color: #ff5d38;
        }
    </style>
@endsection

@section('content')
    <h3 class="page-title">
        Panel de control
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-wrench"></i>
                <a href="{{ route('dashboard.config') }}">Configuración</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @if(\App::environment() == 'local')
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-briefcase"></i>Desarrollador
                    </div>
                    <div class="tools">
                        <a href="javascript:" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form action="{{ route('update.dev.options') }}" class="form-horizontal form-row-seperated">
                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label col-md-3">Seeds (per category)</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Integer" class="form-control" name="n_ad_seeds" @if(isset($options->n_ad_seeds)) value="{!! $options->n_ad_seeds !!}" @endif />
                                    <span class="help-block">Number of ads per category to be generated and filled with random data (local environment only).
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Starting year</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Integer" class="form-control" name="starting_year" @if(isset($options->starting_year)) value="{!! $options->starting_year !!}" @endif />
                                    <span class="help-block">Starting year for copyright generation.
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Developer contact e-mail</label>
                                <div class="col-md-6">
                                    <input type="email" placeholder="String" class="form-control" name="dev_email" @if(isset($options->dev_email)) value="{!! $options->dev_email !!}" @endif />
                                    <span class="help-block">Developer contact e-mail for error messages generation.
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Version</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="String" class="form-control" name="dev_version" @if(isset($options->dev_version)) value="{!! $options->dev_version !!}" @endif />
                                    <span class="help-block">Development version.
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <a href="javascript:" id="save-dev-options" class="btn green">Guardar cambios</a>
                                    <span><img class="check-in-progress-0 hidden" src="{{ asset('img/loading-spinner-grey.gif') }}"/></span>
                                    <i class="post-succeded-0 hidden fa fa-2x fa-check-circle"></i>
                                    <i class="post-failed-0 hidden fa fa-2x fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-picture-o"></i>Imágenes
                    </div>
                    <div class="tools">
                        <a href="javascript:" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="form-update-web-images" action="{{ route('update.web.images') }}" class="form-horizontal form-row-seperated" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ \Session::token() }}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Logotipo principal</label>
                                <div class="col-md-6">
                                    <div class="input-group" style="width:100%;">
                                        <input id="public_logo_input" name="public_logo" class="file form-control" type="file" data-language="es" data-show-preview="true" data-show-upload="false" @if(isset($options->public_logo)&&$options->public_logo) data-initial-caption="{{ $options->public_logo }}" @endif >
                                    </div>
                                    <span class="help-block">Esta imagen aparecerá en la cabecera de su web. Se recomienda: imagen a color sobre fondo blanco o transparente.
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Logotipo para panel de control</label>
                                <div class="col-md-6">
                                    <div class="input-group" style="width:100%;">
                                        <input id="public_logo_input" name="dashboard_logo" class="file form-control" type="file" data-language="es" data-show-preview="true" data-show-upload="false" @if(isset($options->dashboard_logo)&&$options->dashboard_logo) data-initial-caption="{{ $options->dashboard_logo }}" @endif >
                                    </div>
                                    <span class="help-block">Esta imagen aparecerá en la cabecera del Panel de Control. Se recomienda: imagen clara o blanca sobre fondo transparente.
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <a href="javascript:" id="save-web-images" class="btn green">Guardar cambios</a>
                                    <span><img class="check-in-progress-1 hidden" src="{{ asset('img/loading-spinner-grey.gif') }}"/></span>
                                    <i class="post-succeded-1 hidden fa fa-2x fa-check-circle"></i>
                                    <i class="post-failed-1 hidden fa fa-2x fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="portlet box purple">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-building"></i>Datos de empresa
                    </div>
                    <div class="tools">
                        <a href="javascript:" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form action="{{ route('update.web.info') }}" class="form-horizontal form-row-seperated">
                        <div class="form-body">

                            <div class="form-group">
                                <label class="control-label col-md-3">Nombre</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="company_name" @if(isset($options->company_name)) value="{!! $options->company_name !!}" @endif />
                                    <span class="help-block">Introduzca el nombre de su empresa
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Descripción breve</label>
                                <div class="col-md-6">
                                    <input type="text" placeholder="" class="form-control" name="company_description" @if(isset($options->company_description)) value="{!! $options->company_description !!}" @endif />
                                    <span class="help-block">Describa en pocas palabras la actividad de su empresa. Por ej.: Inmobilaria especializada en fincas rústicas
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Dirección de contacto
                                </label>
                                <div class="col-md-6">
                                    <label class="control-label">Localidad</label>
                                    <input type="text" class="form-control" name="municipio" @if(isset($options->locality)) value="{{ $options->locality }}" @endif/>
                                    <label class="control-label">Nombre de la v&iacute;a</label>
                                    <input type="text" class="form-control" name="via" @if(isset($options->route)) value="{{ $options->route }}" @endif/>
                                    <label class="control-label">N&uacute;mero de la v&iacute;a</label>
                                    <input type="text" class="form-control" name="via_num" @if(isset($options->street_number)) value="{{ $options->street_number }}" @endif/>
                                    <input type="hidden" class="form-control" name="address_confirmed" value="0"/>
                                    <input type="hidden" class="form-control" name="lat" @if(isset($options->lat)) value="{{ $options->lat }}" @endif/>
                                    <input type="hidden" class="form-control" name="lng" @if(isset($options->lng)) value="{{ $options->lng }}" @endif/>
                                    <input type="hidden" class="form-control" name="formatted_address" @if(isset($options->formatted_address)) value="{{ $options->formatted_address }}" @endif/>
                                    <input type="hidden" class="form-control" name="street_number" @if(isset($options->street_number)) value="{{ $options->street_number }}" @endif/>
                                    <input type="hidden" class="form-control" name="route" @if(isset($options->route)) value="{{ $options->route }}" @endif/>
                                    <input type="hidden" class="form-control" name="locality" @if(isset($options->locality)) value="{{ $options->locality }}" @endif/>
                                    <input type="hidden" class="form-control" name="admin_area_lvl2" @if(isset($options->admin_area_lvl2)) value="{{ $options->admin_area_lvl2 }}" @endif/>
                                    <input type="hidden" class="form-control" name="admin_area_lvl1" @if(isset($options->admin_area_lvl1)) value="{{ $options->admin_area_lvl1 }}" @endif/>
                                    <input type="hidden" class="form-control" name="postal_code" @if(isset($options->postal_code)) value="{{ $options->postal_code }}" @endif/>
                                    <input type="hidden" class="form-control" name="country" @if(isset($options->country)) value="{{ $options->country }}" @endif/>
                                    <a href="javascript:" id="check-address" class="btn btn-primary" style="margin-top:10px">Comprobar direcci&oacute;n</a>
                                    <span><img id="check-in-progress" class="hidden" src="{{ asset('img/loading-spinner-grey.gif') }}"/></span>
                                    <div id="check-address-success" class="alert alert-success hidden" style="margin-top:10px">
                                        <h4><i class="fa fa-check-circle"></i> Direcci&oacute;n confirmada</h4>
                                        <span class="formated-address"></span>
                                        <br><br>
                                        <a id="change-address" href="javascript:">Cambiar la direcci&oacute;n de contacto</a>
                                    </div>
                                    <div id="check-address-warning" class="alert alert-info hidden" style="margin-top:10px">
                                        <h4>Confirme direcci&oacute;n</h4>
                                        <span class="formated-address"></span>
                                        <br><br>
                                        <a href="javascript:" id="confirm-address" class="btn btn-success"><i class="fa fa-check"></i></a>
                                        <a href="javascript:" id="cancel-address" class="btn btn-danger"><i class="fa fa-close"></i></a>
                                    </div>
                                    <div id="check-address-danger" class="alert alert-danger hidden" style="margin-top:10px">
                                        <h4>Direcci&oacute;n no encontrada</h4>
                                        <span class="formated-address">Compruebe la direcci&oacute;n introducida e int&eacute;ntelo de nuevo</span>
                                    </div>
                                    <span class="help-block">Introduzca la dirección de contacto que desea publicar en su web.
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">E-mail de contacto</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" placeholder="" class="form-control" name="company_email" @if(isset($options->company_email)) value="{!! $options->company_email !!}" @endif />
                                    </div>
                                    <span class="help-block">Introduzca el e-mail de contacto que desea publicar en su web.
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Teléfono de contacto</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" placeholder="" class="form-control" name="company_phone" @if(isset($options->company_phone)) value="{!! $options->company_phone !!}" @endif />
                                    </div>
                                    <span class="help-block">Introduzca el teléfono de contacto que desea publicar en su web.
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <a href="javascript:" id="save-web-info" class="btn green">Guardar cambios</a>
                                    <span><img class="check-in-progress-2 hidden" src="{{ asset('img/loading-spinner-grey.gif') }}"/></span>
                                    <i class="post-succeded-2 hidden fa fa-2x fa-check-circle"></i>
                                    <i class="post-failed-2 hidden fa fa-2x fa-times-circle"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/fileinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/fileinput_locale_es.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#check-address').click(function(){
                if($('input[name=municipio]').val().trim() == '') {
                    alert('Introduzca el nombre del municipio.');
                    return false;
                } else if($('input[name=via]').val().trim() == '') {
                    alert('Introduzca el nombre de la vía.');
                    return false;
                } else if($('input[name=via_num]').val().trim() == '') {
                    alert('Introduzca el número o kilómetro de la vía.');
                    return false;
                }
                var address = $('input[name=via]').val() + ', ' + $('input[name=via_num]').val() + ', ' + $('input[name=municipio]').val();
                $('#check-in-progress').removeClass('hidden');
                $('[id^="check-address-"]').addClass('hidden');
                $.get('/check_address', {
                    address: address
                }, function(data){
                    $('#check-in-progress').addClass('hidden');
                    $('#check-address').addClass('hidden');
                    $('.formated-address').text(data['formatted_address']);
                    $('input[name=municipio]').prop('disabled',true);
                    $('input[name=via]').prop('disabled',true);
                    $('input[name=via_num]').prop('disabled',true);
                    $('input[name=lat]').val(data['lat']);
                    $('input[name=lng]').val(data['lng']);
                    $('input[name=formatted_address]').val(data['formatted_address']);
                    $('input[name=street_number]').val(data['address_components'][0]['long_name']);
                    $('input[name=route]').val(data['address_components'][1]['long_name']);
                    $('input[name=locality]').val(data['address_components'][2]['long_name']);
                    $('input[name=admin_area_lvl2]').val(data['address_components'][3]['long_name']); //Provincia
                    $('input[name=admin_area_lvl1]').val(data['address_components'][4]['long_name']); //Comunidad autónoma
                    $('input[name=country]').val(data['address_components'][5]['long_name']);
                    if(typeof(data['address_components'][6]) != "undefined")
                        $('input[name=postal_code]').val(data['address_components'][6]['long_name']);
                    $('#check-address-warning').removeClass('hidden');
                }).fail(function() {
                    $('#check-in-progress').addClass('hidden');
                    $('#check-address-danger').removeClass('hidden');
                });
            });

            $('#confirm-address').click(function(){
                $('input[name=address_confirmed]').val('1');
                $('#check-address-warning').addClass('hidden');
                $('#check-address-success').removeClass('hidden');
            });

            $('#cancel-address').click(function(){
                $('input[name=municipio]').prop('disabled',false);
                $('input[name=via]').prop('disabled',false);
                $('input[name=via_num]').prop('disabled',false);
                $('#check-address').removeClass('hidden');
                $('#check-address-warning').addClass('hidden');
            });

            $('#change-address').click(function(){
                $('input[name=municipio]').prop('disabled',false);
                $('input[name=via]').prop('disabled',false);
                $('input[name=via_num]').prop('disabled',false);
                $('input[name=address_confirmed]').val('0');
                $('#check-address').removeClass('hidden');
                $('#check-address-success').addClass('hidden');
            });

            var tokenVal = $('input[name=_token]').val();
            $('#save-dev-options').click(function() {
                $('.check-in-progress-0').removeClass('hidden');
                $.post('/update/dev-options', {
                    _token: tokenVal,
                    n_ad_seeds: $('input[name=n_ad_seeds]').val(),
                    starting_year: $('input[name=starting_year]').val(),
                    dev_version: $('input[name=dev_version]').val(),
                    dev_email: $('input[name=dev_email]').val()
                }, function(data) { //handle response
                    $('.check-in-progress-0').addClass('hidden');
                    $('.post-failed-0').addClass('hidden');
                    $('.post-succeded-0').removeClass('hidden');
                }).fail(function() {
                    $('.check-in-progress-0').addClass('hidden');
                    $('.post-succeded-0').addClass('hidden');
                    $('.post-failed-0').removeClass('hidden');
                });
            });

            $('#save-web-images').click(function() {
                $('.check-in-progress-1').removeClass('hidden');
                $.ajax({
                    type: "POST",
                    url: '/update/web-images',
                    data: new FormData($("#form-update-web-images")[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('.check-in-progress-1').addClass('hidden');
                        $('.post-failed-1').addClass('hidden');
                        $('.post-succeded-1').removeClass('hidden');
                    }
                }).fail(function() {
                    $('.check-in-progress-1').addClass('hidden');
                    $('.post-succeded-1').addClass('hidden');
                    $('.post-failed-1').removeClass('hidden');
                });
            });

            $('#save-web-info').click(function() {
                $('.check-in-progress-2').removeClass('hidden');
                $.post('/update/web-info', {
                    _token: tokenVal,
                    company_name: $('input[name=company_name]').val(),
                    company_description: $('input[name=company_description]').val(),
                    company_phone: $('input[name=company_phone]').val(),
                    company_email: $('input[name=company_email]').val(),
                    lat: $('input[name=lat]').val(),
                    lng: $('input[name=lng]').val(),
                    formatted_address: $('input[name=formatted_address]').val(),
                    street_number: $('input[name=street_number]').val(),
                    route: $('input[name=route]').val(),
                    locality: $('input[name=locality]').val(),
                    admin_area_lvl2: $('input[name=admin_area_lvl2]').val(),
                    admin_area_lvl1: $('input[name=admin_area_lvl1]').val(),
                    country: $('input[name=country]').val(),
                    postal_code: $('input[name=postal_code]').val()
                }, function(data) { //handle response
                    $('.check-in-progress-2').addClass('hidden');
                    $('.post-failed-2').addClass('hidden');
                    $('.post-succeded-2').removeClass('hidden');
                }).fail(function() {
                    $('.check-in-progress-2').addClass('hidden');
                    $('.post-succeded-2').addClass('hidden');
                    $('.post-failed-2').removeClass('hidden');
                });
            });

        });
    </script>
@endsection
