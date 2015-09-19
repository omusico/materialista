@extends('dashboard_layout')

@section('title')
    <title>Panel de control | Nuevo anuncio</title>
@endsection

@section('css')
    {{--STEPS 1 and 2--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/uniform.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-formhelpers.css') }}">
    {{--STEP 3, photo input, progress bar...--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fileupload.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.fileupload-ui.css') }}">
    {{--Bootstrap/uniform/components tweaks and fixes--}}
    <style>
        .form-wizard > .form-body {
            padding:0;
        }
        .portlet {
            margin-bottom: 0;
        }
        .form .form-actions {
            padding: 20px 15px;
        }
        #uploading-bar {
            margin: 0;
            height: 4px;
        }
        #vacation-prices-table > thead > tr > th {
            text-align: center;
            font-size: 12px;
            font-weight: normal;
        }
        #vacation-prices-table > tbody > tr > td {
            text-align: center;
            font-size: 11px;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="portlet" id="form_wizard_1">
                    {{-- FORM --}}
                    <div class="portlet-body form">
                        <form action="{{ route('new.ad') }}" class="form-horizontal" id="submit_form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ \Session::token() }}">
                            <div class="form-wizard">
                                <div class="form-body">

                                    {{-- STEPS NAVBAR AND PROGRESS BAR --}}
                                    <div style="margin-right: -15px;margin-left: -15px;">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li>
                                                <a href="#tab1" data-toggle="tab" class="step">
                                                    <span class="number">
                                                    1 </span>
                                                    <span class="desc">
                                                    <i class="fa fa-check"></i> Datos b&aacute;sicos </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab2" data-toggle="tab" class="step">
                                                    <span class="number">
                                                    2 </span>
                                                    <span class="desc">
                                                    <i class="fa fa-check"></i> Detalles </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#tab3" data-toggle="tab" class="step active">
                                                    <span class="number">
                                                    3 </span>
                                                    <span class="desc">
                                                    <i class="fa fa-check"></i> Fotos </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success">
                                            </div>
                                        </div>
                                    </div>

                                    {{--COMMON TABS CONTENT--}}
                                    <div class="tab-content">
                                        <div class="alert alert-danger common-danger display-none">
                                            <button class="close" data-dismiss="alert"></button>
                                            Se han detectado errores en el formulario. Por favor, compruebe los campos.
                                        </div>
                                        <div class="alert alert-success common-success display-none">
                                            <button class="close" data-dismiss="alert"></button>
                                            ¡Formulario validado satisfactoriamente!
                                        </div>

                                        {{--STEP 1--}}
                                        <div class="tab-pane active" id="tab1">

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de inmueble <span class="required">
													* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="typology" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="0" @if($typology=='0') selected="selected" @endif >Piso</option>
                                                        <option value="1" @if($typology=='1') selected="selected" @endif >Casa o chalet</option>
                                                        <option value="2" @if($typology=='2') selected="selected" @endif >Casa r&uacute;stica o regional</option>
                                                        <option value="3" @if($typology=='3') selected="selected" @endif >Oficina</option>
                                                        <option value="4" @if($typology=='4') selected="selected" @endif >Local o nave</option>
                                                        <option value="5" @if($typology=='5') selected="selected" @endif >Plaza de garaje</option>
                                                        <option value="6" @if($typology=='6') selected="selected" @endif >Terreno</option>
                                                        <option value="7" @if($typology=='7') selected="selected" @endif >Alquiler vacacional</option>
                                                        <option value="8" @if($typology=='8') selected="selected" @endif >Habitaci&oacute;n en vivienda compartida</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Operaci&oacute;n <span class="required">* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="operation" value="0" data-title="Venta" @if($operation=='0'&&($typology!='7'&&$typology!='8')) checked="checked" @endif @if($typology=='7'||$typology=='8') disabled="disabled" @endif />
                                                            Venta </label>
                                                        <label>
                                                            <input type="radio" name="operation" value="1" data-title="Alquiler" @if($operation=='1'||($typology=='7'||$typology=='8')) checked="checked" @endif />
                                                            Alquiler </label>
                                                    </div>
                                                    <div id="form_operation_error"></div>
                                                </div>
                                            </div>

                                            @if($typology!='7')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Precio <span class="required">* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="price"/>
                                                        @if($operation=='0')
                                                            <span class="input-group-addon">&euro;</span>
                                                        @elseif($operation=='1')
                                                            <span class="input-group-addon">&euro;/mes</span>
                                                        @endif
                                                    </div>
                                                    <div id="form_price_error"></div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($operation=='1'&&$typology=='4')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">&iquest;Es un traspaso?
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_transfer" value="1" data-title="Es un traspaso"/> Es un traspaso</label>
                                                    </div>
                                                    <div id="form_is_transfer_error">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($operation=='0'&&($typology!='6'&&$typology!='7'&&$typology!='8'))
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Gastos de comunidad
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="community_cost"/>
                                                        <span class="input-group-addon">&euro;/mes</span>
                                                    </div>
                                                    <div id="form_community_cost">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($operation=='1'&&$typology!='7')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Fianza
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="deposit" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="Sin fianza">Sin fianza</option>
                                                        <option value="1 mes">1 mes</option>
                                                        <option value="2 meses">2 meses</option>
                                                        <option value="3 meses">3 meses</option>
                                                        <option value="4 meses">4 meses</option>
                                                        <option value="5 meses">5 meses</option>
                                                        <option value="6 meses o m&aacute;s">6 meses o m&aacute;s</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Detalles de la promoción
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_bank_agency" value="1" data-title="Es de un banco o caja"/> Es de un banco o caja</label>
                                                        <label>
                                                            <input type="checkbox" name="is_state_subsidized" value="1" data-title="Es vivienda de protección oficial"/> Es vivienda de protección oficial</label>
                                                        <label>
                                                            <input type="checkbox" name="is_new_development" value="1" data-title="Es nueva promoción"/> Es nueva promoción</label>
                                                        <label>
                                                            <input type="checkbox" name="is_new_development_finished" value="1" data-title="Es nueva promoción terminada"/> Es nueva promoción terminada</label>
                                                        <label>
                                                            <input type="checkbox" name="is_rent_to_own" value="1" data-title="Es alquiler con opción a compra"/> Es alquiler con opción a compra</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Localizaci&oacute;n del inmueble <span class="required">
													* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <label class="control-label">Localidad</label>
                                                    <input type="text" class="form-control" name="municipio" value=""/>
                                                    <label class="control-label">Nombre de la v&iacute;a</label>
                                                    <input type="text" class="form-control" name="via" value=""/>
                                                    <label class="control-label">N&uacute;mero de la v&iacute;a @if($typology=='6') o Km @endif</label>
                                                    <input type="text" class="form-control" name="via_num" value=""/>
                                                    <input type="hidden" class="form-control" name="address_confirmed" value="0"/>
                                                    <input type="hidden" class="form-control" name="lat" value=""/>
                                                    <input type="hidden" class="form-control" name="lng" value=""/>
                                                    <input type="hidden" class="form-control" name="formatted_address" value=""/>
                                                    <input type="hidden" class="form-control" name="street_number" value=""/>
                                                    <input type="hidden" class="form-control" name="route" value=""/>
                                                    <input type="hidden" class="form-control" name="locality" value=""/>
                                                    <input type="hidden" class="form-control" name="admin_area_lvl2" value=""/>
                                                    <input type="hidden" class="form-control" name="admin_area_lvl1" value=""/>
                                                    <input type="hidden" class="form-control" name="postal_code" value=""/>
                                                    <input type="hidden" class="form-control" name="country" value=""/>
                                                    <a href="javascript:" id="check-address" class="btn btn-primary" style="margin-top:10px">Comprobar direcci&oacute;n</a>
                                                    <span><img id="check-in-progress" class="hidden" src="{{ asset('img/loading-spinner-grey.gif') }}"/></span>
                                                    <div id="check-address-success" class="alert alert-success hidden" style="margin-top:10px">
                                                        <h4><i class="fa fa-check-circle"></i> Direcci&oacute;n confirmada</h4>
                                                        <span class="formated-address"></span>
                                                        <br><br>
                                                        <a id="change-address" href="javascript:">Cambiar la direcci&oacute;n del inmueble</a>
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
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Esconder direcci&oacute;n del inmueble
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="hide_address" value="1" data-title="Ocultar direcci&oacute;n"/> Ocultar direcci&oacute;n</label>
                                                    </div>
                                                    <div id="form_hide_address_error">
                                                    </div>
                                                </div>
                                            </div>

                                            @if($typology=='0'||$typology=='3'||$typology=='4'||$typology=='7'||$typology=='8')
                                            <div class="form-group" id="planta">
                                                <label class="control-label col-md-3">Planta
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="floor_number" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="Por debajo de la planta baja (-2)">Por debajo de la planta baja (-2)</option>
                                                        <option value="Por debajo de la planta baja (-1)">Por debajo de la planta baja (-1)</option>
                                                        <option value="S&oacute;tano">S&oacute;tano</option>
                                                        <option value="Semi-s&oacute;tano">Semi-s&oacute;tano</option>
                                                        <option value="Bajo">Bajo</option>
                                                        <option value="Entreplanta">Entreplanta</option>
                                                    @for($i = 1; $i < 101; ++$i)
                                                        <option value="Planta {{ $i }}&ordm;">Planta {{ $i }}&ordm;</option>
                                                    @endfor
                                                    </select>
                                                    @if($typology!='3'&&$typology!='4')
                                                    <div class="checkbox-list" style="padding-top:4px;">
                                                        <label>
                                                            <input type="checkbox" name="is_last_floor" value="1" data-title="Es la &uacute;ltima planta del bloque"/>Es la &uacute;ltima planta del bloque</label>
                                                    </div>
                                                    @endif
                                                    <div id="form_floor_number_error">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="puerta">
                                                <label class="control-label col-md-3">Puerta
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="door" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="0">Letra (A, B, C...)</option>
                                                        <option value="1">N&uacute;mero (1, 2, 3...)</option>
                                                        <option value="Puerta &uacute;nica">Puerta &uacute;nica</option>
                                                        <option value="Izquierda">Izquierda</option>
                                                        <option value="Derecha">Derecha</option>
                                                        <option value="Exterior">Exterior</option>
                                                        <option value="Exterior izquierda">Exterior izquierda</option>
                                                        <option value="Exterior derecha">Exterior derecha</option>
                                                        <option value="Interior">Interior</option>
                                                        <option value="Interior izquierda">Interior izquierda</option>
                                                        <option value="Interior derecha">Interior derecha</option>
                                                        <option value="Centro">Centro</option>
                                                        <option value="Centro izquierda">Centro izquierda</option>
                                                        <option value="Centro derecha">Centro derecha</option>
                                                    </select>
                                                    <select name="door_number" class="form-control hidden" style="padding-top:5px;">
                                                        <option value="">Seleccione</option>
                                                    @for($i = 1; $i < 101; ++$i)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                    </select>
                                                    <select name="door_letter" class="form-control hidden" style="padding-top:5px;">
                                                        <option value="">Seleccione</option>
                                                    @foreach(range('A','Z') as $letter)
                                                        <option value="{{ $letter }}">{{ $letter }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">&iquest;Hay m&aacute;s de un bloque/portal?
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_block" value="0" data-title="No" checked="checked" />
                                                            No </label>
                                                        <label>
                                                            <input type="radio" name="has_block" value="1" data-title="S&iacute;, bloque/portal:"/>
                                                            S&iacute;, bloque/portal: </label>
                                                            <input type="text" class="form-control" name="block" disabled=""/>
                                                    </div>
                                                    <div id="form_bloque_error">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Urbanizaci&oacute;n @if($typology=='6') o zona industrial @endif
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="residential_area">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        {{--END STEP 1--}}

                                        {{--STEP 2--}}
                                        <div class="tab-pane" id="tab2">

                                            @if($typology=='0')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de apartamento
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_regular" value="1" data-title="Piso"/> Piso</label>
                                                        <label>
                                                            <input type="checkbox" name="is_penthouse" value="1" data-title="&Aacute;tico"/> &Aacute;tico</label>
                                                        <label>
                                                            <input type="checkbox" name="is_duplex" value="1" data-title="D&uacute;plex"/> D&uacute;plex</label>
                                                        <label>
                                                            <input type="checkbox" name="is_studio" value="1" data-title="Estudio/loft"/> Estudio/loft</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='1')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de casa/chalet <span class="required">* </span>
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="category_house_id" value="1" data-title="Casa o chalet independiente"/>
                                                            Casa o chalet independiente </label>
                                                        <label>
                                                            <input type="radio" name="category_house_id" value="2" data-title="Chalet pareado"/>
                                                            Chalet pareado </label>
                                                        <label>
                                                            <input type="radio" name="category_house_id" value="3" data-title="Chalet adosado"/>
                                                            Chalet adosado </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='2')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de casa r&uacute;stica
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="category_country_house_id" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Finca r&uacute;stica</option>
                                                        <option value="2">Castillo</option>
                                                        <option value="3">Palacio</option>
                                                        <option value="4">Mas&iacute;a</option>
                                                        <option value="5">Cortijo</option>
                                                        <option value="6">Casa rural</option>
                                                        <option value="7">Casa de pueblo</option>
                                                        <option value="8">Casa terrera</option>
                                                        <option value="9">Torre</option>
                                                        <option value="10">Caser&oacute;n</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='4')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de inmueble
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="category_business_id" value="1" data-title="Local comercial"/>
                                                            Local comercial </label>
                                                        <label>
                                                            <input type="radio" name="category_business_id" value="2" data-title="Nave industrial"/>
                                                            Nave industrial </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='5')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Capacidad
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="1" data-title="Coche pequeño"/>
                                                            Coche pequeño </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="2" data-title="Coche grande"/>
                                                            Coche grande </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="3" data-title="Moto"/>
                                                            Moto </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="4" data-title="Coche y moto"/>
                                                            Coche y moto </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="5" data-title="Dos coches o más"/>
                                                            Dos coches o más </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='6')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de terreno
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="category_land_id" value="1" data-title="Urbano"/>
                                                            Urbano </label>
                                                        <label>
                                                            <input type="radio" name="category_land_id" value="2" data-title="Urbanizable"/>
                                                            Urbanizable </label>
                                                        <label>
                                                            <input type="radio" name="category_land_id" value="3" data-title="No urbanizable"/>
                                                            No urbanizable </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de vivienda <span class="required">* </span>
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="category_room_id" value="1" data-title=""/>
                                                            Piso compartido </label>
                                                        <label>
                                                            <input type="radio" name="category_room_id" value="2" data-title=""/>
                                                            Chalet compartido </label>
                                                    </div>
                                                    <div id="form_category_room_id_error">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; de la vivienda <span class="required">* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_room" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Total de personas (capacidad incluyendo nuevo inquilino)
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_people" />
                                                    </div>
                                                    <div id="form_n_people_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2'||$typology=='3'||$typology=='4')
                                            <div class="form-group" id="estado">
                                                <label class="control-label col-md-3">Estado
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="needs_restoration" value="1" data-title="Necesita reformas"/> Necesita reformas</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; construidos <span class="required"> *
                                                </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_constructed" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; &uacute;tiles
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_usable" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='1'||$typology=='2')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; parcela
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_land" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='6')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; totales
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_total" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; edificables
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_building_land" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='3'||$typology=='6')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; de superficie m&iacute;nima que se vende o alquila
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_min_for_sale" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='4')
                                            <div class="form-group" id="estancias">
                                                <label class="control-label col-md-3">Estancias
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="1" data-title="Di&aacute;fana"/>
                                                            Di&aacute;fana </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="2" data-title="1-2 estancias"/>
                                                            1-2 estancias </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="3" data-title="3-5 estancias"/>
                                                            3-5 estancias </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="4" data-title="5-10 estancias"/>
                                                            5-10 estancias </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="5" data-title="M&aacute; de 10 estancias"/>
                                                            M&aacute;s de 10 estancias </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="m2_fachada">
                                                <label class="control-label col-md-3">M&sup2; de fachada
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="1" data-title="Sin fachada"/>
                                                            Sin fachada </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="2" data-title="1 a 4 metros"/>
                                                            1 a 4 metros </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="3" data-title="5 a 8 metros"/>
                                                            5 a 8 metros </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="4" data-title="9 a 12 metros"/>
                                                            9 a 12 metros </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="5" data-title="M&aacute; de 12 metros"/>
                                                            M&aacute; de 12 metros </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">N&uacute;mero de escaparates
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_shop_windows" value="" />
                                                    </div>
                                                    <div id="form_n_shop_windows">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group" id="int_ext">
                                                <label class="control-label col-md-3">Ubicaci&oacute;n
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="1" data-title="En centro comercial"/>
                                                            En centro comercial </label>
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="2" data-title="A pie de calle"/>
                                                            A pie de calle </label>
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="3" data-title="Entreplanta"/>
                                                            Entreplanta </label>
                                                         <label>
                                                            <input type="radio" name="business_location_id" value="4" data-title="Subterr&aacute;neo"/>
                                                             Subterr&aacute;neo </label>
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="5" data-title="Otros"/>
                                                            Otros </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Última actividad comercial
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="last_activity" value="" />
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='1'||$typology=='2'||$typology=='3'||$typology=='4')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Plantas
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_floors" value="" />
                                                    </div>
                                                    <div id="form_n_floors_error"></div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2'||$typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">N&uacute;mero de habitaciones
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_bedrooms" />
                                                    </div>
                                                    <div id="form_n_bedrooms_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2'||$typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">N&uacute;mero de ba&ntilde;os y aseos
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_bathrooms" />
                                                    </div>
                                                    <div id="form_n_bathrooms_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='3'||$typology=='4')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">N&uacute;mero de aseos
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_restrooms" />
                                                    </div>
                                                    <div id="form_n_restrooms_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='3')
                                            <div class="form-group" id="int_ext">
                                                <label class="control-label col-md-3">Características de los aseos
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_bathrooms" value="1" data-title="Disponen de baño"/> Disponen de baño</label>
                                                        <label>
                                                            <input type="checkbox" name="has_bathrooms_inside" value="1" data-title="Están dentro de las oficinas"/> Están dentro de las oficinas</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='3')
                                            <div class="form-group" id="int_ext">
                                                <label class="control-label col-md-3">Exterior/interior
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="is_exterior" value="1" data-title="Exterior"/>
                                                            Exterior </label>
                                                        <label>
                                                            <input type="radio" name="is_exterior" value="0" data-title="Interior"/>
                                                            Interior </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='3')
                                            <div class="form-group" id="int_ext">
                                                <label class="control-label col-md-3">Distribuci&oacute;n
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="office_distribution_id" value="1" data-title="Di&aacute;fana"/>
                                                            Di&aacute;fana </label>
                                                        <label>
                                                            <input type="radio" name="office_distribution_id" value="2" data-title="Dividida con mamparas"/>
                                                            Dividida con mamparas </label>
                                                        <label>
                                                            <input type="radio" name="office_distribution_id" value="3" data-title="Dividida con tabiques"/>
                                                            Dividida con tabiques </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="int_ext">
                                                <label class="control-label col-md-3">Uso exclusivo oficinas
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_offices_only" value="1" data-title="S&iacute;"/>
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="has_offices_only" value="0" data-title="No"/>
                                                            No </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Los inquilinos actuales son
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="current_tenants_gender_id" value="1" data-title="Chico(s) y chica(s)"/>
                                                            Chico(s) y chica(s) </label>
                                                        <label>
                                                            <input type="radio" name="current_tenants_gender_id" value="2" data-title="S&oacute;lo chico(s)"/>
                                                            S&oacute;lo chico(s) </label>
                                                        <label>
                                                            <input type="radio" name="current_tenants_gender_id" value="3" data-title="S&oacute;lo chica(s)"/>
                                                            S&oacute;lo chica(s) </label>
                                                    </div>
                                                    <div id="form_currrent_tenants_gender_id_error"></div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='7'||$typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">&iquest;Se permite fumar?
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="is_smoking_allowed" value="1" data-title="S&iacute;"/>
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="is_smoking_allowed" value="0" data-title="No"/>
                                                            No </label>
                                                    </div>
                                                    <div id="form_is_smoking_allowed_error">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">&iquest;Se admiten mascotas?
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="is_pet_allowed" value="1" data-title="S&iacute;"/>
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="is_pet_allowed" value="0" data-title="No"/>
                                                            No </label>
                                                    </div>
                                                    <div id="form_is_pet_allowed_error"></div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Edad del inquilino m&aacute;s joven
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="min_current_tenants_age"/>
                                                        <span class="input-group-addon">a&ntilde;os</span>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Edad del inquilino m&aacute;s mayor
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_current_tenants_age"/>
                                                        <span class="input-group-addon">a&ntilde;os</span>
                                                        <span class="help-block"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($operation=='1'&&($typology=='0'||$typology=='1'||$typology=='2'))
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Equipamiento
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_equipped_kitchen" value="1" data-title="Cocina completamente equipada"/> Cocina completamente equipada</label>
                                                        <label>
                                                            <input type="checkbox" name="has_furniture" value="1" data-title="Vivienda amueblada"/> Vivienda amueblada</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='7'||$typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Ascensor
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_elevator" value="1" data-title="S&iacute;"/>
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="has_elevator" value="0" data-title="No"/>
                                                            No </label>
                                                    </div>
                                                    <div id="form_has_elevator_error"></div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='3')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">N&uacute;mero de ascensores
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_elevators" />
                                                    </div>
                                                    <div id="form_n_elevators_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2'||$typology=='3'||$typology=='4')
                                            <div class="form-group" id="puerta">
                                                <label class="control-label col-md-3">Certificaci&oacute;n energ&eacute;tica
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="energy_certification_id" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">A&uacute;n no dispone</option>
                                                        <option value="2">A</option>
                                                        <option value="3">B</option>
                                                        <option value="4">C</option>
                                                        <option value="5">D</option>
                                                        <option value="6">E</option>
                                                        <option value="7">F</option>
                                                        <option value="8">G</option>
                                                        <option value="9">Inmueble exento</option>
                                                        <option value="10">En tr&aacute;mite</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Prestación energética
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="energy_performance" />
                                                        <span class="input-group-addon">kWh/m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Orientación
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="faces_north" value="1" data-title="Norte"/> Norte</label>
                                                        <label>
                                                            <input type="checkbox" name="faces_south" value="1" data-title="Sur"/> Sur</label>
                                                        <label>
                                                            <input type="checkbox" name="faces_east" value="1" data-title="Este"/> Este</label>
                                                        <label>
                                                            <input type="checkbox" name="faces_west" value="1" data-title="Oeste"/> Oeste</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Otras caracter&iacute;sticas de la vivienda
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_builtin_closets" value="1" data-title="Armarios empotrados"/> Armarios empotrados</label>
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado"/> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_terrace" value="1" data-title="Terraza"/> Terraza</label>
                                                        <label>
                                                            <input type="checkbox" name="has_box_room" value="1" data-title="Trastero"/> Trastero</label>
                                                        <label>
                                                            <input type="checkbox" name="has_parking_space" value="1" data-title="Plaza de garaje @if($operation=='0') incluida en el precio @endif "/> Plaza de garaje
                                                            @if($operation=='0') incluida en el precio @endif
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="has_fireplace" value="1" data-title="Chimenea"/> Chimenea</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Otras caracter&iacute;sticas del edificio
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_swimming_pool" value="1" data-title="Piscina"/> Piscina</label>
                                                        <label>
                                                            <input type="checkbox" name="has_garden" value="1" data-title="Zona verde"/> Zona verde</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='3')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Plazas de aparcamiento incluidas en el precio
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_parking_spaces" />
                                                    </div>
                                                    <div id="form_n_parking_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Seguridad de la oficina
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_steel_door" value="1" data-title="Puerta de seguridad"/> Puerta de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_system" value="1" data-title="Sistema de alarma/circuito cerrado de seguridad"/> Sistema de alarma/circuito cerrado de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_access_control" value="1" data-title="Control de accesos"/> Control de accesos</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fire_detectors" value="1" data-title="Detectores de icendios"/> Detectores de icendios</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fire_extinguishers" value="1" data-title="Extintores"/> Extintores</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fire_sprinklers" value="1" data-title="Aspersores"/> Aspersores</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fireproof_doors" value="1" data-title="Puerta cortafuegos"/> Puerta cortafuegos</label>
                                                        <label>
                                                            <input type="checkbox" name="has_emergency_lights" value="1" data-title="Luces de salida de emergencia"/> Luces de salida de emergencia</label>
                                                        <label>
                                                            <input type="checkbox" name="has_doorman" value="1" data-title="Conserje/portero/seguridad"/> Conserje/portero/seguridad</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Climatización y agua caliente
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado"/> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning_preinstallation" value="1" data-title="Preinstalación de aire acondicionado"/> Preinstalación de aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_heating" value="1" data-title="Calefacción"/> Calefacción</label>
                                                        <label>
                                                            <input type="checkbox" name="has_hot_water" value="1" data-title="Agua caliente"/> Agua caliente</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas de la oficina
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_kitchen" value="1" data-title="Cocina/office"/> Cocina/office</label>
                                                        <label>
                                                            <input type="checkbox" name="has_archive" value="1" data-title="Almac&eacute;n"/> Almac&eacute;n</label>
                                                        <label>
                                                            <input type="checkbox" name="has_double_windows" value="1" data-title="Doble acristalamiento"/> Doble acristalamiento</label>
                                                        <label>
                                                            <input type="checkbox" name="has_suspended_ceiling" value="1" data-title="Falso techo"/> Falso techo</label>
                                                        <label>
                                                            <input type="checkbox" name="has_suspended_floor" value="1" data-title="Suelo t&eacute;cnico"/> Suelo t&eacute;cnico</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas del edificio
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_handicapped_adapted" value="1" data-title="Adaptado a personas con movilidad reducida"/> Adaptado a personas con movilidad reducida</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='4')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas del local
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_archive" value="1" data-title="Almac&eacute;n"/> Almac&eacute;n</label>
                                                        <label>
                                                            <input type="checkbox" name="has_smoke_extractor" value="1" data-title="Salida de humos"/> Salida de humos</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fully_equipped_kitchen" value="1" data-title="Cocina completamente equipada"/> Cocina completamente equipada</label>
                                                        <label>
                                                            <input type="checkbox" name="has_steel_door" value="1" data-title="Puerta de seguridad"/> Puerta de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_alarm" value="1" data-title="Sistema de alarma"/> Sistema de alarma</label>
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado"/> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_heating" value="1" data-title="Calefacci&oacute;n"/> Calefacci&oacute;n</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_camera" value="1" data-title="Circuito cerrado de seguridad"/> Circuito cerrado de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="is_corner_located" value="1" data-title="Hace esquina"/> Hace esquina</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='5')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas del garaje
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_covered" value="1" data-title="Cubierto"/> Cubierto</label>
                                                        <label>
                                                            <input type="checkbox" name="has_automatic_door" value="1" data-title="Puerta automática"/> Puerta automática</label>
                                                        <label>
                                                            <input type="checkbox" name="has_lift" value="1" data-title="Ascensor"/> Ascensor</label>
                                                        <label>
                                                            <input type="checkbox" name="has_alarm" value="1" data-title="Sistema de alarma"/> Sistema de alarma</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_camera" value="1" data-title="Circuito cerrado de seguridad"/> Circuito cerrado de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_guard" value="1" data-title="Vigilante/seguridad"/> Vigilante/seguridad</label>
                                                   </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='6')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Calificación del terreno
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_classified_residential_block" value="1" data-title="Residencial en altura (bloques)"/> Residencial en altura (bloques)</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_residential_house" value="1" data-title="Residencial unifamiliar (chalets)"/> Residencial unifamiliar (chalets)</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_office" value="1" data-title="Terciario oficinas"/> Terciario oficinas</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_commercial" value="1" data-title="Terciario comercial"/> Terciario comercial</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_hotel" value="1" data-title="Terciario hoteles"/> Terciario hoteles</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_industrial" value="1" data-title="Industrial"/> Industrial</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_public_service" value="1" data-title="Dotaciones (hospitales, escuelas, museos)"/> Dotaciones (hospitales, escuelas, museos)</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_others" value="1" data-title="Otras"/> Otras</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Número máximo de plantas edificables
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_floors_allowed" />
                                                    </div>
                                                    <div id="form_max_floors_allowed_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Acceso rodado
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_road_access" value="1" data-title="S&iacute;, tiene"/>
                                                            S&iacute;,tiene</label>
                                                        <label>
                                                            <input type="radio" name="has_road_access" value="0" data-title="No disponible"/>
                                                            No disponible</label>
                                                    </div>
                                                    <div id="form_has_road_access_error">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Distancia al municipio más cercano
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="nearest_town_distance_id" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">No lo sé</option>
                                                        <option value="2">En núcleo urbano</option>
                                                        <option value="3">Menos de 500 m</option>
                                                        <option value="4">Entre 500 m y 1 km</option>
                                                        <option value="5">De 1 a 2 km</option>
                                                        <option value="6">De 2 a 5 km</option>
                                                        <option value="7">De 5 a 10 km</option>
                                                        <option value="8">Más de 10 km</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Otras características del terreno
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_water" value="1" data-title="Agua"/> Agua</label>
                                                        <label>
                                                            <input type="checkbox" name="has_electricity" value="1" data-title="Luz"/> Luz</label>
                                                        <label>
                                                            <input type="checkbox" name="has_sewer_system" value="1" data-title="Alcantarillado"/> Alcantarillado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_natural_gas" value="1" data-title="Gas natural"/> Gas natural</label>
                                                        <label>
                                                            <input type="checkbox" name="has_street_lighting" value="1" data-title="Alumbrado público"/> Alumbrado público</label>
                                                        <label>
                                                            <input type="checkbox" name="has_sidewalks" value="1" data-title="Aceras"/> Aceras</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='8')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas de la habitaci&oacute;n
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_furniture" value="1" data-title="Amueblada"/> Amueblada</label>
                                                        <label>
                                                            <input type="checkbox" name="has_builtin_closets" value="1" data-title="Armario empotrado"/> Armario empotrado</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas del inmueble
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado"/> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_internet" value="1" data-title="Conexi&oacute;n a internet"/> Conexi&oacute;n a internet</label>
                                                        <label>
                                                            <input type="checkbox" name="has_house_keeper" value="1" data-title="Asistente/a del hogar"/> Asistente/a del hogar</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Nuevo inquilino
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>Chico/chica</label>
                                                        <label>
                                                            <input type="radio" name="tenant_gender_id" value="1" data-title="Da igual"/>
                                                            Da igual </label>
                                                        <label>
                                                            <input type="radio" name="tenant_gender_id" value="2" data-title="Chico"/>
                                                            Chico </label>
                                                        <label>
                                                            <input type="radio" name="tenant_gender_id" value="3" data-title="Chica"/>
                                                            Chica </label>
                                                    </div>
                                                    <div class="radio-list">
                                                        <label style="padding-top:5px;">Ocupaci&oacute;n</label>
                                                        <label>
                                                            <input type="radio" name="tenant_occupation_id" value="1" data-title="Da igual"/>
                                                            Da igual </label>
                                                        <label>
                                                            <input type="radio" name="tenant_occupation_id" value="2" data-title="Estudiante"/>
                                                            Estudiante </label>
                                                        <label>
                                                            <input type="radio" name="tenant_occupation_id" value="3" data-title="Con trabajo"/>
                                                            Con trabajo </label>
                                                    </div>
                                                    <div class="radio-list">
                                                        <label style="padding-top:5px;">Orientaci&oacute;n</label>
                                                        <label>
                                                            <input type="radio" name="tenant_sexual_orientation_id" value="1" data-title="Da igual"/>
                                                            Da igual </label>
                                                        <label>
                                                            <input type="radio" name="tenant_sexual_orientation_id" value="2" data-title="Gay friendly"/>
                                                            Gay friendly </label>
                                                    </div>
                                                    <div class="radio-list">
                                                        <label style="padding-top:5px;">Estancia m&iacute;nima</label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="1" data-title="1 mes"/>
                                                            1 mes </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="2" data-title="2 meses"/>
                                                            2 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="3" data-title="3 meses"/>
                                                            3 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="4" data-title="4 meses"/>
                                                            4 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="5" data-title="5 meses"/>
                                                            5 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="6" data-title="6 o más meses"/>
                                                            6 o más meses </label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='7')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Entorno
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="1" data-title="Entorno de playa"/>
                                                            Entorno de playa </label>
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="2" data-title="Entorno de esquí"/>
                                                            Entorno de esquí </label>
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="3" data-title="Entorno rural"/>
                                                            Entorno rural </label>
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="4" data-title="Entorno de ciudad"/>
                                                            Entorno de ciudad </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de alojamiento
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="category_lodging_id" value="1" data-title="Apartamento"/>
                                                            Apartamento </label>
                                                        <label>
                                                            <input type="radio" name="category_lodging_id" value="2" data-title="Casa"/>
                                                            Casa </label>
                                                        <label>
                                                            <input type="radio" name="category_lodging_id" value="3" data-title="Villa"/>
                                                            Villa </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">¿Son varios alojamientos?
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_multiple_lodgings" value="0" data-title="No, es un alojamiento"/>
                                                            No, es un alojamiento </label>
                                                        <label>
                                                            <input type="radio" name="has_multiple_lodgings" value="1" data-title="Sí, son varios"/>
                                                            Sí, son varios </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; totales
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_total"/>
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                    <div id="form_area_total_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; de jardín
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_garden"/>
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                    <div id="form_area_garden_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; de terraza
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_terrace"/>
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                    <div id="form_area_terrace_error">
                                                    </div>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de cocina
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="is_american_kitchen" value="0" data-title="Cocina independiente"/>
                                                            Cocina independiente </label>
                                                        <label>
                                                            <input type="radio" name="is_american_kitchen" value="1" data-title="Cocina americana"/>
                                                            Cocina americana </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Precio
                                                </label>
                                                <div class="col-md-9">
                                                    <table id="vacation-prices-table" class="table table-responsive table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="3"></th>
                                                                <th colspan="6">Precios según temporada</th>
                                                                <th colspan="2"></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Temporada</th>
                                                                <th width="160">De</th>
                                                                <th width="160">A</th>
                                                                <th>Noche</th>
                                                                <th>Fin de semana</th>
                                                                <th>Semana <small>(7 noches)</small></th>
                                                                <th>Quincena <small>(14 noches)</small></th>
                                                                <th>Mes <small>(29 noches)</small></th>
                                                                <th>Extra por invitado y noche</th>
                                                                <th>Mínimo de noches</th>
                                                                <th>Eliminar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-seasons">
                                                            <tr data-season="0">
                                                                <td><input name="n_season-0" class="hidden" value="0">Resto del a&ntilde;o</td>
                                                                <td><input name="from_date-0" class="hidden" value="1/1/1900">-</td>
                                                                <td><input name="to_date-0" class="hidden" value="1/1/2999">-</td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_one_night-0"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_weekend_night-0"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_one_week-0"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_half_month-0"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_one_month-0"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_extra_guest_per_night-0"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="n_min_nights-0"/>
                                                                    </div>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-season="1">
                                                                <td><input name="n_season-1" class="hidden" value="1"></td>
                                                                <td>
                                                                    <div class="bfh-datepicker" data-name="from_date-1"></div>
                                                                </td>
                                                                <td>
                                                                    <div class="bfh-datepicker" data-name="to_date-1"></div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_one_night-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_weekend_night-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_one_week-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_half_month-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_one_month-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="p_extra_guest_per_night-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="n_min_nights-1"/>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:" class="btn btn-danger btn-delete-season"><i class="fa fa-times"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <a href="javascript:" id="btn-add-season" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> A&ntilde;adir temporada</a>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Reserva
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_booking" value="0" data-title="No requerida"/>
                                                            No requerida </label>
                                                        <label>
                                                            <input type="radio" name="has_booking" value="1" data-title="En porcentaje:"/>
                                                            En porcentaje:
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="booking-percentage" disabled="disabled"/>
                                                                <span class="input-group-addon">%</span>
                                                            </div></label>
                                                        <label>
                                                            <input type="radio" name="has_booking" value="2" data-title="En euros:"/>
                                                            En euros: </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="booking-euros" disabled="disabled"/>
                                                            <span class="input-group-addon">&euro;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Resto del pago
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="payment_day_id" class="form-control">
                                                        <option value="1">A la entrega de llaves</option>
                                                        <option value="2">Días antes de la entrada</option>
                                                        <option value="3">El día de entrada</option>
                                                        <option value="4">El día de salida</option>
                                                    </select>
                                                    <label class="control-label">Número de días antes: </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_days_before" disabled="disabled" value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Fianza
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_deposit" value="0" data-title="No requerida"/>
                                                            No requerida </label>
                                                        <label>
                                                            <input type="radio" name="has_deposit" value="1" data-title="En porcentaje:"/>
                                                            En porcentaje:
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="deposit-percentage" disabled="disabled"/>
                                                                <span class="input-group-addon">%</span>
                                                            </div></label>
                                                        <label>
                                                            <input type="radio" name="has_deposit" value="2" data-title="En euros:"/>
                                                            En euros: </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="deposit-euros" disabled="disabled"/>
                                                            <span class="input-group-addon">&euro;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Limpieza
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_cleaning" value="0" data-title="Incluida en el precio"/>
                                                            Incluida en el precio </label>
                                                        <label>
                                                            <input type="radio" name="has_cleaning" value="1" data-title="No incluida. En euros:"/>
                                                            No incluida. En euros: </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="cleaning" disabled="disabled"/>
                                                            <span class="input-group-addon">&euro;</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Sábanas y toallas
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_included_towels" value="1" data-title="Incluidas en el precio"/>
                                                            Incluidas en el precio </label>
                                                        <label>
                                                            <input type="radio" name="has_included_towels" value="0" data-title="No incluidas"/>
                                                            No incluidas </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Gastos (gas, luz, etc.)
                                                </label>
                                                <div class="col-md-4" style="padding-top:8px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_included_expenses" value="1" data-title="Incluidos en el precio"/>
                                                            Incluidos en el precio </label>
                                                        <label>
                                                            <input type="radio" name="has_included_expenses" value="0" data-title="No incluidas"/>
                                                            No incluidas </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Distancias
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>A la playa</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_beach"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al centro</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_town_center"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A estanción de esquí</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_ski_area"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Al supermercado</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_supermarket"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al aeropuerto</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_airport"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al campo de golf</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_golf_course"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div><div class="row">
                                                        <div class="col-md-4">
                                                            <label>Al río o lago</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_river_or_lake"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al puerto deportivo</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_marina"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al centro ecuestre</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_horse_riding_area"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>A la estación de tren</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_train_station"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A la estación de autobuses</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_bus_station"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A escuela de submarinismo</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_scuba_diving_area"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Al hospital</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_hospital"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A rutas de senderismo</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_hiking_area"/>
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Habitaciones
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Con cama de matrimonio</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_double_bedroom"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Con dos camas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_two_beds_room"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Con una cama</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_single_bed_room"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Con tres camas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_three_beds_room"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Con cuatro camas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_four_beds_room"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Camas extra
                                                </label>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Sofá cama (tama&ntilde;o individual)</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_sofa_bed"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Sofá cama (tama&ntilde;o matrimonio)</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_double_sofa_bed"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Cama auxiliar (tama&ntilde;o individual)</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_extra_bed"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Capacidad mínima (personas)
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="min_capacity" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Capacidad máxima (personas)
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_capacity" />
                                                    </div>
                                                </div>
                                            </div>

                                            {{--TODO: prices table--}}

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Formas de pago aceptadas
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="accepts_cash" value="1" data-title="En efectivo"/> En efectivo</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_transfer" value="1" data-title="Transferencia bancaria"/> Transferencia bancaria</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_credit_card" value="1" data-title="Tarjeta de crédito"/> Tarjeta de crédito</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_paypal" value="1" data-title="Paypal"/> Paypal</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_check" value="1" data-title="Cheque"/> Cheque</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_western_union" value="1" data-title="Western Union"/> Western Union</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_money_gram" value="1" data-title="Money Gram"/> Money Gram</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Características del exterior
                                                </label>
                                                <div class="col-md-9" style="padding-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_private_garden" value="1" data-title="Jardín individual"/> Jardín individual</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_shared_garden" value="1" data-title="Jardín compartido"/> Jardín compartido</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_furnished_garden" value="1" data-title="Muebles de jardín"/> Muebles de jardín</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_barbecue" value="1" data-title="Barbacoa"/> Barbacoa</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_parking_space" value="1" data-title="Aparcamiento"/> Aparcamiento</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_playground" value="1" data-title="Parque infantil"/> Parque infantil</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_terrace" value="1" data-title="Terraza"/> Terraza</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_sea_sights" value="1" data-title="Vistas al mar"/> Vistas al mar</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_mountain_sights" value="1" data-title="Vistas a la monta&ntilde;a"/> Vistas a la monta&ntilde;a</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_private_swimming_pool" value="1" data-title="Piscina individual"/> Piscina individual</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_shared_swimming_pool" value="1" data-title="Piscina compartida"/> Piscina compartida</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_indoor_swimming_pool" value="1" data-title="Piscina cubierta"/> Piscina cubierta</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Características del interior
                                                </label>
                                                <div class="col-md-9" style="padding-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_tv" value="1" data-title="TV"/> TV</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_cable_tv" value="1" data-title="TV por cable/satélite"/> TV por cable/satélite</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_internet" value="1" data-title="Internet/wifi"/> Internet/wifi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_jacuzzi" value="1" data-title="Jacuzzi"/> Jacuzzi</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_fireplace" value="1" data-title="Chimenea"/> Chimenea</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_cradle" value="1" data-title="Cuna"/> Cuna</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_fan" value="1" data-title="Ventilador"/> Ventilador</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_heating" value="1" data-title="Calefacción"/> Calefacción</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado"/> Aire acondicionado</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_hairdryer" value="1" data-title="Secador de pelo"/> Secador de pelo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Electrodomésticos
                                                </label>
                                                <div class="col-md-9" style="padding-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_dishwasher" value="1" data-title="Lavavajillas"/> Lavavajillas</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_dryer" value="1" data-title="Secadora"/> Secadora</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_fridge" value="1" data-title="Nevera"/> Nevera</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_washer" value="1" data-title="Lavadora"/> Lavadora</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_oven" value="1" data-title="Horno"/> Horno</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_iron" value="1" data-title="Plancha"/> Plancha</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_microwave" value="1" data-title="Microondas"/> Microondas</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_coffee_maker" value="1" data-title="Cafetera"/> Cafetera</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Características de la ubicación
                                                </label>
                                                <div class="col-md-9" style="padding-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_out_town_center" value="1" data-title="Fuera del casco urbano"/> Fuera del casco urbano</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_gayfriendly_area" value="1" data-title="Ambiente gay-friendly"/> Ambiente gay-friendly</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_isolated" value="1" data-title="Aislado"/> Aislado</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_family_tourism_area" value="1" data-title="Turismo familiar"/> Turismo familiar</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_bar_area" value="1" data-title="Zona de bares"/> Zona de bares</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_luxury_area" value="1" data-title="Alojamiento de lujo"/> Alojamiento de lujo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_nudist_area" value="1" data-title="Turismo nudista"/> Turismo nudista</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_charming" value="1" data-title="Alojamiento con encanto"/> Alojamiento con encanto</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Servicios cercanos
                                                </label>
                                                <div class="col-md-9" style="padding-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_bicycle_rental" value="1" data-title="Alquiler de bicicleta"/> Alquiler de bicicleta</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_car_rental" value="1" data-title="Alquiler de coche"/> Alquiler de coche</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_adventure_activities" value="1" data-title="Actividades multi-aventura"/> Actividades multi-aventura</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_tennis_court" value="1" data-title="Pistas de tenis"/> Pistas de tenis</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_kindergarten" value="1" data-title="Guardería"/> Guardería</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_paddle_court" value="1" data-title="Pistas de pádel"/> Pistas de pádel</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_sauna" value="1" data-title="Sauna"/> Sauna</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_gym" value="1" data-title="Gimnasio"/> Gimnasio</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Información adicional
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_handicapped_adapted" value="1" data-title="Adaptado para discapacitados"/> Adaptado para discapacitados</label>
                                                        <label>
                                                            <input type="checkbox" name="is_car_recommended" value="1" data-title="Recomendable disponer de coche"/> Recomendable disponer de coche</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Descripción y otros detalles</label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" rows="4" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{--END STEP 2--}}
                                        <div id="uploaded_images" class="hidden"></div>

                                        {{--STEP 3--}}
                                        <div class="tab-pane" id="tab3">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="hidden" name="_token" value="{{ \Session::token() }}">
                                                    <span class="btn btn-primary btn-block fileinput-button">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Seleccione imágenes...</span>
                                                        <input id="fileupload" type="file" name="files[]" multiple>
                                                    </span>
                                                    <div id="uploading-bar" class="progress">
                                                        <div class="progress-bar progress-bar-success"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <table class="table table-striped table-hover table-bordered" id="slides-table">
                                                        <thead>
                                                        <tr>
                                                            <th width="102">Vista previa</th>
                                                            <th>Nombre de la imagen</th>
                                                            <th>Dimensiones<br><small style="font-weight: normal;">Recomendado: >1024 x 768</small></th>
                                                            <th>Tama&ntilde;o<br><small style="font-weight: normal;">Recomendado: >400 kb</small></th>
                                                            <th>Fecha de creación</th>
                                                            <th width="105">Acción</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbody_images">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                        {{--END STEP 3--}}
                                    </div>
                                </div>

                                <div style="margin-right: -15px;margin-left: -15px;">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-8">
                                                <a href="javascript:" class="btn default button-previous">
                                                    <i class="m-icon-swapleft"></i> Atr&aacute;s </a>
                                                <a href="javascript:" class="btn blue button-next">
                                                    Siguiente <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
                                                <button type="submit" class="btn green button-submit">
                                                    Enviar <i class="m-icon-swapright m-icon-white"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{--STEPS 1 and 2, form--}}
    <script type="text/javascript" src="{{ asset('js/metronic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/messages_es.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.bootstrap.wizard.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2_locale_es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-formhelpers.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-formhelpers-datepicker.es_ES.js') }}"></script>
    {{--STEP 3--}}
    <script src="{{ asset('js/jquery.ui.widget.js') }}"></script>
    <script src="{{ asset('js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script>
        $(function() {
            $('#fileupload').fileupload({
                dataType: 'json',
                url: '/upload_img',
                done: function(e, data) {
                    $.each(data.result.files, function(index, file) {
                        $('#tbody_images').append($('' +
                            '<tr>' +
                            '<td><img width="100" src="/ads/thumbnails/' + file.thumbnail + '"></td>' +
                            '<td> ' + file.name +       ' </td>'    +
                            '<td> ' + file.width +      ' x '       + file.height + ' </td>' +
                            '<td> ' + file.size +   ' kB</td>'  +
                            '<td> ' + file.created_at + '</td>'     +
                            '<td><span class="btn btn-sm red btn-delete-image"><i class="fa fa-times"></i> Eliminar</span></td>' +
                            '</tr>' +
                        '').hide().fadeIn(300));
                        $('#uploaded_images').append('' +
                            '<input type="hidden" name="pictures_' + file.name + '" value="' + file.name + '"/>' +
                        '');
                    });
                }, progressall: function(e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#uploading-bar .progress-bar').css('width', progress + '%');
                }, fail: function(ev, data) {
                    alert('Error al tratar de subir la imagen al servidor. Asegúrese de que el formato imagen es adecuado (jpg, png...).');
                }
            });
        });
    </script>

    {{--CUSTOM JS--}}
    <script>
        $(document).ready(function() {
            Metronic.init(); // init metronic core components >> uniform checkboxes

            $('#tbody_images').on('click','.btn-delete-image',function(){
                var tr = $(this).closest('tr');
                var filename = tr.children().eq(1).text().trim();
                tr.fadeOut(300,function(){$(this).remove()});
                $('#uploaded_images').find("input[name='pictures_"+filename+"']").remove();
            });

            function calculate_capacity() {
                var min_capacity = (parseInt($('input[name=n_double_bedroom]').val())||0)*2 +
                        (parseInt($('input[name=n_two_beds_room]').val())||0)*2 +
                        (parseInt($('input[name=n_single_bed_room]').val())||0)*1 +
                        (parseInt($('input[name=n_three_beds_room]').val())||0)*3 +
                        (parseInt($('input[name=n_four_beds_room]').val())||0)*4;
                var extra_capacity = (parseInt($('input[name=n_sofa_bed]').val())||0)*1 +
                        (parseInt($('input[name=n_double_sofa_bed]').val())||0)*2 +
                        (parseInt($('input[name=n_extra_bed]').val())||0)*1;
                $('input[name=min_capacity]').val(min_capacity);
                $('input[name=max_capacity]').val(min_capacity + extra_capacity);
            }

            var tab2 = $('#tab2');
            var tbodySeason = $('#tbody-seasons');
            tbodySeason.on('click','.btn-delete-season',function(){
                $(this).closest('tr').remove();
            });
            $('#btn-add-season').click(function(){
                var lastSeason = tbodySeason.children().last();
                var num = parseInt(lastSeason.attr('data-season')) + 1;
                var newSeason = '<tr data-season="' + num + '">'+
                        '<td><input name="n_season-' + num + '" class="hidden" value="' + num + '">' + '</td>'+
                        '<td>' + '<div class="bfh-datepicker" data-name="from_date-' + num + '"></div>' + '</td>' +
                        '<td>' + '<div class="bfh-datepicker" data-name="to_date-' + num + '"></div>' + '</td>' +
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="p_one_night-' + num + '"/>' + '</div>' + '</td>'+
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="p_weekend_night-' + num + '"/>' + '</div>' + '</td>'+
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="p_one_week-' + num + '"/>' + '</div>' + '</td>' +
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="p_half_month-' + num + '"/>' + '</div>' + '</td>' +
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="p_one_month-' + num + '"/>' + '</div>' + '</td>' +
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="p_extra_guest_per_night-' + num + '"/>' + '</div>' + '</td>'+
                        '<td>' + '<div class="input-group">' + '<input type="text" class="form-control" name="n_min_nights-' + num + '"/>' + '</div>' + '</td>' +
                        '<td>' + '<a href="javascript:" class="btn btn-danger btn-delete-season"><i class="fa fa-times"></i></a>'+ '</td>' +
                        '</tr>';
                tbodySeason.append(newSeason);
                //initialize datepickers
                tbodySeason.children().last().find('div.bfh-datepicker').bfhdatepicker('toggle');
                //get sure new datepickers have the correct input names
                tbodySeason.children().last().find("div[data-name^='from_date']").find('input').attr('name','from_date-'+num);
                tbodySeason.children().last().find("div[data-name^='to_date']").find('input').attr('name','to_date-'+num);
            });

            tab2.on('change','input[name=n_double_bedroom]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_two_beds_room]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_single_bed_room]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_three_beds_room]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_four_beds_room]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_sofa_bed]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_double_sofa_bed]',function(){calculate_capacity();});
            tab2.on('change','input[name=n_extra_bed]',function(){calculate_capacity();});
            tab2.on('change', 'input[type=radio][name=has_booking]', function() {
                if ($(this).val() == '1') {
                    $('input[name=booking-percentage]').removeAttr('disabled');
                    $('input[name=booking-euros]').attr("disabled","disabled").val('');
                } else if ($(this).val() == '2') {
                    $('input[name=booking-euros]').removeAttr('disabled');
                    $('input[name=booking-percentage]').attr("disabled","disabled").val('');
                } else {
                    $('input[name=booking-percentage]').attr("disabled","disabled").val('');
                    $('input[name=booking-euros]').attr("disabled","disabled").val('');
                }
            });
            tab2.on('change', 'input[type=radio][name=has_deposit]', function() {
                if ($(this).val() == '1') {
                    $('input[name=deposit-percentage]').removeAttr('disabled');
                    $('input[name=deposit-euros]').attr("disabled","disabled").val('');
                } else if ($(this).val() == '2') {
                    $('input[name=deposit-euros]').removeAttr('disabled');
                    $('input[name=deposit-percentage]').attr("disabled","disabled").val('');
                } else {
                    $('input[name=deposit-percentage]').attr("disabled","disabled").val('');
                    $('input[name=deposit-euros]').attr("disabled","disabled").val('');
                }
            });
            tab2.on('change', 'input[type=radio][name=has_cleaning]', function() {
                if ($(this).val() == '1') {
                    $('input[name=cleaning]').removeAttr('disabled');
                } else {
                    $('input[name=cleaning]').attr("disabled","disabled").val('');
                }
            });
            $('select[name=payment_day_id]').select2().on("change", function(e) {
                if(e.val=='2') {
                    $('input[name=n_days_before]').removeAttr('disabled');
                } else {
                    $('input[name=n_days_before]').attr("disabled","disabled").val('');
                }
            });
            //on document load do the same
            if($("select[name=payment_day_id]").select2("val")=='2') {
                $('input[name=n_days_before]').removeAttr('disabled');
            } else {
                $('input[name=n_days_before]').attr("disabled","disabled").val('');
            }
            
            var tab1 = $('#tab1');
            tab1.on('change','input[name=operation]',function(){
                var operation = $(this).val();
                var typology = $(this).closest('#tab1').find('select[name=typology]').val();
                reloadCustomForm(operation,typology);
            });
            tab1.on('change','select[name=typology]',function(){
                var typology = $(this).val();
                var operation = $(this).closest('#tab1').find('input[name=operation]:checked').val();
                reloadCustomForm(operation,typology);
            });
            function reloadCustomForm(op,typ) {
                if(!op || !typ)
                    return false;
                window.location.href = window.location.href.replace(/[\?#].*|$/, "?operation="+op+"&typology="+typ);
            }

            $('select[name=door]').select2().on("change", function(e) {
                if(e.val=='1') {
                    if(!$('select[name=door_letter]').hasClass('hidden'))
                        $('select[name=door_letter]').addClass('hidden');
                    $('select[name=door_number]').removeClass('hidden');
                } else if (e.val=='0') {
                    if(!$('select[name=door_number]').hasClass('hidden'))
                        $('select[name=door_number]').addClass('hidden');
                    $('select[name=door_letter]').removeClass('hidden');
                } else {
                    if(!$('select[name=door_number]').hasClass('hidden'))
                        $('select[name=door_number]').addClass('hidden');
                    if(!$('select[name=door_letter]').hasClass('hidden'))
                        $('select[name=door_letter]').addClass('hidden');
                }
            });
            //on document load do the same
            if($("select[name=door]").select2("val")=='0') {
                if(!$('select[name=door_number]').hasClass('hidden'))
                    $('select[name=door_number]').addClass('hidden');
                $('select[name=door_letter]').removeClass('hidden');
            } else if ($("select[name=door]").select2("val")=='1') {
                if(!$('select[name=door_letter]').hasClass('hidden'))
                    $('select[name=door_letter]').addClass('hidden');
                $('select[name=door_number]').removeClass('hidden');
            }

            $('input[type=radio][name=has_block]').change(function() {
                if ($(this).val() == '0') {
                    $('input[name=block]').attr("disabled","disabled").val('');
                } else if ($(this).val() == '1') {
                    $('input[name=block]').removeAttr('disabled');
                }
            });

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

            function format(state) {
                return state.text;
//                if (!state.id) return state.text; // optgroup
//                return "<img class='flag' src='img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }

            $("select").select2({
                placeholder: "Seleccione",
                allowClear: true,
                escapeMarkup: function(m) {
                    return m;
                }
            });

            var formWizard = $('#form_wizard_1');
            var form = $('#submit_form');
            var error = $('.common-danger', form);
            var success = $('.common-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
//                    // datos básicos
//                    tipo: { required: true },
//                    operacion: { required: true },
//                    precio: { digits: true, required: true },
//                    comunidad: { digits: true },
//                    fianza: { digits: true },
//                    // detalles
//                    fullname: {
//                        required: true
//                    },
//                    email: {
//                        required: true,
//                        email: true
//                        // equalTo: "#submit_form_password"
//                    },
//                    phone: {
//                        required: true
//                    },
//                    gender: {
//                        required: true
//                    },
//                    address: {
//                        required: true
//                    },
//                    city: {
//                        required: true
//                    },
//                    country: {
//                        required: true
//                    },
//                    //payment
//                    card_name: {
//                        required: true
//                    },
//                    card_number: {
//                        minlength: 16,
//                        maxlength: 16,
//                        required: true
//                    },
//                    card_cvc: {
//                        digits: true,
//                        required: true,
//                        minlength: 3,
//                        maxlength: 4
//                    },
//                    card_expiry_date: {
//                        required: true
//                    },
//                    'payment[]': {
//                        required: true,
//                        minlength: 1
//                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
//                    'payment[]': {
//                        required: "Elija una opción",
//                        minlength: jQuery.validator.format("Elija una opción")
//                    }
                },

                errorPlacement: function(error, element) { // render error placement for each input type
                    if (element.attr("name") == "operacion") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_operacion_error");
                    } else if (element.attr("name") == "precio") {
                        error.insertAfter("#form_precio_error");
                    } else if (element.attr("name") == "comunidad") {
                        error.insertAfter("#form_comunidad_error");
                    } else if (element.attr("name") == "payment[]") { // for uniform checkboxes, insert the after the given container
                        error.insertAfter("#form_payment_error");
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function(event, validator) { //display error alert on form submit
                    success.hide();
                    error.show();
                    Metronic.scrollTo(error, -200);
                },

                highlight: function(element) { // highlight error inputs
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function(element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function(label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label.closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label.addClass('valid') // mark the current input as valid and display OK icon
                            .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function(form) {
                    success.show();
                    error.hide();
                    form.submit();
                }
            });

            var displayConfirm = function() {
                $('#tab3 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            };

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', formWizard).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', formWizard).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    formWizard.find('.button-previous').hide();
                } else {
                    formWizard.find('.button-previous').show();
                }

                if (current >= total) {
                    formWizard.find('.button-next').hide();
                    formWizard.find('.button-submit').show();
                    displayConfirm();
                } else {
                    formWizard.find('.button-next').show();
                    formWizard.find('.button-submit').hide();
                }
                Metronic.scrollTo($('.page-title'));
            };

            // default form wizard
            formWizard.bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function(tab, navigation, index, clickedIndex) {
                    return false; // navigation on nav pills click disabled
                },
                onNext: function(tab, navigation, index) {
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, index);
                },
                onPrevious: function(tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function(tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    formWizard.find('.progress-bar').css({
                        width: $percent + '%'
                    });
                },
                onFinish: function(tab, navigation, index) {
                    form.submit();
                }
            });

            formWizard.find('.button-previous').hide();
            formWizard.find('.button-submit').hide();

            $("input[name^='n_']").not("input[name^='n_season']").not("input[name^='n_min_nights']").TouchSpin({
                min: 1,
                max: 1000,
                step: 1,
                decimals: 0
            });

        });
    </script>
@endsection
