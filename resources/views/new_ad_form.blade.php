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
                        <form @if(isset($Ad)&&isset($ad)) action="{{ route('edit.ad') }}" @else action="{{ route('new.ad') }}" @endif class="form-horizontal" id="submit_form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ \Session::token() }}">
                            @if(isset($Ad)&&isset($ad))
                                <input type="hidden" name="ad_id" value="{{ $Ad->id }}">
                                <input type="hidden" name="local_id" value="{{ $ad->id }}">
                                <input type="hidden" name="operation" value="{{ $operation }}">
                                <input type="hidden" name="typology" value="{{ $typology }}">
                            @endif
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
                                            ¡Formulario validado satisfactoriamente! Guardando formulario... Espere unos segundos.
                                        </div>

                                        {{--STEP 1--}}
                                        <div class="tab-pane active" id="tab1">

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Tipo de inmueble <span class="required">
													* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="typology" class="form-control" @if(isset($Ad)&&isset($ad)) disabled="disabled" @endif >
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
                                                            <input type="radio" name="operation" value="0" data-title="Venta" @if($operation=='0'&&($typology!='7'&&$typology!='8')) checked="checked" @endif @if($typology=='7'||$typology=='8'||(isset($Ad)&&isset($ad))) disabled="disabled" @endif />
                                                            Venta </label>
                                                        <label>
                                                            <input type="radio" name="operation" value="1" data-title="Alquiler" @if($operation=='1'||($typology=='7'||$typology=='8')) checked="checked" @endif @if(isset($Ad)&&isset($ad)) disabled="disabled" @endif  />
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
                                                        <input type="text" class="form-control" name="price" @if(isset($ad->price)) value="{!! $ad->price !!}" @endif />
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
                                                            <input type="checkbox" name="is_transfer" value="1" data-title="Es un traspaso" @if(isset($ad->is_transfer)&&$ad->is_transfer) checked="checked" @endif /> Es un traspaso</label>
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
                                                        <input type="text" class="form-control" name="community_cost" @if(isset($ad->community_cost)) value="{!! $ad->community_cost !!}" @endif />
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
                                                        <option value="Sin fianza" @if(isset($ad->deposit)&&$ad->deposit=='Sin fianza') selected=selected @endif >Sin fianza</option>
                                                        <option value="1 mes" @if(isset($ad->deposit)&&$ad->deposit=='1 mes') selected="selected" @endif >1 mes</option>
                                                        <option value="2 meses" @if(isset($ad->deposit)&&$ad->deposit=='2 meses') selected="selected" @endif >2 meses</option>
                                                        <option value="3 meses" @if(isset($ad->deposit)&&$ad->deposit=='3 meses') selected="selected" @endif >3 meses</option>
                                                        <option value="4 meses" @if(isset($ad->deposit)&&$ad->deposit=='4 meses') selected="selected" @endif >4 meses</option>
                                                        <option value="5 meses" @if(isset($ad->deposit)&&$ad->deposit=='5 meses') selected="selected" @endif >5 meses</option>
                                                        <option value="6 meses o m&aacute;s" @if(isset($ad->deposit)&&$ad->deposit=='6 meses o más') selected="selected" @endif >6 meses o m&aacute;s</option>
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
                                                            <input type="checkbox" name="is_bank_agency" value="1" data-title="Es de un banco o caja" @if(isset($ad->is_bank_agency)&&$ad->is_bank_agency) checked="checked" @endif /> Es de un banco o caja</label>
                                                        <label>
                                                            <input type="checkbox" name="is_state_subsidized" value="1" data-title="Es vivienda de protección oficial" @if(isset($ad->is_state_subsidized)&&$ad->is_state_subsidized) checked="checked" @endif /> Es vivienda de protección oficial</label>
                                                        <label>
                                                            <input type="checkbox" name="is_new_development" value="1" data-title="Es nueva promoción" @if(isset($ad->is_new_development)&&$ad->is_new_development) checked="checked" @endif /> Es nueva promoción</label>
                                                        <label>
                                                            <input type="checkbox" name="is_new_development_finished" value="1" data-title="Es nueva promoción terminada" @if(isset($ad->is_new_development_finished)&&$ad->is_new_development_finished) checked="checked" @endif /> Es nueva promoción terminada</label>
                                                        <label>
                                                            <input type="checkbox" name="is_rent_to_own" value="1" data-title="Es alquiler con opción a compra" @if(isset($ad->is_rent_to_own)&&$ad->is_rent_to_own) checked="checked" @endif /> Es alquiler con opción a compra</label>
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
                                                    <input type="text" class="form-control" name="municipio" value="@if(isset($ad->locality)) {{ $ad->locality }} @endif"/>
                                                    <label class="control-label">Nombre de la v&iacute;a</label>
                                                    <input type="text" class="form-control" name="via" value="@if(isset($ad->route)) {{ $ad->route }} @endif"/>
                                                    <label class="control-label">N&uacute;mero de la v&iacute;a @if($typology=='6') o Km @endif</label>
                                                    <input type="text" class="form-control" name="via_num" value="@if(isset($ad->street_number)) {{ $ad->street_number }} @endif"/>
                                                    <input type="hidden" class="form-control" name="address_confirmed" value="0"/>
                                                    <input type="hidden" class="form-control" name="lat" value="@if(isset($ad->lat)) {{ $ad->lat }} @endif"/>
                                                    <input type="hidden" class="form-control" name="lng" value="@if(isset($ad->lng)) {{ $ad->lng }} @endif"/>
                                                    <input type="hidden" class="form-control" name="formatted_address" value="@if(isset($ad->formatted_address)) {{ $ad->formatted_address }} @endif"/>
                                                    <input type="hidden" class="form-control" name="street_number" value="@if(isset($ad->street_number)) {{ $ad->street_number }} @endif"/>
                                                    <input type="hidden" class="form-control" name="route" value="@if(isset($ad->route)) {{ $ad->route }} @endif"/>
                                                    <input type="hidden" class="form-control" name="locality" value="@if(isset($ad->locality)) {{ $ad->locality }} @endif"/>
                                                    <input type="hidden" class="form-control" name="admin_area_lvl2" value="@if(isset($ad->admin_area_lvl2)) {{ $ad->admin_area_lvl2 }} @endif"/>
                                                    <input type="hidden" class="form-control" name="admin_area_lvl1" value="@if(isset($ad->admin_area_lvl1)) {{ $ad->admin_area_lvl1 }} @endif"/>
                                                    <input type="hidden" class="form-control" name="postal_code" value="@if(isset($ad->postal_code)) {{ $ad->postal_code }} @endif"/>
                                                    <input type="hidden" class="form-control" name="country" value="@if(isset($ad->country)) {{ $ad->country }} @endif"/>
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
                                                            <input type="checkbox" name="hide_address" value="1" data-title="Ocultar direcci&oacute;n" @if(isset($ad->hide_address)&&$ad->hide_address) checked="checked" @endif /> Ocultar direcci&oacute;n</label>
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
                                                        <option value="Por debajo de la planta baja (-2)" @if(isset($ad->floor_number)&&$ad->floor_number=='Por debajo de la planta baja (-2)') selected="selected" @endif >Por debajo de la planta baja (-2)</option>
                                                        <option value="Por debajo de la planta baja (-1)" @if(isset($ad->floor_number)&&$ad->floor_number=='Por debajo de la planta baja (-1)') selected="selected" @endif >Por debajo de la planta baja (-1)</option>
                                                        <option value="S&oacute;tano" @if(isset($ad->floor_number)&&$ad->floor_number=='Sótano') selected="selected" @endif >S&oacute;tano</option>
                                                        <option value="Semi-s&oacute;tano" @if(isset($ad->floor_number)&&$ad->floor_number=='Semi-sótano') selected="selected" @endif >Semi-s&oacute;tano</option>
                                                        <option value="Bajo" @if(isset($ad->floor_number)&&$ad->floor_number=='Bajo') selected="selected" @endif >Bajo</option>
                                                        <option value="Entreplanta" @if(isset($ad->floor_number)&&$ad->floor_number=='Entreplanta') selected="selected" @endif >Entreplanta</option>
                                                    @for($i = 1; $i < 101; ++$i)
                                                        <option value="Planta {{ $i }}&ordm;" @if(isset($ad->floor_number)&&$ad->floor_number=='Planta '.$i.'º') selected="selected" @endif >Planta {{ $i }}&ordm;</option>
                                                    @endfor
                                                    </select>
                                                    @if($typology!='3'&&$typology!='4')
                                                    <div class="checkbox-list" style="padding-top:4px;">
                                                        <label>
                                                            <input type="checkbox" name="is_last_floor" value="1" data-title="Es la &uacute;ltima planta del bloque" @if(isset($ad->is_last_floor)&&$ad->is_last_floor) checked="checked" @endif />Es la &uacute;ltima planta del bloque</label>
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
                                                    <?php
                                                        if(isset($ad->door)) {
                                                            $door_is_letter = (in_array($ad->door,range('A','Z'))) ? true : false;
                                                            $door_is_number = (in_array($ad->door,range(1,100))) ? true : false;
                                                        }
                                                    ?>
                                                    <select name="door" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="0" @if(isset($ad->door)&&$door_is_letter) selected="selected" @endif >Letra (A, B, C...)</option>
                                                        <option value="1" @if(isset($ad->door)&&$door_is_number) selected="selected" @endif >N&uacute;mero (1, 2, 3...)</option>
                                                        <option value="Puerta &uacute;nica" @if(isset($ad->door)&&$ad->door=='Puerta única') selected="selected" @endif >Puerta &uacute;nica</option>
                                                        <option value="Izquierda" @if(isset($ad->door)&&$ad->door=='Izquierda') selected="selected" @endif >Izquierda</option>
                                                        <option value="Derecha" @if(isset($ad->door)&&$ad->door=='Derecha') selected="selected" @endif >Derecha</option>
                                                        <option value="Exterior" @if(isset($ad->door)&&$ad->door=='Exterior') selected="selected" @endif >Exterior</option>
                                                        <option value="Exterior izquierda" @if(isset($ad->door)&&$ad->door=='Exterior izquierda') selected="selected" @endif >Exterior izquierda</option>
                                                        <option value="Exterior derecha" @if(isset($ad->door)&&$ad->door=='Exterior derecha') selected="selected" @endif >Exterior derecha</option>
                                                        <option value="Interior" @if(isset($ad->door)&&$ad->door=='Interior') selected="selected" @endif >Interior</option>
                                                        <option value="Interior izquierda" @if(isset($ad->door)&&$ad->door=='Interior izquierda') selected="selected" @endif >Interior izquierda</option>
                                                        <option value="Interior derecha" @if(isset($ad->door)&&$ad->door=='Interior derecha') selected="selected" @endif >Interior derecha</option>
                                                        <option value="Centro" @if(isset($ad->door)&&$ad->door=='Centro') selected="selected" @endif >Centro</option>
                                                        <option value="Centro izquierda" @if(isset($ad->door)&&$ad->door=='Centro izquierda') selected="selected" @endif >Centro izquierda</option>
                                                        <option value="Centro derecha" @if(isset($ad->door)&&$ad->door=='Centro derecha') selected="selected" @endif >Centro derecha</option>
                                                    </select>
                                                    <select name="door_number" class="form-control @if(!isset($ad->door)||(isset($ad->door)&&!$door_is_number)) hidden @endif " style="padding-top:5px;">
                                                        <option value="">Seleccione</option>
                                                    @for($i = 1; $i < 101; ++$i)
                                                        <option value="{{ $i }}" @if(isset($ad->door)&&$ad->door==''.$i) selected="selected" @endif >{{ $i }}</option>
                                                    @endfor
                                                    </select>
                                                    <select name="door_letter" class="form-control @if(!isset($ad->door)||(isset($ad->door)&&!$door_is_letter)) hidden @endif " style="padding-top:5px;">
                                                        <option value="">Seleccione</option>
                                                    @foreach(range('A','Z') as $letter)
                                                        <option value="{{ $letter }}" @if(isset($ad->door)&&$ad->door==''.$letter) selected="selected" @endif >{{ $letter }}</option>
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
                                                            <input type="radio" name="has_block" value="0" data-title="No" @if(!isset($ad->has_block)||(isset($ad->has_block)&&!$ad->has_block)) checked="checked" @endif />
                                                            No </label>
                                                        <label>
                                                            <input type="radio" name="has_block" value="1" data-title="S&iacute;, bloque/portal:" @if(isset($ad->has_block)&&$ad->has_block) checked="checked" @endif />
                                                            S&iacute;, bloque/portal: </label>
                                                            <input type="text" class="form-control" name="block" @if(!isset($ad->has_block)||(isset($ad->has_block)&&!$ad->has_block)) disabled="" @endif @if(isset($ad->block)&&$ad->block) value="{!! $ad->block !!}" @endif />
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
                                                        <input type="text" class="form-control" name="residential_area" @if(isset($ad->residential_area)&&$ad->residential_area) value="{!! $ad->residential_area !!}" @endif>
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
                                                            <input type="checkbox" name="is_regular" value="1" data-title="Piso" @if(isset($ad->is_regular)&&$ad->is_regular) checked="checked" @endif /> Piso</label>
                                                        <label>
                                                            <input type="checkbox" name="is_penthouse" value="1" data-title="&Aacute;tico" @if(isset($ad->is_penthouse)&&$ad->is_penthouse) checked="checked" @endif /> &Aacute;tico</label>
                                                        <label>
                                                            <input type="checkbox" name="is_duplex" value="1" data-title="D&uacute;plex" @if(isset($ad->is_duplex)&&$ad->is_duplex) checked="checked" @endif /> D&uacute;plex</label>
                                                        <label>
                                                            <input type="checkbox" name="is_studio" value="1" data-title="Estudio/loft" @if(isset($ad->is_studio)&&$ad->is_studio) checked="checked" @endif /> Estudio/loft</label>
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
                                                            <input type="radio" name="category_house_id" value="1" data-title="Casa o chalet independiente" @if(isset($ad->category_house_id)&&$ad->category_house_id=='1') checked="checked" @endif />
                                                            Casa o chalet independiente </label>
                                                        <label>
                                                            <input type="radio" name="category_house_id" value="2" data-title="Chalet pareado" @if(isset($ad->category_house_id)&&$ad->category_house_id=='2') checked="checked" @endif />
                                                            Chalet pareado </label>
                                                        <label>
                                                            <input type="radio" name="category_house_id" value="3" data-title="Chalet adosado" @if(isset($ad->category_house_id)&&$ad->category_house_id=='3') checked="checked" @endif />
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
                                                        <option value="1" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='1') selected="selected" @endif >Finca r&uacute;stica</option>
                                                        <option value="2" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='2') selected="selected" @endif >Castillo</option>
                                                        <option value="3" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='3') selected="selected" @endif >Palacio</option>
                                                        <option value="4" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='4') selected="selected" @endif >Mas&iacute;a</option>
                                                        <option value="5" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='5') selected="selected" @endif >Cortijo</option>
                                                        <option value="6" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='6') selected="selected" @endif >Casa rural</option>
                                                        <option value="7" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='7') selected="selected" @endif >Casa de pueblo</option>
                                                        <option value="8" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='8') selected="selected" @endif >Casa terrera</option>
                                                        <option value="9" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='9') selected="selected" @endif >Torre</option>
                                                        <option value="10" @if(isset($ad->category_country_house_id)&&$ad->category_country_house_id=='10') selected="selected" @endif >Caser&oacute;n</option>
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
                                                            <input type="radio" name="category_business_id" value="1" data-title="Local comercial" @if(isset($ad->category_business_id)&&$ad->category_business_id=='1') checked="checked" @endif />
                                                            Local comercial </label>
                                                        <label>
                                                            <input type="radio" name="category_business_id" value="2" data-title="Nave industrial" @if(isset($ad->category_business_id)&&$ad->category_business_id=='2') checked="checked" @endif />
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
                                                            <input type="radio" name="garage_capacity_id" value="1" data-title="Coche pequeño" @if(isset($ad->garage_capacity_id)&&$ad->garage_capacity_id=='1') checked="checked" @endif />
                                                            Coche pequeño </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="2" data-title="Coche grande" @if(isset($ad->garage_capacity_id)&&$ad->garage_capacity_id=='2') checked="checked" @endif />
                                                            Coche grande </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="3" data-title="Moto" @if(isset($ad->garage_capacity_id)&&$ad->garage_capacity_id=='3') checked="checked" @endif />
                                                            Moto </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="4" data-title="Coche y moto" @if(isset($ad->garage_capacity_id)&&$ad->garage_capacity_id=='4') checked="checked" @endif />
                                                            Coche y moto </label>
                                                        <label>
                                                            <input type="radio" name="garage_capacity_id" value="5" data-title="Dos coches o más" @if(isset($ad->garage_capacity_id)&&$ad->garage_capacity_id=='5') checked="checked" @endif />
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
                                                            <input type="radio" name="category_land_id" value="1" data-title="Urbano" @if(isset($ad->category_land_id)&&$ad->category_land_id=='1') checked="checked" @endif />
                                                            Urbano </label>
                                                        <label>
                                                            <input type="radio" name="category_land_id" value="2" data-title="Urbanizable" @if(isset($ad->category_land_id)&&$ad->category_land_id=='2') checked="checked" @endif />
                                                            Urbanizable </label>
                                                        <label>
                                                            <input type="radio" name="category_land_id" value="3" data-title="No urbanizable" @if(isset($ad->category_land_id)&&$ad->category_land_id=='3') checked="checked" @endif />
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
                                                            <input type="radio" name="category_room_id" value="1" data-title="Piso compartido" @if(isset($ad->category_room_id)&&$ad->category_room_id=='1') checked="checked" @endif />
                                                            Piso compartido </label>
                                                        <label>
                                                            <input type="radio" name="category_room_id" value="2" data-title="Chalet compartido" @if(isset($ad->category_room_id)&&$ad->category_room_id=='2') checked="checked" @endif />
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
                                                        <input type="text" class="form-control" name="area_room" @if(isset($ad->area_room)&&$ad->area_room) value="{!! $ad->area_room !!}" @endif />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Total de personas (capacidad incluyendo nuevo inquilino)
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_people" @if(isset($ad->n_people)&&$ad->n_people) value="{!! $ad->n_people !!}" @endif  />
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
                                                            <input type="checkbox" name="needs_restoration" value="1" data-title="Necesita reformas" @if(isset($ad->needs_restoration)&&$ad->needs_restoration) checked="checked" @endif /> Necesita reformas</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; construidos <span class="required"> *
                                                </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_constructed" @if(isset($ad->area_constructed)&&$ad->area_constructed) value="{!! $ad->area_constructed !!}" @endif />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; &uacute;tiles
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_usable" @if(isset($ad->area_usable)&&$ad->area_usable) value="{!! $ad->area_usable !!}" @endif />
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
                                                        <input type="text" class="form-control" name="area_land" @if(isset($ad->area_land)&&$ad->area_land) value="{!! $ad->area_land !!}" @endif />
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
                                                        <input type="text" class="form-control" name="area_total" @if(isset($ad->area_total)&&$ad->area_total) value="{!! $ad->area_total !!}" @endif />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; edificables
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_building_land" @if(isset($ad->area_building_land)&&$ad->area_building_land) value="{!! $ad->area_building_land !!}" @endif />
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
                                                        <input type="text" class="form-control" name="area_min_for_sale" @if(isset($ad->area_min_for_sale)&&$ad->area_min_for_sale) value="{!! $ad->area_min_for_sale !!}" @endif />
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
                                                            <input type="radio" name="business_distribution_id" value="1" data-title="Di&aacute;fana" @if(isset($ad->business_distribution_id)&&$ad->business_distribution_id=='1') checked="checked" @endif />
                                                            Di&aacute;fana </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="2" data-title="1-2 estancias" @if(isset($ad->business_distribution_id)&&$ad->business_distribution_id=='2') checked="checked" @endif />
                                                            1-2 estancias </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="3" data-title="3-5 estancias" @if(isset($ad->business_distribution_id)&&$ad->business_distribution_id=='3') checked="checked" @endif />
                                                            3-5 estancias </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="4" data-title="5-10 estancias" @if(isset($ad->business_distribution_id)&&$ad->business_distribution_id=='4') checked="checked" @endif />
                                                            5-10 estancias </label>
                                                        <label>
                                                            <input type="radio" name="business_distribution_id" value="5" data-title="M&aacute; de 10 estancias" @if(isset($ad->business_distribution_id)&&$ad->business_distribution_id=='5') checked="checked" @endif />
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
                                                            <input type="radio" name="business_facade_id" value="1" data-title="Sin fachada" @if(isset($ad->business_facade_id)&&$ad->business_facade_id=='1') checked="checked" @endif />
                                                            Sin fachada </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="2" data-title="1 a 4 metros" @if(isset($ad->business_facade_id)&&$ad->business_facade_id=='2') checked="checked" @endif />
                                                            1 a 4 metros </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="3" data-title="5 a 8 metros" @if(isset($ad->business_facade_id)&&$ad->business_facade_id=='3') checked="checked" @endif />
                                                            5 a 8 metros </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="4" data-title="9 a 12 metros" @if(isset($ad->business_facade_id)&&$ad->business_facade_id=='4') checked="checked" @endif />
                                                            9 a 12 metros </label>
                                                        <label>
                                                            <input type="radio" name="business_facade_id" value="5" data-title="M&aacute; de 12 metros" @if(isset($ad->business_facade_id)&&$ad->business_facade_id=='5') checked="checked" @endif />
                                                            M&aacute; de 12 metros </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">N&uacute;mero de escaparates
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_shop_windows" @if(isset($ad->n_shop_windows)&&$ad->n_shop_windows) value="{!! $ad->n_shop_windows !!}" @endif />
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
                                                            <input type="radio" name="business_location_id" value="1" data-title="En centro comercial"  @if(isset($ad->business_location_id)&&$ad->business_location_id=='1') checked="checked" @endif />
                                                            En centro comercial </label>
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="2" data-title="A pie de calle" @if(isset($ad->business_location_id)&&$ad->business_location_id=='2') checked="checked" @endif />
                                                            A pie de calle </label>
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="3" data-title="Entreplanta" @if(isset($ad->business_location_id)&&$ad->business_location_id=='3') checked="checked" @endif />
                                                            Entreplanta </label>
                                                         <label>
                                                            <input type="radio" name="business_location_id" value="4" data-title="Subterr&aacute;neo" @if(isset($ad->business_location_id)&&$ad->business_location_id=='4') checked="checked" @endif />
                                                             Subterr&aacute;neo </label>
                                                        <label>
                                                            <input type="radio" name="business_location_id" value="5" data-title="Otros" @if(isset($ad->business_location_id)&&$ad->business_location_id=='5') checked="checked" @endif />
                                                            Otros </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Última actividad comercial
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="last_activity" @if(isset($ad->last_activity)&&$ad->last_activity) value="{!! $ad->last_activity !!}" @endif />
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
                                                        <input type="text" class="form-control" name="n_floors" @if(isset($ad->n_floors)&&$ad->n_floors) value="{!! $ad->n_floors !!}" @endif />
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
                                                        <input type="text" class="form-control" name="n_bedrooms" @if(isset($ad->n_bedrooms)&&$ad->n_bedrooms) value="{!! $ad->n_bedrooms !!}" @endif />
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
                                                        <input type="text" class="form-control" name="n_bathrooms" @if(isset($ad->n_bathrooms)&&$ad->n_bathrooms) value="{!! $ad->n_bathrooms !!}" @endif />
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
                                                        <input type="text" class="form-control" name="n_restrooms" @if(isset($ad->n_restrooms)&&$ad->n_restrooms) value="{!! $ad->n_restrooms !!}" @endif />
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
                                                            <input type="checkbox" name="has_bathrooms" value="1" data-title="Disponen de baño" @if(isset($ad->has_bathrooms)&&$ad->has_bathrooms) checked="checked" @endif /> Disponen de baño</label>
                                                        <label>
                                                            <input type="checkbox" name="has_bathrooms_inside" value="1" data-title="Están dentro de las oficinas" @if(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside) checked="checked" @endif /> Están dentro de las oficinas</label>
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
                                                            <input type="radio" name="is_exterior" value="1" data-title="Exterior" @if(isset($ad->is_exterior)&&$ad->is_exterior) checked="checked" @endif />
                                                            Exterior </label>
                                                        <label>
                                                            <input type="radio" name="is_exterior" value="0" data-title="Interior" @if(isset($ad->is_exterior)&&!$ad->is_exterior) checked="checked" @endif />
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
                                                            <input type="radio" name="office_distribution_id" value="1" data-title="Di&aacute;fana" @if(isset($ad->office_distribution_id)&&$ad->office_distribution_id=='1') checked="checked" @endif />
                                                            Di&aacute;fana </label>
                                                        <label>
                                                            <input type="radio" name="office_distribution_id" value="2" data-title="Dividida con mamparas" @if(isset($ad->office_distribution_id)&&$ad->office_distribution_id=='2') checked="checked" @endif />
                                                            Dividida con mamparas </label>
                                                        <label>
                                                            <input type="radio" name="office_distribution_id" value="3" data-title="Dividida con tabiques" @if(isset($ad->office_distribution_id)&&$ad->office_distribution_id=='3') checked="checked" @endif />
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
                                                            <input type="radio" name="has_offices_only" value="1" data-title="S&iacute;" @if(isset($ad->has_offices_only)&&$ad->has_offices_only) checked="checked" @endif />
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="has_offices_only" value="0" data-title="No" @if(isset($ad->has_offices_only)&&!$ad->has_offices_only) checked="checked" @endif />
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
                                                            <input type="radio" name="current_tenants_gender_id" value="1" data-title="Chico(s) y chica(s)" @if(isset($ad->current_tenants_gender_id)&&$ad->current_tenants_gender_id=='1') checked="checked" @endif />
                                                            Chico(s) y chica(s) </label>
                                                        <label>
                                                            <input type="radio" name="current_tenants_gender_id" value="2" data-title="S&oacute;lo chico(s)" @if(isset($ad->current_tenants_gender_id)&&$ad->current_tenants_gender_id=='2') checked="checked" @endif />
                                                            S&oacute;lo chico(s) </label>
                                                        <label>
                                                            <input type="radio" name="current_tenants_gender_id" value="3" data-title="S&oacute;lo chica(s)" @if(isset($ad->current_tenants_gender_id)&&$ad->current_tenants_gender_id=='3') checked="checked" @endif />
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
                                                            <input type="radio" name="is_smoking_allowed" value="1" data-title="S&iacute;" @if(isset($ad->is_smoking_allowed)&&$ad->is_smoking_allowed) checked="checked" @endif />
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="is_smoking_allowed" value="0" data-title="No" @if(isset($ad->is_smoking_allowed)&&!$ad->is_smoking_allowed) checked="checked" @endif />
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
                                                            <input type="radio" name="is_pet_allowed" value="1" data-title="S&iacute;" @if(isset($ad->is_pet_allowed)&&$ad->is_pet_allowed) checked="checked" @endif />
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="is_pet_allowed" value="0" data-title="No" @if(isset($ad->is_pet_allowed)&&!$ad->is_pet_allowed) checked="checked" @endif />
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
                                                        <input type="text" class="form-control" name="min_current_tenants_age" @if(isset($ad->min_current_tenants_age)&&$ad->min_current_tenants_age) value="{!! $ad->min_current_tenants_age !!}" @endif />
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
                                                        <input type="text" class="form-control" name="max_current_tenants_age" @if(isset($ad->max_current_tenants_age)&&$ad->max_current_tenants_age) value="{!! $ad->max_current_tenants_age !!}" @endif />
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
                                                            <input type="checkbox" name="has_equipped_kitchen" value="1" data-title="Cocina completamente equipada" @if(isset($ad->has_equipped_kitchen)&&$ad->has_equipped_kitchen) checked="checked" @endif /> Cocina completamente equipada</label>
                                                        <label>
                                                            <input type="checkbox" name="has_furniture" value="1" data-title="Vivienda amueblada" @if(isset($ad->has_furniture)&&$ad->has_furniture) checked="checked" @endif /> Vivienda amueblada</label>
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
                                                            <input type="radio" name="has_elevator" value="1" data-title="S&iacute;" @if(isset($ad->has_elevator)&&$ad->has_elevator) checked="checked" @endif />
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="has_elevator" value="0" data-title="No" @if(isset($ad->has_elevator)&&!$ad->has_elevator) checked="checked" @endif />
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
                                                        <input type="text" class="form-control" name="n_elevators" @if(isset($ad->n_elevators)&&$ad->n_elevators) value="{!! $ad->n_elevators !!}" @endif />
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
                                                        <option value="1" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='1') selected="selected" @endif >A&uacute;n no dispone</option>
                                                        <option value="2" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='2') selected="selected" @endif >A</option>
                                                        <option value="3" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='3') selected="selected" @endif >B</option>
                                                        <option value="4" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='4') selected="selected" @endif >C</option>
                                                        <option value="5" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='5') selected="selected" @endif >D</option>
                                                        <option value="6" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='6') selected="selected" @endif >E</option>
                                                        <option value="7" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='7') selected="selected" @endif >F</option>
                                                        <option value="8" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='8') selected="selected" @endif >G</option>
                                                        <option value="9" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='9') selected="selected" @endif >Inmueble exento</option>
                                                        <option value="10" @if(isset($ad->energy_certification_id)&&$ad->energy_certification_id=='10') selected="selected" @endif >En tr&aacute;mite</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Prestación energética
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="energy_performance" @if(isset($ad->energy_performance)&&$ad->energy_performance) value="{!! $ad->energy_performance !!}" @endif />
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
                                                            <input type="checkbox" name="faces_north" value="1" data-title="Norte" @if(isset($ad->faces_north)&&$ad->faces_north) checked="checked" @endif /> Norte</label>
                                                        <label>
                                                            <input type="checkbox" name="faces_south" value="1" data-title="Sur" @if(isset($ad->faces_south)&&$ad->faces_south) checked="checked" @endif /> Sur</label>
                                                        <label>
                                                            <input type="checkbox" name="faces_east" value="1" data-title="Este" @if(isset($ad->faces_east)&&$ad->faces_east) checked="checked" @endif /> Este</label>
                                                        <label>
                                                            <input type="checkbox" name="faces_west" value="1" data-title="Oeste" @if(isset($ad->faces_west)&&$ad->faces_west) checked="checked" @endif /> Oeste</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Otras caracter&iacute;sticas de la vivienda
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_builtin_closets" value="1" data-title="Armarios empotrados" @if(isset($ad->has_builtin_closets)&&$ad->has_builtin_closets) checked="checked" @endif /> Armarios empotrados</label>
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado" @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) checked="checked" @endif /> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_terrace" value="1" data-title="Terraza" @if(isset($ad->has_terrace)&&$ad->has_terrace) checked="checked" @endif /> Terraza</label>
                                                        <label>
                                                            <input type="checkbox" name="has_box_room" value="1" data-title="Trastero" @if(isset($ad->has_box_room)&&$ad->has_box_room) checked="checked" @endif /> Trastero</label>
                                                        <label>
                                                            <input type="checkbox" name="has_parking_space" value="1" data-title="Plaza de garaje @if($operation=='0') incluida en el precio @endif " @if(isset($ad->has_parking_space)&&$ad->has_parking_space) checked="checked" @endif /> Plaza de garaje
                                                            @if($operation=='0') incluida en el precio @endif
                                                        </label>
                                                        @if($typology!='0')
                                                        <label>
                                                            <input type="checkbox" name="has_fireplace" value="1" data-title="Chimenea" @if(isset($ad->has_fireplace)&&$ad->has_fireplace) checked="checked" @endif /> Chimenea</label>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Otras caracter&iacute;sticas del edificio
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_swimming_pool" value="1" data-title="Piscina" @if(isset($ad->has_swimming_pool)&&$ad->has_swimming_pool) checked="checked" @endif /> Piscina</label>
                                                        <label>
                                                            <input type="checkbox" name="has_garden" value="1" data-title="Zona verde" @if(isset($ad->has_garden)&&$ad->has_garden) checked="checked" @endif /> Zona verde</label>
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
                                                        <input type="text" class="form-control" name="n_parking_spaces" @if(isset($ad->n_parking_spaces)&&$ad->n_parking_spaces) value="{!! $ad->n_parking_spaces !!}" @endif />
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
                                                            <input type="checkbox" name="has_steel_door" value="1" data-title="Puerta de seguridad" @if(isset($ad->has_steel_door)&&$ad->has_steel_door) checked="checked" @endif /> Puerta de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_system" value="1" data-title="Sistema de alarma/circuito cerrado de seguridad" @if(isset($ad->has_security_system)&&$ad->has_security_system) checked="checked" @endif /> Sistema de alarma/circuito cerrado de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_access_control" value="1" data-title="Control de accesos" @if(isset($ad->has_access_control)&&$ad->has_access_control) checked="checked" @endif /> Control de accesos</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fire_detectors" value="1" data-title="Detectores de icendios" @if(isset($ad->has_fire_detectors)&&$ad->has_fire_detectors) checked="checked" @endif /> Detectores de icendios</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fire_extinguishers" value="1" data-title="Extintores" @if(isset($ad->has_fire_extinguishers)&&$ad->has_fire_extinguishers) checked="checked" @endif /> Extintores</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fire_sprinklers" value="1" data-title="Aspersores" @if(isset($ad->has_fire_sprinklers)&&$ad->has_fire_sprinklers) checked="checked" @endif /> Aspersores</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fireproof_doors" value="1" data-title="Puerta cortafuegos" @if(isset($ad->has_fireproof_doors)&&$ad->has_fireproof_doors) checked="checked" @endif /> Puerta cortafuegos</label>
                                                        <label>
                                                            <input type="checkbox" name="has_emergency_lights" value="1" data-title="Luces de salida de emergencia" @if(isset($ad->has_emergency_lights)&&$ad->has_emergency_lights) checked="checked" @endif /> Luces de salida de emergencia</label>
                                                        <label>
                                                            <input type="checkbox" name="has_doorman" value="1" data-title="Conserje/portero/seguridad" @if(isset($ad->has_doorman)&&$ad->has_doorman) checked="checked" @endif /> Conserje/portero/seguridad</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Climatización y agua caliente
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado" @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) checked="checked" @endif /> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning_preinstallation" value="1" data-title="Preinstalación de aire acondicionado" @if(isset($ad->has_air_conditioning_preinstallation)&&$ad->has_air_conditioning_preinstallation) checked="checked" @endif /> Preinstalación de aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_heating" value="1" data-title="Calefacción" @if(isset($ad->has_heating)&&$ad->has_heating) checked="checked" @endif /> Calefacción</label>
                                                        <label>
                                                            <input type="checkbox" name="has_hot_water" value="1" data-title="Agua caliente" @if(isset($ad->has_hot_water)&&$ad->has_hot_water) checked="checked" @endif /> Agua caliente</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas de la oficina
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_kitchen" value="1" data-title="Cocina/office" @if(isset($ad->has_kitchen)&&$ad->has_kitchen) checked="checked" @endif /> Cocina/office</label>
                                                        <label>
                                                            <input type="checkbox" name="has_archive" value="1" data-title="Almac&eacute;n" @if(isset($ad->has_archive)&&$ad->has_archive) checked="checked" @endif /> Almac&eacute;n</label>
                                                        <label>
                                                            <input type="checkbox" name="has_double_windows" value="1" data-title="Doble acristalamiento" @if(isset($ad->has_double_windows)&&$ad->has_double_windows) checked="checked" @endif /> Doble acristalamiento</label>
                                                        <label>
                                                            <input type="checkbox" name="has_suspended_ceiling" value="1" data-title="Falso techo" @if(isset($ad->has_suspended_ceiling)&&$ad->has_suspended_ceiling) checked="checked" @endif /> Falso techo</label>
                                                        <label>
                                                            <input type="checkbox" name="has_suspended_floor" value="1" data-title="Suelo t&eacute;cnico" @if(isset($ad->has_suspended_floor)&&$ad->has_suspended_floor) checked="checked" @endif /> Suelo t&eacute;cnico</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas del edificio
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="is_handicapped_adapted" value="1" data-title="Adaptado a personas con movilidad reducida" @if(isset($ad->is_handicapped_adapted)&&$ad->is_handicapped_adapted) checked="checked" @endif /> Adaptado a personas con movilidad reducida</label>
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
                                                            <input type="checkbox" name="has_archive" value="1" data-title="Almac&eacute;n" @if(isset($ad->has_archive)&&$ad->has_archive) checked="checked" @endif /> Almac&eacute;n</label>
                                                        <label>
                                                            <input type="checkbox" name="has_smoke_extractor" value="1" data-title="Salida de humos" @if(isset($ad->has_smoke_extractor)&&$ad->has_smoke_extractor) checked="checked" @endif /> Salida de humos</label>
                                                        <label>
                                                            <input type="checkbox" name="has_fully_equipped_kitchen" value="1" data-title="Cocina completamente equipada" @if(isset($ad->has_fully_equipped_kitchen)&&$ad->has_fully_equipped_kitchen) checked="checked" @endif /> Cocina completamente equipada</label>
                                                        <label>
                                                            <input type="checkbox" name="has_steel_door" value="1" data-title="Puerta de seguridad" @if(isset($ad->has_steel_door)&&$ad->has_steel_door) checked="checked" @endif /> Puerta de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_alarm" value="1" data-title="Sistema de alarma" @if(isset($ad->has_alarm)&&$ad->has_alarm) checked="checked" @endif /> Sistema de alarma</label>
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado" @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) checked="checked" @endif /> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_heating" value="1" data-title="Calefacci&oacute;n" @if(isset($ad->has_heating)&&$ad->has_heating) checked="checked" @endif /> Calefacci&oacute;n</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_camera" value="1" data-title="Circuito cerrado de seguridad" @if(isset($ad->has_security_camera)&&$ad->has_security_camera) checked="checked" @endif /> Circuito cerrado de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="is_corner_located" value="1" data-title="Hace esquina" @if(isset($ad->is_corner_located)&&$ad->is_corner_located) checked="checked" @endif /> Hace esquina</label>
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
                                                            <input type="checkbox" name="is_covered" value="1" data-title="Cubierto" @if(isset($ad->is_covered)&&$ad->is_covered) checked="checked" @endif /> Cubierto</label>
                                                        <label>
                                                            <input type="checkbox" name="has_automatic_door" value="1" data-title="Puerta automática" @if(isset($ad->has_automatic_door)&&$ad->has_automatic_door) checked="checked" @endif /> Puerta automática</label>
                                                        <label>
                                                            <input type="checkbox" name="has_lift" value="1" data-title="Ascensor" @if(isset($ad->has_lift)&&$ad->has_lift) checked="checked" @endif /> Ascensor</label>
                                                        <label>
                                                            <input type="checkbox" name="has_alarm" value="1" data-title="Sistema de alarma" @if(isset($ad->has_alarm)&&$ad->has_alarm) checked="checked" @endif /> Sistema de alarma</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_camera" value="1" data-title="Circuito cerrado de seguridad" @if(isset($ad->has_security_camera)&&$ad->has_security_camera) checked="checked" @endif /> Circuito cerrado de seguridad</label>
                                                        <label>
                                                            <input type="checkbox" name="has_security_guard" value="1" data-title="Vigilante/seguridad" @if(isset($ad->has_security_guard)&&$ad->has_security_guard) checked="checked" @endif /> Vigilante/seguridad</label>
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
                                                            <input type="checkbox" name="is_classified_residential_block" value="1" data-title="Residencial en altura (bloques)" @if(isset($ad->is_classified_residential_block)&&$ad->is_classified_residential_block) checked="checked" @endif /> Residencial en altura (bloques)</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_residential_house" value="1" data-title="Residencial unifamiliar (chalets)" @if(isset($ad->is_classified_residential_house)&&$ad->is_classified_residential_house) checked="checked" @endif /> Residencial unifamiliar (chalets)</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_office" value="1" data-title="Terciario oficinas" @if(isset($ad->is_classified_office)&&$ad->is_classified_office) checked="checked" @endif /> Terciario oficinas</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_commercial" value="1" data-title="Terciario comercial" @if(isset($ad->is_classified_commercial)&&$ad->is_classified_commercial) checked="checked" @endif /> Terciario comercial</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_hotel" value="1" data-title="Terciario hoteles" @if(isset($ad->is_classified_hotel)&&$ad->is_classified_hotel) checked="checked" @endif /> Terciario hoteles</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_industrial" value="1" data-title="Industrial" @if(isset($ad->is_classified_industrial)&&$ad->is_classified_industrial) checked="checked" @endif /> Industrial</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_public_service" value="1" data-title="Dotaciones (hospitales, escuelas, museos)" @if(isset($ad->is_classified_public_service)&&$ad->is_classified_public_service) checked="checked" @endif /> Dotaciones (hospitales, escuelas, museos)</label>
                                                        <label>
                                                            <input type="checkbox" name="is_classified_others" value="1" data-title="Otras" @if(isset($ad->is_classified_others)&&$ad->is_classified_others) checked="checked" @endif /> Otras</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Número máximo de plantas edificables
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_floors_allowed" @if(isset($ad->max_floors_allowed)&&$ad->max_floors_allowed) value="{!! $ad->max_floors_allowed !!}" @endif />
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
                                                            <input type="radio" name="has_road_access" value="1" data-title="S&iacute;, tiene" @if(isset($ad->has_road_access)&&$ad->has_road_access) checked="checked" @endif />
                                                            S&iacute;,tiene</label>
                                                        <label>
                                                            <input type="radio" name="has_road_access" value="0" data-title="No disponible" @if(isset($ad->has_road_access)&&!$ad->has_road_access) checked="checked" @endif />
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
                                                        <option value="1" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='1') selected="selected" @endif >No lo sé</option>
                                                        <option value="2" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='2') selected="selected" @endif >En núcleo urbano</option>
                                                        <option value="3" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='3') selected="selected" @endif >Menos de 500 m</option>
                                                        <option value="4" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='4') selected="selected" @endif >Entre 500 m y 1 km</option>
                                                        <option value="5" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='5') selected="selected" @endif >De 1 a 2 km</option>
                                                        <option value="6" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='6') selected="selected" @endif >De 2 a 5 km</option>
                                                        <option value="7" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='7') selected="selected" @endif >De 5 a 10 km</option>
                                                        <option value="8" @if(isset($ad->nearest_town_distance_id)&&$ad->nearest_town_distance_id=='8') selected="selected" @endif >Más de 10 km</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Otras características del terreno
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_water" value="1" data-title="Agua" @if(isset($ad->has_water)&&$ad->has_water) checked="checked" @endif /> Agua</label>
                                                        <label>
                                                            <input type="checkbox" name="has_electricity" value="1" data-title="Luz" @if(isset($ad->has_electricity)&&$ad->has_electricity) checked="checked" @endif /> Luz</label>
                                                        <label>
                                                            <input type="checkbox" name="has_sewer_system" value="1" data-title="Alcantarillado" @if(isset($ad->has_sewer_system)&&$ad->has_sewer_system) checked="checked" @endif /> Alcantarillado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_natural_gas" value="1" data-title="Gas natural" @if(isset($ad->has_natural_gas)&&$ad->has_natural_gas) checked="checked" @endif /> Gas natural</label>
                                                        <label>
                                                            <input type="checkbox" name="has_street_lighting" value="1" data-title="Alumbrado público" @if(isset($ad->has_street_lighting)&&$ad->has_street_lighting) checked="checked" @endif /> Alumbrado público</label>
                                                        <label>
                                                            <input type="checkbox" name="has_sidewalks" value="1" data-title="Aceras" @if(isset($ad->has_sidewalks)&&$ad->has_sidewalks) checked="checked" @endif /> Aceras</label>
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
                                                            <input type="checkbox" name="has_furniture" value="1" data-title="Amueblada" @if(isset($ad->has_furniture)&&$ad->has_furniture) checked="checked" @endif /> Amueblada</label>
                                                        <label>
                                                            <input type="checkbox" name="has_builtin_closets" value="1" data-title="Armario empotrado" @if(isset($ad->has_builtin_closets)&&$ad->has_builtin_closets) checked="checked" @endif /> Armario empotrado</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Caracter&iacute;sticas del inmueble
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado" @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) checked="checked" @endif /> Aire acondicionado</label>
                                                        <label>
                                                            <input type="checkbox" name="has_internet" value="1" data-title="Conexi&oacute;n a internet" @if(isset($ad->has_internet)&&$ad->has_internet) checked="checked" @endif /> Conexi&oacute;n a internet</label>
                                                        <label>
                                                            <input type="checkbox" name="has_house_keeper" value="1" data-title="Asistente/a del hogar" @if(isset($ad->has_house_keeper)&&$ad->has_house_keeper) checked="checked" @endif /> Asistente/a del hogar</label>
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
                                                            <input type="radio" name="tenant_gender_id" value="1" data-title="Da igual" @if(isset($ad->tenant_gender_id)&&$ad->tenant_gender_id=='1') checked="checked" @endif />
                                                            Da igual </label>
                                                        <label>
                                                            <input type="radio" name="tenant_gender_id" value="2" data-title="Chico" @if(isset($ad->tenant_gender_id)&&$ad->tenant_gender_id=='2') checked="checked" @endif />
                                                            Chico </label>
                                                        <label>
                                                            <input type="radio" name="tenant_gender_id" value="3" data-title="Chica" @if(isset($ad->tenant_gender_id)&&$ad->tenant_gender_id=='3') checked="checked" @endif />
                                                            Chica </label>
                                                    </div>
                                                    <div class="radio-list">
                                                        <label style="padding-top:5px;">Ocupaci&oacute;n</label>
                                                        <label>tenant_occupation_id
                                                            <input type="radio" name="tenant_occupation_id" value="1" data-title="Da igual" @if(isset($ad->tenant_occupation_id)&&$ad->tenant_occupation_id=='1') checked="checked" @endif />
                                                            Da igual </label>
                                                        <label>
                                                            <input type="radio" name="tenant_occupation_id" value="2" data-title="Estudiante" @if(isset($ad->tenant_occupation_id)&&$ad->tenant_occupation_id=='2') checked="checked" @endif />
                                                            Estudiante </label>
                                                        <label>
                                                            <input type="radio" name="tenant_occupation_id" value="3" data-title="Con trabajo" @if(isset($ad->tenant_occupation_id)&&$ad->tenant_occupation_id=='3') checked="checked" @endif />
                                                            Con trabajo </label>
                                                    </div>
                                                    <div class="radio-list">
                                                        <label style="padding-top:5px;">Orientaci&oacute;n</label>
                                                        <label>
                                                            <input type="radio" name="tenant_sexual_orientation_id" value="1" data-title="Da igual" @if(isset($ad->tenant_sexual_orientation_id)&&$ad->tenant_sexual_orientation_id=='1') checked="checked" @endif />
                                                            Da igual </label>
                                                        <label>
                                                            <input type="radio" name="tenant_sexual_orientation_id" value="2" data-title="Gay friendly" @if(isset($ad->tenant_sexual_orientation_id)&&$ad->tenant_sexual_orientation_id=='2') checked="checked" @endif />
                                                            Gay friendly </label>
                                                    </div>
                                                    <div class="radio-list">
                                                        <label style="padding-top:5px;">Estancia m&iacute;nima</label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="1" data-title="1 mes" @if(isset($ad->tenant_min_stay_id)&&$ad->tenant_min_stay_id=='1') checked="checked" @endif />
                                                            1 mes </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="2" data-title="2 meses" @if(isset($ad->tenant_min_stay_id)&&$ad->tenant_min_stay_id=='2') checked="checked" @endif />
                                                            2 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="3" data-title="3 meses" @if(isset($ad->tenant_min_stay_id)&&$ad->tenant_min_stay_id=='3') checked="checked" @endif />
                                                            3 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="4" data-title="4 meses" @if(isset($ad->tenant_min_stay_id)&&$ad->tenant_min_stay_id=='4') checked="checked" @endif />
                                                            4 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="5" data-title="5 meses" @if(isset($ad->tenant_min_stay_id)&&$ad->tenant_min_stay_id=='5') checked="checked" @endif />
                                                            5 meses </label>
                                                        <label>
                                                            <input type="radio" name="tenant_min_stay_id" value="6" data-title="6 o más meses" @if(isset($ad->tenant_min_stay_id)&&$ad->tenant_min_stay_id=='6') checked="checked" @endif />
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
                                                            <input type="radio" name="surroundings_id" value="1" data-title="Entorno de playa" @if(isset($ad->surroundings_id)&&$ad->surroundings_id=='1') checked="checked" @endif />
                                                            Entorno de playa </label>
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="2" data-title="Entorno de esquí" @if(isset($ad->surroundings_id)&&$ad->surroundings_id=='2') checked="checked" @endif />
                                                            Entorno de esquí </label>
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="3" data-title="Entorno rural" @if(isset($ad->surroundings_id)&&$ad->surroundings_id=='3') checked="checked" @endif />
                                                            Entorno rural </label>
                                                        <label>
                                                            <input type="radio" name="surroundings_id" value="4" data-title="Entorno de ciudad" @if(isset($ad->surroundings_id)&&$ad->surroundings_id=='4') checked="checked" @endif />
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
                                                            <input type="radio" name="category_lodging_id" value="1" data-title="Apartamento" @if(isset($ad->category_lodging_id)&&$ad->category_lodging_id=='1') checked="checked" @endif />
                                                            Apartamento </label>
                                                        <label>
                                                            <input type="radio" name="category_lodging_id" value="2" data-title="Casa" @if(isset($ad->category_lodging_id)&&$ad->category_lodging_id=='2') checked="checked" @endif />
                                                            Casa </label>
                                                        <label>
                                                            <input type="radio" name="category_lodging_id" value="3" data-title="Villa" @if(isset($ad->category_lodging_id)&&$ad->category_lodging_id=='3') checked="checked" @endif />
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
                                                            <input type="radio" name="has_multiple_lodgings" value="0" data-title="No, es un alojamiento" @if(isset($ad->has_multiple_lodgings)&&!$ad->has_multiple_lodgings) checked="checked" @endif />
                                                            No, es un alojamiento </label>
                                                        <label>
                                                            <input type="radio" name="has_multiple_lodgings" value="1" data-title="Sí, son varios" @if(isset($ad->has_multiple_lodgings)&&$ad->has_multiple_lodgings) checked="checked" @endif />
                                                            Sí, son varios </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; totales
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_total" @if(isset($ad->area_total)&&$ad->area_total) value="{!! $ad->area_total !!}" @endif />
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
                                                        <input type="text" class="form-control" name="area_garden" @if(isset($ad->area_garden)&&$ad->area_garden) value="{!! $ad->area_garden !!}" @endif />
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
                                                        <input type="text" class="form-control" name="area_terrace" @if(isset($ad->area_terrace)&&$ad->area_terrace) value="{!! $ad->area_terrace !!}" @endif />
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
                                                            <input type="radio" name="is_american_kitchen" value="0" data-title="Cocina independiente" @if(isset($ad->is_american_kitchen)&&!$ad->is_american_kitchen) checked="checked" @endif />
                                                            Cocina independiente </label>
                                                        <label>
                                                            <input type="radio" name="is_american_kitchen" value="1" data-title="Cocina americana" @if(isset($ad->is_american_kitchen)&&$ad->is_american_kitchen) checked="checked" @endif />
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
                                                        @if(isset($ad->id)&&\App\SeasonPrice::where('rent_vacation_id',$ad->id)->count())
                                                            @foreach(\App\SeasonPrice::where('rent_vacation_id',$ad->id)->get() as $season)
                                                                <tr data-season="{!! $season->n_season !!}">
                                                                @if($season->n_season == '1')
                                                                    <td><input name="n_season-{!! $season->n_season !!}" class="hidden" value="{!! $season->n_season !!}">Resto del a&ntilde;o</td>
                                                                    <td><input name="from_date-{!! $season->n_season !!}" class="hidden" value="1/1/1900">-</td>
                                                                    <td><input name="to_date-{!! $season->n_season !!}" class="hidden" value="1/1/2999">-</td>
                                                                @else
                                                                    <td><input name="n_season-{!! $season->n_season !!}" class="hidden" value="{!! $season->n_season !!}"></td>
                                                                    <td>
                                                                        <div class="bfh-datepicker" data-name="from_date-{!! $season->n_season !!}" @if(isset($season->from_date)&&$season->from_date=!'0000-00-00 00:00:00') value="{{ date('d/m/Y', strtotime($season->from_date) ) }}" @endif ></div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="bfh-datepicker" data-name="to_date-{!! $season->n_season !!}" @if(isset($season->to_date)&&$season->to_date=!'0000-00-00 00:00:00') value="{{ date('d/m/Y', strtotime($season->to_date) ) }}" @endif ></div>
                                                                    </td>  
                                                                @endif
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="p_one_night-{!! $season->n_season !!}" @if(isset($season->p_one_night)&&$season->p_one_night) value="{!! $season->p_one_night !!}"" @endif />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="p_weekend_night-{!! $season->n_season !!}" @if(isset($season->p_weekend_night)&&$season->p_weekend_night) value="{!! $season->p_weekend_night !!}" @endif />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="p_one_week-{!! $season->n_season !!}" @if(isset($season->p_one_week)&&$season->p_one_week) value="{!! $season->p_one_week !!}" @endif />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="p_half_month-{!! $season->n_season !!}" @if(isset($season->p_half_month)&&$season->p_half_month) value="{!! $season->p_half_month !!}" @endif />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="p_one_month-{!! $season->n_season !!}" @if(isset($season->p_one_month)&&$season->p_one_month) value="{!! $season->p_one_month !!}" @endif />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="p_extra_guest_per_night-{!! $season->n_season !!}" @if(isset($season->p_extra_guest_per_night)&&$season->p_extra_guest_per_night) value="{!! $season->p_extra_guest_per_night !!}" @endif />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control" name="n_min_nights-{!! $season->n_season !!}" @if(isset($season->n_min_nights)&&$season->n_min_nights) value="{!! $season->n_min_nights !!}" @endif />
                                                                        </div>
                                                                    </td>
                                                                    @if($season->n_season == '1')
                                                                    <td>
                                                                        &nbsp;
                                                                    </td>
                                                                    @else
                                                                    <td>
                                                                        <a href="javascript:" class="btn btn-danger btn-delete-season"><i class="fa fa-times"></i></a>
                                                                    </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @else
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
                                                        @endif
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
                                                            <input type="radio" name="has_booking" value="0" data-title="No requerida" @if(isset($ad->has_booking)&&$ad->has_booking=='0') checked="checked" @endif />
                                                            No requerida </label>
                                                        <label>
                                                            <input type="radio" name="has_booking" value="1" data-title="En porcentaje:" @if(isset($ad->has_booking)&&$ad->has_booking=='1') checked="checked" @endif />
                                                            En porcentaje:
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="booking-percentage" @if(!isset($ad->has_booking)||(isset($ad->has_booking)&&!$ad->has_booking=='1')) disabled="disabled" @elseif(isset($ad->has_booking)&&$ad->has_booking=='1'&&isset($ad->booking)&&$ad->booking) value="{!! $ad->booking !!}" @endif />
                                                                <span class="input-group-addon">%</span>
                                                            </div></label>
                                                        <label>
                                                            <input type="radio" name="has_booking" value="2" data-title="En euros:" @if(isset($ad->has_booking)&&$ad->has_booking=='2') checked="checked" @endif />
                                                            En euros: </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="booking-euros" @if(!isset($ad->has_booking)||(isset($ad->has_booking)&&!$ad->has_booking=='2')) disabled="disabled" @elseif(isset($ad->has_booking)&&$ad->has_booking=='2'&&isset($ad->booking)&&$ad->booking) value="{!! $ad->booking !!}" @endif />
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
                                                        <option value="1" @if(isset($ad->payment_day_id)&&$ad->payment_day_id=='1') selected="selected" @endif >A la entrega de llaves</option>
                                                        <option value="2" @if(isset($ad->payment_day_id)&&$ad->payment_day_id=='2') selected="selected" @endif >Días antes de la entrada</option>
                                                        <option value="3" @if(isset($ad->payment_day_id)&&$ad->payment_day_id=='3') selected="selected" @endif >El día de entrada</option>
                                                        <option value="4" @if(isset($ad->payment_day_id)&&$ad->payment_day_id=='4') selected="selected" @endif >El día de salida</option>
                                                    </select>
                                                    <label class="control-label">Número de días antes: </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="n_days_before" disabled="disabled" @if(isset($ad->n_days_before)&&$ad->n_days_before) value="{!! $ad->n_days_before !!}" @endif />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Fianza
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="radio-list">
                                                        <label>
                                                            <input type="radio" name="has_deposit" value="0" data-title="No requerida" @if(isset($ad->has_deposit)&&$ad->has_deposit=='0') checked="checked" @endif />
                                                            No requerida </label>
                                                        <label>
                                                            <input type="radio" name="has_deposit" value="1" data-title="En porcentaje:" @if(isset($ad->has_deposit)&&$ad->has_deposit=='1') checked="checked" @endif />
                                                            En porcentaje:
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="deposit-percentage" @if(!isset($ad->has_deposit)||(isset($ad->has_deposit)&&!$ad->has_deposit=='1')) disabled="disabled" @elseif(isset($ad->has_deposit)&&$ad->has_deposit=='1'&&isset($ad->booking)&&$ad->booking) value="{!! $ad->booking !!}" @endif />
                                                                <span class="input-group-addon">%</span>
                                                            </div></label>
                                                        <label>
                                                            <input type="radio" name="has_deposit" value="2" data-title="En euros:" @if(isset($ad->has_deposit)&&$ad->has_deposit=='2') checked="checked" @endif />
                                                            En euros: </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="deposit-euros" @if(!isset($ad->has_deposit)||(isset($ad->has_deposit)&&!$ad->has_deposit=='2')) disabled="disabled" @elseif(isset($ad->has_deposit)&&$ad->has_deposit=='2'&&isset($ad->booking)&&$ad->booking) value="{!! $ad->booking !!}" @endif />
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
                                                            <input type="radio" name="has_cleaning" value="0" data-title="Incluida en el precio" @if(isset($ad->has_cleaning)&&$ad->has_cleaning) checked="checked" @endif />
                                                            Incluida en el precio </label>
                                                        <label>
                                                            <input type="radio" name="has_cleaning" value="1" data-title="No incluida. En euros:" @if(isset($ad->has_cleaning)&&!$ad->has_cleaning) checked="checked" @endif />
                                                            No incluida. En euros: </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="cleaning" @if(!isset($ad->has_cleaning)||(isset($ad->has_cleaning)&&$ad->has_cleaning)) disabled="disabled" @elseif(isset($ad->has_cleaning)&&!$ad->has_cleaning&&isset($ad->cleaning)&&$ad->cleaning) value="{!! $ad->cleaning !!}" @endif />
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
                                                            <input type="radio" name="has_included_towels" value="1" data-title="Incluidas en el precio" @if(isset($ad->has_included_towels)&&$ad->has_included_towels) checked="checked" @endif />
                                                            Incluidas en el precio </label>
                                                        <label>
                                                            <input type="radio" name="has_included_towels" value="0" data-title="No incluidas" @if(isset($ad->has_included_towels)&&!$ad->has_included_towels) checked="checked" @endif />
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
                                                            <input type="radio" name="has_included_expenses" value="1" data-title="Incluidos en el precio" @if(isset($ad->has_included_expenses)&&$ad->has_included_expenses) checked="checked" @endif />
                                                            Incluidos en el precio </label>
                                                        <label>
                                                            <input type="radio" name="has_included_expenses" value="0" data-title="No incluidas" @if(isset($ad->has_included_expenses)&&!$ad->has_included_expenses) checked="checked" @endif />
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
                                                                <input type="text" class="form-control" name="distance_to_beach" @if(isset($ad->distance_to_beach)&&$ad->distance_to_beach) value="{!! $ad->distance_to_beach !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al centro</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_town_center" @if(isset($ad->distance_to_town_center)&&$ad->distance_to_town_center) value="{!! $ad->distance_to_town_center !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A estanción de esquí</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_ski_area" @if(isset($ad->distance_to_ski_area)&&$ad->distance_to_ski_area) value="{!! $ad->distance_to_ski_area !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Al supermercado</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_supermarket" @if(isset($ad->distance_to_supermarket)&&$ad->distance_to_supermarket) value="{!! $ad->distance_to_supermarket !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al aeropuerto</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_airport" @if(isset($ad->distance_to_airport)&&$ad->distance_to_airport) value="{!! $ad->distance_to_airport !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al campo de golf</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_golf_course" @if(isset($ad->distance_to_golf_course)&&$ad->distance_to_golf_course) value="{!! $ad->distance_to_golf_course !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div><div class="row">
                                                        <div class="col-md-4">
                                                            <label>Al río o lago</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_river_or_lake" @if(isset($ad->distance_to_river_or_lake)&&$ad->distance_to_river_or_lake) value="{!! $ad->distance_to_river_or_lake !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al puerto deportivo</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_marina" @if(isset($ad->distance_to_marina)&&$ad->distance_to_marina) value="{!! $ad->distance_to_marina !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Al centro ecuestre</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_horse_riding_area" @if(isset($ad->distance_to_horse_riding_area)&&$ad->distance_to_horse_riding_area) value="{!! $ad->distance_to_horse_riding_area !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>A la estación de tren</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_train_station" @if(isset($ad->distance_to_train_station)&&$ad->distance_to_train_station) value="{!! $ad->distance_to_train_station !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A la estación de autobuses</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_bus_station" @if(isset($ad->distance_to_bus_station)&&$ad->distance_to_bus_station) value="{!! $ad->distance_to_bus_station !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A escuela de submarinismo</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_scuba_diving_area" @if(isset($ad->distance_to_scuba_diving_area)&&$ad->distance_to_scuba_diving_area) value="{!! $ad->distance_to_scuba_diving_area !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Al hospital</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_hospital" @if(isset($ad->distance_to_hospital)&&$ad->distance_to_hospital) value="{!! $ad->distance_to_hospital !!}" @endif />
                                                                <span class="input-group-addon">metros</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>A rutas de senderismo</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="distance_to_hiking_area" @if(isset($ad->distance_to_hiking_area)&&$ad->distance_to_hiking_area) value="{!! $ad->distance_to_hiking_area !!}" @endif />
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
                                                                <input type="text" class="form-control" name="n_double_bedroom" @if(isset($ad->n_double_bedroom)&&$ad->n_double_bedroom) value="{!! $ad->n_double_bedroom !!}" @endif />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Con dos camas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_two_beds_room" @if(isset($ad->n_two_beds_room)&&$ad->n_two_beds_room) value="{!! $ad->n_two_beds_room !!}" @endif />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Con una cama</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_single_bed_room" @if(isset($ad->n_single_bed_room)&&$ad->n_single_bed_room) value="{!! $ad->n_single_bed_room !!}" @endif />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Con tres camas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_three_beds_room" @if(isset($ad->n_three_beds_room)&&$ad->n_three_beds_room) value="{!! $ad->n_three_beds_room !!}" @endif />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Con cuatro camas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_four_beds_room" @if(isset($ad->n_four_beds_room)&&$ad->n_four_beds_room) value="{!! $ad->n_four_beds_room !!}" @endif />
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
                                                                <input type="text" class="form-control" name="n_sofa_bed" @if(isset($ad->n_sofa_bed)&&$ad->n_sofa_bed) value="{!! $ad->n_sofa_bed !!}" @endif />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Sofá cama (tama&ntilde;o matrimonio)</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_double_sofa_bed" @if(isset($ad->n_double_sofa_bed)&&$ad->n_double_sofa_bed) value="{!! $ad->n_double_sofa_bed !!}" @endif />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Cama auxiliar (tama&ntilde;o individual)</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="n_extra_bed" @if(isset($ad->n_extra_bed)&&$ad->n_extra_bed) value="{!! $ad->n_extra_bed !!}" @endif />
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
                                                        <input type="text" class="form-control" name="min_capacity" @if(isset($ad->min_capacity)&&$ad->min_capacity) value="{!! $ad->min_capacity !!}" @endif />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Capacidad máxima (personas)
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_capacity" @if(isset($ad->max_capacity)&&$ad->max_capacity) value="{!! $ad->max_capacity !!}" @endif />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Formas de pago aceptadas
                                                </label>
                                                <div class="col-md-4" style="padding-top:5px;">
                                                    <div class="checkbox-list">
                                                        <label>
                                                            <input type="checkbox" name="accepts_cash" value="1" data-title="En efectivo" @if(isset($ad->accepts_cash)&&$ad->accepts_cash) checked="checked" @endif /> En efectivo</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_transfer" value="1" data-title="Transferencia bancaria" @if(isset($ad->accepts_transfer)&&$ad->accepts_transfer) checked="checked" @endif /> Transferencia bancaria</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_credit_card" value="1" data-title="Tarjeta de crédito" @if(isset($ad->accepts_credit_card)&&$ad->accepts_credit_card) checked="checked" @endif /> Tarjeta de crédito</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_paypal" value="1" data-title="Paypal" @if(isset($ad->accepts_paypal)&&$ad->accepts_paypal) checked="checked" @endif /> Paypal</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_check" value="1" data-title="Cheque" @if(isset($ad->accepts_check)&&$ad->accepts_check) checked="checked" @endif /> Cheque</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_western_union" value="1" data-title="Western Union" @if(isset($ad->accepts_western_union)&&$ad->accepts_western_union) checked="checked" @endif /> Western Union</label>
                                                        <label>
                                                            <input type="checkbox" name="accepts_money_gram" value="1" data-title="Money Gram" @if(isset($ad->accepts_money_gram)&&$ad->accepts_money_gram) checked="checked" @endif /> Money Gram</label>
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
                                                                    <input type="checkbox" name="has_private_garden" value="1" data-title="Jardín individual" @if(isset($ad->has_private_garden)&&$ad->has_private_garden) checked="checked" @endif /> Jardín individual</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_shared_garden" value="1" data-title="Jardín compartido" @if(isset($ad->has_shared_garden)&&$ad->has_shared_garden) checked="checked" @endif /> Jardín compartido</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_furnished_garden" value="1" data-title="Muebles de jardín" @if(isset($ad->has_furnished_garden)&&$ad->has_furnished_garden) checked="checked" @endif /> Muebles de jardín</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_barbecue" value="1" data-title="Barbacoa" @if(isset($ad->has_barbecue)&&$ad->has_barbecue) checked="checked" @endif /> Barbacoa</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_parking_space" value="1" data-title="Aparcamiento" @if(isset($ad->has_parking_space)&&$ad->has_parking_space) checked="checked" @endif /> Aparcamiento</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_playground" value="1" data-title="Parque infantil" @if(isset($ad->has_playground)&&$ad->has_playground) checked="checked" @endif /> Parque infantil</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_terrace" value="1" data-title="Terraza" @if(isset($ad->has_terrace)&&$ad->has_terrace) checked="checked" @endif /> Terraza</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_sea_sights" value="1" data-title="Vistas al mar" @if(isset($ad->has_sea_sights)&&$ad->has_sea_sights) checked="checked" @endif /> Vistas al mar</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_mountain_sights" value="1" data-title="Vistas a la monta&ntilde;a" @if(isset($ad->has_mountain_sights)&&$ad->has_mountain_sights) checked="checked" @endif /> Vistas a la monta&ntilde;a</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_private_swimming_pool" value="1" data-title="Piscina individual" @if(isset($ad->has_private_swimming_pool)&&$ad->has_private_swimming_pool) checked="checked" @endif /> Piscina individual</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_shared_swimming_pool" value="1" data-title="Piscina compartida" @if(isset($ad->has_shared_swimming_pool)&&$ad->has_shared_swimming_pool) checked="checked" @endif /> Piscina compartida</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_indoor_swimming_pool" value="1" data-title="Piscina cubierta" @if(isset($ad->has_indoor_swimming_pool)&&$ad->has_indoor_swimming_pool) checked="checked" @endif /> Piscina cubierta</label>
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
                                                                    <input type="checkbox" name="has_tv" value="1" data-title="TV" @if(isset($ad->has_tv)&&$ad->has_tv) checked="checked" @endif /> TV</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_cable_tv" value="1" data-title="TV por cable/satélite" @if(isset($ad->has_cable_tv)&&$ad->has_cable_tv) checked="checked" @endif /> TV por cable/satélite</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_internet" value="1" data-title="Internet/wifi" @if(isset($ad->has_internet)&&$ad->has_internet) checked="checked" @endif /> Internet/wifi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_jacuzzi" value="1" data-title="Jacuzzi" @if(isset($ad->has_jacuzzi)&&$ad->has_jacuzzi) checked="checked" @endif /> Jacuzzi</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_fireplace" value="1" data-title="Chimenea" @if(isset($ad->has_fireplace)&&$ad->has_fireplace) checked="checked" @endif /> Chimenea</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_cradle" value="1" data-title="Cuna" @if(isset($ad->has_cradle)&&$ad->has_cradle) checked="checked" @endif /> Cuna</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_fan" value="1" data-title="Ventilador" @if(isset($ad->has_fan)&&$ad->has_fan) checked="checked" @endif /> Ventilador</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_heating" value="1" data-title="Calefacción" @if(isset($ad->has_heating)&&$ad->has_heating) checked="checked" @endif /> Calefacción</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado" @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) checked="checked" @endif /> Aire acondicionado</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_hairdryer" value="1" data-title="Secador de pelo" @if(isset($ad->has_hairdryer)&&$ad->has_hairdryer) checked="checked" @endif /> Secador de pelo</label>
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
                                                                    <input type="checkbox" name="has_dishwasher" value="1" data-title="Lavavajillas" @if(isset($ad->has_dishwasher)&&$ad->has_dishwasher) checked="checked" @endif /> Lavavajillas</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_dryer" value="1" data-title="Secadora" @if(isset($ad->has_dryer)&&$ad->has_dryer) checked="checked" @endif /> Secadora</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_fridge" value="1" data-title="Nevera" @if(isset($ad->has_fridge)&&$ad->has_fridge) checked="checked" @endif /> Nevera</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_washer" value="1" data-title="Lavadora" @if(isset($ad->has_washer)&&$ad->has_washer) checked="checked" @endif /> Lavadora</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_oven" value="1" data-title="Horno" @if(isset($ad->has_oven)&&$ad->has_oven) checked="checked" @endif /> Horno</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_iron" value="1" data-title="Plancha" @if(isset($ad->has_iron)&&$ad->has_iron) checked="checked" @endif /> Plancha</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_microwave" value="1" data-title="Microondas" @if(isset($ad->has_microwave)&&$ad->has_microwave) checked="checked" @endif /> Microondas</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_coffee_maker" value="1" data-title="Cafetera" @if(isset($ad->has_coffee_maker)&&$ad->has_coffee_maker) checked="checked" @endif /> Cafetera</label>
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
                                                                    <input type="checkbox" name="is_out_town_center" value="1" data-title="Fuera del casco urbano" @if(isset($ad->is_out_town_center)&&$ad->is_out_town_center) checked="checked" @endif /> Fuera del casco urbano</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_gayfriendly_area" value="1" data-title="Ambiente gay-friendly" @if(isset($ad->is_gayfriendly_area)&&$ad->is_gayfriendly_area) checked="checked" @endif /> Ambiente gay-friendly</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_isolated" value="1" data-title="Aislado" @if(isset($ad->is_isolated)&&$ad->is_isolated) checked="checked" @endif /> Aislado</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_family_tourism_area" value="1" data-title="Turismo familiar" @if(isset($ad->is_family_tourism_area)&&$ad->is_family_tourism_area) checked="checked" @endif /> Turismo familiar</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_bar_area" value="1" data-title="Zona de bares" @if(isset($ad->is_bar_area)&&$ad->is_bar_area) checked="checked" @endif /> Zona de bares</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_luxury_area" value="1" data-title="Alojamiento de lujo" @if(isset($ad->is_luxury_area)&&$ad->is_luxury_area) checked="checked" @endif /> Alojamiento de lujo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_nudist_area" value="1" data-title="Turismo nudista" @if(isset($ad->is_nudist_area)&&$ad->is_nudist_area) checked="checked" @endif /> Turismo nudista</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="is_charming" value="1" data-title="Alojamiento con encanto" @if(isset($ad->is_charming)&&$ad->is_charming) checked="checked" @endif /> Alojamiento con encanto</label>
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
                                                                    <input type="checkbox" name="has_bicycle_rental" value="1" data-title="Alquiler de bicicleta" @if(isset($ad->has_bicycle_rental)&&$ad->has_bicycle_rental) checked="checked" @endif /> Alquiler de bicicleta</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_car_rental" value="1" data-title="Alquiler de coche" @if(isset($ad->has_car_rental)&&$ad->has_car_rental) checked="checked" @endif /> Alquiler de coche</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_adventure_activities" value="1" data-title="Actividades multi-aventura" @if(isset($ad->has_adventure_activities)&&$ad->has_adventure_activities) checked="checked" @endif /> Actividades multi-aventura</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_tennis_court" value="1" data-title="Pistas de tenis" @if(isset($ad->has_tennis_court)&&$ad->has_tennis_court) checked="checked" @endif /> Pistas de tenis</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_kindergarten" value="1" data-title="Guardería" @if(isset($ad->has_kindergarten)&&$ad->has_kindergarten) checked="checked" @endif /> Guardería</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_paddle_court" value="1" data-title="Pistas de pádel" @if(isset($ad->has_paddle_court)&&$ad->has_paddle_court) checked="checked" @endif /> Pistas de pádel</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_sauna" value="1" data-title="Sauna" @if(isset($ad->has_sauna)&&$ad->has_sauna) checked="checked" @endif /> Sauna</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="checkbox-list">
                                                                <label>
                                                                    <input type="checkbox" name="has_gym" value="1" data-title="Gimnasio" @if(isset($ad->has_gym)&&$ad->has_gym) checked="checked" @endif /> Gimnasio</label>
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
                                                            <input type="checkbox" name="is_handicapped_adapted" value="1" data-title="Adaptado para discapacitados" @if(isset($ad->is_handicapped_adapted)&&$ad->is_handicapped_adapted) checked="checked" @endif /> Adaptado para discapacitados</label>
                                                        <label>
                                                            <input type="checkbox" name="is_car_recommended" value="1" data-title="Recomendable disponer de coche" @if(isset($ad->is_car_recommended)&&$ad->is_car_recommended) checked="checked" @endif /> Recomendable disponer de coche</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Descripción y otros detalles</label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" rows="4" name="description">@if(isset($ad->description)&&$ad->description) {!! $ad->description !!} @endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        {{--END STEP 2--}}
                                        <div id="uploaded_images" class="hidden">
                                        @if(isset($Ad)&&\App\AdPic::where('ad_id',$Ad->id)->count())
                                            @foreach(\App\AdPic::where('ad_id',$Ad->id)->get() as $pic)
                                                <input type="hidden" name="pictures_{!! $pic->filename !!}" value="{!! $pic->filename !!}"/>
                                            @endforeach
                                        @endif
                                        </div>

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
                                                        @if(isset($Ad)&&\App\AdPic::where('ad_id',$Ad->id)->count())
                                                            @foreach(\App\AdPic::where('ad_id',$Ad->id)->get() as $pic)
                                                            <tr>
                                                                <td>
                                                                    @if(substr($pic->filename, 0, 4) === 'http')
                                                                        <img width="100" src="{!! $pic->filename !!}">
                                                                    @else
                                                                        <img width="100" src="/ads/thumbnails/thumb_{!! $pic->filename !!}">
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {!! $pic->filename !!}
                                                                </td>
                                                                <td>
                                                                    @if(substr($pic->filename, 0, 4) === 'http')
                                                                    640 x 480
                                                                    @else
                                                                    <?php list($pic_width, $pic_height) = getimagesize('ads/pictures/'.$pic->filename); ?>
                                                                    {{ $pic_width }} x {{ $pic_height }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(substr($pic->filename, 0, 4) === 'http')
                                                                        {{ mt_rand(150,400) }} kB
                                                                    @else
                                                                        {{ (int) (filesize('ads/pictures/'.$pic->filename) * 0.001) }} kB
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    {!! $pic->created_at !!}
                                                                </td>
                                                                <td>
                                                                    <span class="btn btn-sm red btn-delete-image"><i class="fa fa-times"></i> Eliminar</span>
                                                                </td>
                                                            </tr>    
                                                            @endforeach
                                                        @endif
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
