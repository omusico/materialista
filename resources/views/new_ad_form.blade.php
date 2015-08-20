@extends('layout')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/uniform.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}">
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
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="portlet" id="form_wizard_1">
                    {{-- FORM --}}
                    <div class="portlet-body form">
                        <form action="#" class="form-horizontal" id="submit_form" method="POST">
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
                                                            <input type="radio" name="operation" value="0" data-title="Venta" @if($operation=='0') checked="checked" @endif />
                                                            Venta </label>
                                                        <label>
                                                            <input type="radio" name="operation" value="1" data-title="Alquiler" @if($operation=='1') checked="checked" @endif />
                                                            Alquiler </label>
                                                    </div>
                                                    <div id="form_operation_error"></div>
                                                </div>
                                            </div>

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

                                            @if($operation=='0'&&$typology!='6')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Gastos de comunidad
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="comunidad"/>
                                                        <span class="input-group-addon">&euro;/mes</span>
                                                    </div>
                                                    <div id="form_comunidad_error">
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
                                                    <select name="tipo" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="0">Sin fianza</option>
                                                        <option value="1">1 mes</option>
                                                        <option value="2">2 meses</option>
                                                        <option value="3">3 meses</option>
                                                        <option value="4">4 meses</option>
                                                        <option value="5">5 meses</option>
                                                        <option value="6">6 meses o m&aacute;s</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @endif

                                            @if($typology=='0'||$typology=='1'||$typology=='2')
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Detalles de la propiedad
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
                                                    <input type="text" class="form-control" name="municipio"/>
                                                    <label class="control-label">Nombre de la v&iacute;a</label>
                                                    <input type="text" class="form-control" name="via"/>
                                                    <label class="control-label">N&uacute;mero de la v&iacute;a @if($typology=='6') o Km @endif</label>
                                                    <input type="text" class="form-control" name="n_via"/>
                                                    <input type="hidden" class="form-control" name="address_confirmed" value="no"/>
                                                    <input type="hidden" class="form-control" name="lat" value=""/>
                                                    <input type="hidden" class="form-control" name="lng" value=""/>
                                                    <input type="hidden" class="form-control" name="formated_address" value=""/>
                                                    <input type="hidden" class="form-control" name="street_number" value=""/>
                                                    <input type="hidden" class="form-control" name="route" value=""/>
                                                    <input type="hidden" class="form-control" name="locality" value=""/>
                                                    <input type="hidden" class="form-control" name="administrative_area_level_2" value=""/>
                                                    <input type="hidden" class="form-control" name="administrative_area_level_1" value=""/>
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
                                                            <input type="checkbox" name="ocultar_direccion" value="yes" data-title="Ocultar direcci&oacute;n"/> Ocultar direcci&oacute;n</label>
                                                    </div>
                                                    <div id="form_ocultar_direccion_error">
                                                    </div>
                                                </div>
                                            </div>

                                            @if($typology=='0'||$typology=='3'||$typology=='4'||$typology=='7'||$typology=='8')
                                            <div class="form-group" id="planta">
                                                <label class="control-label col-md-3">Planta
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="planta" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="minus2">Por debajo de la planta baja (-2)</option>
                                                        <option value="minus1">Por debajo de la planta baja (-1)</option>
                                                        <option value="sotano">S&oacute;tano</option>
                                                        <option value="semi-sotano">Semi-s&oacute;tano</option>
                                                        <option value="bajo">Bajo</option>
                                                        <option value="entreplanta">Entreplanta</option>
                                                    @for($i = 1; $i < 101; ++$i)
                                                        <option value="{{ $i }}">Planta {{ $i }}&ordm;</option>
                                                    @endfor
                                                    </select>
                                                    @if($typology!='3'&&$typology!='4')
                                                    <div class="checkbox-list" style="padding-top:4px;">
                                                        <label>
                                                            <input type="checkbox" name="ultima_planta" value="yes" data-title="Es la &uacute;ltima planta del bloque"/>Es la &uacute;ltima planta del bloque</label>
                                                    </div>
                                                    @endif
                                                    <div id="form_ocultar_direccion_error">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="puerta">
                                                <label class="control-label col-md-3">Puerta
                                                </label>
                                                <div class="col-md-4">
                                                    <select name="puerta" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="letra">Letra (A, B, C...)</option>
                                                        <option value="numero">N&uacute;mero (1, 2, 3...)</option>
                                                        <option value="unica">Puerta &uacute;nica</option>
                                                        <option value="izq">Izquierda</option>
                                                        <option value="der">Derecha</option>
                                                        <option value="ext">Exterior</option>
                                                        <option value="ext-izq">Exterior izquierda</option>
                                                        <option value="ext-der">Exterior derecha</option>
                                                        <option value="int">Interior</option>
                                                        <option value="int-izq">Interior izquierda</option>
                                                        <option value="int-der">Interior derecha</option>
                                                        <option value="cen">Centro</option>
                                                        <option value="cen-izq">Centro izquierda</option>
                                                        <option value="cen-der">Centro derecha</option>
                                                    </select>
                                                    <select id="n_puerta" name="n_puerta" class="form-control hidden" style="padding-top:5px;">
                                                        <option value="">Seleccione</option>
                                                    @for($i = 1; $i < 101; ++$i)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                    </select>
                                                    <select name="l_puerta" class="form-control hidden" style="padding-top:5px;">
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
                                                            <input type="radio" name="bloques" value="no" data-title="No"/>
                                                            No </label>
                                                        <label>
                                                            <input type="radio" name="bloques" value="yes" data-title="S&iacute;, bloque/portal:"/>
                                                            S&iacute;, bloque/portal: </label>
                                                            <input type="text" class="form-control" name="bloque" disabled=""/>
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
                                                        <input type="text" class="form-control" name="urbanizacion" />
                                                    </div>
                                                    <div id="form_urbanizacion_error">
                                                    </div>
                                                    <span class="help-block"></span>
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
                                                            <input type="radio" name="category_room_id" value="piso" data-title=""/>
                                                            Piso compartido </label>
                                                        <label>
                                                            <input type="radio" name="category_room_id" value="chalet" data-title=""/>
                                                            Chalet compartido </label>
                                                    </div>
                                                    <div id="form_category_room_id_error">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">M&sup2; de la habitación <span class="required">* </span>
                                                </label>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area_room" />
                                                        <span class="input-group-addon">m&sup2;</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Total de personas (incluyendo nuevo inquilino)
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

                                            @if($typology=='0'||$typology=='1'||$typology=='2'||$typology=='3'||$typology=='4'||$typology=='8')
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
                                                            <input type="radio" name="is_exterior" value="0" data-title="Exterior"/>
                                                            Exterior </label>
                                                        <label>
                                                            <input type="radio" name="is_exterior" value="1" data-title="Interior"/>
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
                                                            <input type="radio" name="has_offices_only" value="0" data-title="S&iacute;"/>
                                                            S&iacute; </label>
                                                        <label>
                                                            <input type="radio" name="has_offices_only" value="1" data-title="No"/>
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
                                                            <input type="radio" name="currrent_tenants_gender_id" value="1" data-title="Chico(s) y chica(s)"/>
                                                            Chico(s) y chica(s) </label>
                                                        <label>
                                                            <input type="radio" name="currrent_tenants_gender_id" value="2" data-title="S&oacute;lo chico(s)"/>
                                                            S&oacute;lo chico(s) </label>
                                                        <label>
                                                            <input type="radio" name="currrent_tenants_gender_id" value="3" data-title="S&oacute;lo chica(s)"/>
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
                                                            <input type="checkbox" name="face_south" value="1" data-title="Sur"/> Sur</label>
                                                        <label>
                                                            <input type="checkbox" name="face_east" value="1" data-title="Este"/> Este</label>
                                                        <label>
                                                            <input type="checkbox" name="face_west" value="1" data-title="Oeste"/> Oeste</label>
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
                                                    <div class="col-md-4" style="padding-top:5px;">
                                                        <div class="checkbox-list">
                                                            <label>
                                                                <input type="checkbox" name="has_air_conditioning" value="1" data-title="Aire acondicionado"/> Aire acondicionado</label>
                                                            <label>
                                                                <input type="checkbox" name="has_air_conditioning_pre-installation" value="1" data-title="Preinstalación de aire acondicionado"/> Preinstalación de aire acondicionado</label>
                                                            <label>
                                                                <input type="checkbox" name="has_heating" value="1" data-title="Calefacción"/> Calefacción</label>
                                                            <label>
                                                                <input type="checkbox" name="has_hot_water" value="1" data-title="Agua caliente"/> Agua caliente</label>
                                                        </div>
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
                                                            <input type="checkbox" name="is_handicapped_adapted" value="yes" data-title="Adaptado a personas con movilidad reducida"/> Adaptado a personas con movilidad reducida</label>
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
                                                            <input type="checkbox" name="has_automic_door" value="1" data-title="Puerta automática"/> Puerta automática</label>
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

                                            <div class="form-group">
                                                <label class="control-label col-md-3">Descripción y otros detalles</label>
                                                <div class="col-md-4">
                                                    <textarea class="form-control" rows="4" name="remarks"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        {{--END STEP 2--}}

                                        {{--STEP 3--}}
                                        <div class="tab-pane" id="tab3">

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
                                                <a href="javascript:" class="btn green button-submit">
                                                    Enviar <i class="m-icon-swapright m-icon-white"></i>
                                                </a>
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
    <script type="text/javascript" src="{{ asset('js/metronic.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/messages_es.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.bootstrap.wizard.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2_locale_es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            Metronic.init(); // init metronic core components >> uniform checkboxes

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

            $('#check-address').click(function(){
                var address = $('input[name=via]').val() + ', ' + $('input[name=n_via]').val() + ', ' + $('input[name=municipio]').val();
                $('#check-in-progress').removeClass('hidden');
                $('[id^="check-address-"]').addClass('hidden');
                $.get('/admin/nuevo-anuncio/check-address', {
                    address: address
                }, function(data){
                    $('#check-in-progress').addClass('hidden');
                    $('#check-address').addClass('hidden');
                    $('.formated-address').text(data['formatted_address']);
                    $('input[name=municipio]').prop('disabled',true);
                    $('input[name=via]').prop('disabled',true);
                    $('input[name=n_via]').prop('disabled',true);
                    $('input[name=lat]').val(data['lat']);
                    $('input[name=lng]').val(data['lng']);
                    $('input[name=formated_address]').val(data['formatted_address']);
                    $('input[name=street_number]').val(data['address_components'][0]['long_name']);
                    $('input[name=route]').val(data['address_components'][1]['long_name']);
                    $('input[name=locality]').val(data['address_components'][2]['long_name']);
                    $('input[name=administrative_area_level_2]').val(data['address_components'][3]['long_name']); //Provincia
                    $('input[name=administrative_area_level_1]').val(data['address_components'][4]['long_name']); //Comunidad aut�noma
                    $('input[name=country]').val(data['address_components'][5]['long_name']);
                    $('input[name=postal_code]').val(data['address_components'][6]['long_name']);
                    $('#check-address-warning').removeClass('hidden');
                }).fail(function() {
                    $('#check-in-progress').addClass('hidden');
                    $('#check-address-danger').removeClass('hidden');
                });
            });

            $('#confirm-address').click(function(){
                $('input[name=address_confirmed]').val('yes');
                $('#check-address-warning').addClass('hidden');
                $('#check-address-success').removeClass('hidden');
            });

            $('#cancel-address').click(function(){
                $('input[name=municipio]').prop('disabled',false);
                $('input[name=via]').prop('disabled',false);
                $('input[name=n_via]').prop('disabled',false);
                $('#check-address').removeClass('hidden');
                $('#check-address-warning').addClass('hidden');
            });

            $('#change-address').click(function(){
                $('input[name=municipio]').prop('disabled',false);
                $('input[name=via]').prop('disabled',false);
                $('input[name=n_via]').prop('disabled',false);
                $('input[name=address_confirmed]').val('no');
                $('#check-address').removeClass('hidden');
                $('#check-address-success').addClass('hidden');
            });

            function format(state) {
                return state.text;
//                if (!state.id) return state.text; // optgroup
//                return "<img class='flag' src='img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }

            $("select").select2({
                placeholder: "Select",
                allowClear: true,
                escapeMarkup: function (m) {
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
                    // datos b�sicos
                    tipo: { required: true },
                    operacion: { required: true },
                    precio: { digits: true, required: true },
                    comunidad: { digits: true },
                    fianza: { digits: true },
                    // detalles
                    fullname: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                        // equalTo: "#submit_form_password"
                    },
                    phone: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    //payment
                    card_name: {
                        required: true
                    },
                    card_number: {
                        minlength: 16,
                        maxlength: 16,
                        required: true
                    },
                    card_cvc: {
                        digits: true,
                        required: true,
                        minlength: 3,
                        maxlength: 4
                    },
                    card_expiry_date: {
                        required: true
                    },
                    'payment[]': {
                        required: true,
                        minlength: 1
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    'payment[]': {
                        required: "Elija una opci�n",
                        minlength: jQuery.validator.format("Elija una opci�n")
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
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

                invalidHandler: function (event, validator) { //display error alert on form submit
                    success.hide();
                    error.show();
                    Metronic.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label.closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label.addClass('valid') // mark the current input as valid and display OK icon
                            .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
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
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false; // navigation on nav pills click disabled
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    formWizard.find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            formWizard.find('.button-previous').hide();
            formWizard.find('.button-submit').click(function () {
                alert('Ha finalizado!');
            }).hide();

            $("input[name=n_personas]").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0
            });

            $("input[name=n_habitaciones]").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0
            });

            $("input[name=n_banos]").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0
            });

            $("input[name=n_plantas]").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0
            });

        });
    </script>
@endsection
