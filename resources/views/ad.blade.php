@extends('layout')

@section('css')
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <style>
        h2 {
            font-weight: bold;
            font-size: 24px;
        }
        h4 {
            font-weight: bold;
            font-size: 16px;
        }
        #ad-details > h4 {
            margin: 50px 0 15px;
        }
        #ad-details > p {
            margin-bottom: 4px;
        }
        #main-container {
            padding-top: 15px;
        }
        #ad-main-details > span {
            font-size: 16px;
            margin-left:35px;
        }
        #ad-main-details > span:first-of-type {
            margin-left:0;
        }
        #ad-main-details > span.price {
            font-weight: bold;
        }
        #ad-main-details > small {
            font-size: 13px;
        }
        #ad-pictures {
            padding-top:15px;
        }
        .ad-pic {
            margin: 5px 0 5px 0;
        }
        @media (min-width:992px) {
            .coupled-pic-1 {
                padding-right: 5px;
            }
            .coupled-pic-2 {
                padding-left: 5px;
            }
        }
        .well {
            padding: 15px;
            border-radius: 0;
        }
        .form-group {
            margin-bottom: 5px;
        }
        .form-control, .btn {
            border-radius: 0;
        }
        #ad-details {
            padding-bottom: 150px;
        }
        #ad-pictures > div > div > img {
            background-color: #F2F2F2;
        }
    </style>
@endsection

@section('content')
    <label><input class="hidden" name="_token" value="{{ Session::token() }}"></label>

    {{--Title full row--}}
    <div class="container">
        <div class="row">
            <div class="col-xs-12" id="ad-title">
                <h2>{{ $ad->type }} @if($operation==0) en venta @elseif($operation==1) en alquiler @endif en @if(!$ad->hide_address) @if(isset($ad->route)) {{ $ad->route }}, @endif @if(isset($ad->street_number)) {{ $ad->street_number }}, @endif @endif {{ $ad->locality }}</h2>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row" id="main-container">

            {{--Details column--}}
            <div class="col-xs-12 col-sm-12 col-md-8" id="info-container">

                {{--Main details row--}}
                <div class="row">
                    <div class="col-xs-12" id="ad-main-details">
                        {{--Price--}}
                        @if($typology==8)
                            <small>Desde</small> <span class="price">{{ number_format((float) $ad->min_price_per_night,0,',','.') }}</span> <small>&euro;/noche/persona</small>
                        @else
                            <span class="price">{{ number_format((float) $ad->price,0,',','.') }}</span> <small> @if($operation==0) &euro; @else &euro;/mes @endif </small>
                        @endif
                        {{--Other typology specific details--}}
                        <?php if($operation==0) $decimales = 0; else $decimales = 2; ?>
                        @if($typology==0)
                            <span>{{ $ad->n_bedrooms }}</span> <small>habs.</small>
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                        @elseif($typology==1)
                            <span>{{ $ad->n_bedrooms }}</span> <small>habs.</small>
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            @if(isset($ad->floor)&&$ad->floor) <span>{{ $ad->floor }}</span> @if(isset($ad->has_elevator)&&$ad->has_elevator) <small>con ascensor</small> @endif @endif
                        @elseif($typology==2)
                            <span>{{ $ad->n_bedrooms }}</span> <small>habs.</small>
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            <span>{{ number_format((float) $ad->area_land,0,',','.') }}</span> <small>m&sup2; terreno</small>
                        @elseif($typology==3)
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            @if($ad->area_constructed) <span>{{ number_format((float) $ad->price/$ad->area_constructed,$decimales,',','.') }}</span> @if($operation==0) <small>&euro;/m&sup2;</small> @else <small>&euro;/mes/m&sup2;</small> @endif @endif
                        @elseif($typology==4)
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            @if($ad->area_constructed) <span>{{ number_format((float) $ad->price/$ad->area_constructed,$decimales,',','.') }}</span> @if($operation==0) <small>&euro;/m&sup2;</small> @else <small>&euro;/mes/m&sup2;</small> @endif @endif
                        @elseif($typology==5)
                            <span><small>Plaza para</small> {{ strtolower($ad->garage_capacity) }}</span>
                        @elseif($typology==6)
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            <span>{{ $ad->land_category }}</span>
                        @elseif($typology==7)
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            {{--Other room details--}}
                        @elseif($typology==8)
                            <span>{{ $ad->surroundings }}</span>
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            @if($ad->min_capacity < $ad->max_capacity) <small>Para</small> <span>{{ $ad->min_capacity }}</span> <small>a</small> <span>{{ $ad->max_capacity }}</span> <small>personas</small> @elseif($ad->min_capacity) <small>Desde</small> <span>{{$ad->min_capacity}}</span> <small>personas</small> @elseif($ad->max_capacity) <small>Hasta</small> <span>{{$ad->max_capacity}}</span> <small>personas</small> @endif
                        @endif
                    </div>
                </div>

                {{--Pictures row--}}
                <div class="row">
                    <div class="col-xs-12" id="ad-pictures">
                    <?php $i = 1; $firstPair = true; $pics = \App\AdPic::where('ad_id',$ad->ad_id)->get(); $max = count($pics); ?>
                    @foreach($pics as $pic)
                        @if($i<6)
                        <div class="row">
                            <div class="col-xs-12 ad-pic">
                                <img width="100%" src="
                                @if(substr($pic->filename, 0, 4) === 'http')
                                    {{ $pic->filename }}
                                @else
                                    {{ asset('ads/pictures/'.$pic->filename) }}
                                @endif
                                ">
                            </div>
                        </div>
                        @else
                            @if($firstPair)
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 ad-pic coupled-pic-1">
                                    <img width="100%" src="
                                    @if(substr($pic->filename, 0, 4) === 'http')
                                        {{ $pic->filename }}
                                    @else
                                        {{ asset('ads/pictures/'.$pic->filename) }}
                                    @endif
                                    ">
                                </div>
                            <?php $firstPair = false; ?>
                            @else
                                <div class="col-xs-12 col-sm-6 ad-pic coupled-pic-2">
                                    <img width="100%" src="
                                    @if(substr($pic->filename, 0, 4) === 'http')
                                        {{ $pic->filename }}
                                    @else
                                        {{ asset('ads/pictures/'.$pic->filename) }}
                                    @endif
                                    ">
                                </div>
                            <?php $firstPair = true; ?>
                            @endif
                            @if($firstPair || $i==$max) </div> @endif
                        @endif
                    <?php ++$i; ?>
                    @endforeach
                    </div>
                </div>

                {{--Details row--}}
                <div class="row">
                    <div class="col-xs-12" id="ad-details">

                        {{--common to all--}}
                        <h4>Descripción</h4>
                        <p>{{$ad->description}}</p>

                        @if($typology!=8)
                            {{--common to all but vacational--}}
                            <h4>Precio</h4>
                            <p>{{ number_format((float) $ad->price,0,',','.') }} @if($operation==0) &euro; @else &euro;/mes @endif </p>
                            @if(isset($ad->area_constructed)&&$ad->area_constructed) <p>{{ number_format((float) $ad->price/$ad->area_constructed,0,',','.') }} @if($operation==0) &euro;/m&sup2; @else &euro;/mes/m&sup2; @endif </p> @endif
                            @if(isset($ad->deposit)&&$ad->deposit) <p>Fianza de {{ $ad->deposit }}</p> @endif
                            @if(isset($ad->community_cost)&&$ad->community_cost) <p>Gastos de comunidad {{$ad->community_cost}} &euro;/mes</p> @endif
                            @if(isset($ad->rent_to_own)&&$ad->rent_to_own) <p>Alquiler con derecho a compra</p> @endif
                        @endif

                        @if($typology==0||$typology==1||$typology==2)
                        {{--common to house, apartment or country house--}}
                            <h4>Características básicas</h4>
                            @if(isset($ad->type)&&$ad->type)<p>{{$ad->type}}</p>@endif
                            @if(isset($ad->floor_number)&&$ad->floor_number) <p>{{$ad->floor_number}}</p> @endif
                            @if((isset($ad->area_constructed)&&$ad->area_constructed)||(isset($ad->area_usable)&&$ad->area_usable)) <p> @if(isset($ad->area_constructed)&&$ad->area_constructed) {{$ad->area_constructed}} m&sup2; construidos @endif @if(isset($ad->area_usable)&&$ad->area_usable) {{$ad->area_usable}} m&sup2; útiles @endif </p> @endif
                            @if(isset($ad->n_bedrooms)&&$ad->n_bedrooms) <p>{{$ad->n_bedrooms}} habitaciones</p> @endif
                            @if(isset($ad->n_bathrooms)&&$ad->n_bathrooms) <p>{{$ad->n_bathrooms}} wc</p> @endif
                            @if(isset($ad->area_land)&&$ad->area_land) <p>{{$ad->area_land}} m&sup2; parcela</p> @endif
                            @if(isset($ad->needs_restoration)&&$ad->needs_restoration) <p>A reformar</p> @elseif(!$ad->needs_restoration&&(!isset($ad->is_new_development)||!$ad->is_new_development)&&(!isset($ad->is_new_development_finished)||!$ad->is_new_development_finished)) <p>Segunda mano/buen estado</p> @endif
                            @if(isset($ad->faces_north)||isset($ad->faces_south)||isset($ad->faces_east)||isset($ad->faces_west)) <p>Orientación @if(isset($ad->faces_north)&&$ad->faces_north) Norte @endif @if(isset($ad->faces_south)&&$ad->faces_south) Sur @endif @if(isset($ad->faces_east)&&$ad->faces_east) Este @endif @if(isset($ad->faces_west)&&$ad->faces_west) Oeste @endif </p> @endif

                            @if((isset($ad->is_new_development)&&$ad->is_new_development)||(isset($ad->is_new_development_finished)&&$ad->is_new_development_finished))
                            <h4>Construcción</h4>
                            <p>Obra nueva @if(isset($ad->is_new_development_finished)&&$ad->is_new_development_finished) terminada @endif </p>
                            @endif

                            <h4>Equipamiento</h4>
                            @if(isset($ad->has_box_room)&&$ad->has_box_room) <p>Trastero</p> @endif
                            @if(isset($ad->has_terrace)&&$ad->has_terrace) <p>{{$ad->has_terrace}} Terraza</p> @endif
                            @if(isset($ad->has_fireplace)&&$ad->has_fireplace) <p>{{$ad->has_fireplace}} Chimenea</p> @endif
                            @if(isset($ad->has_parking_space)&&$ad->has_parking_space) <p>{{$ad->has_parking_space}} Plaza de garaje incluida en el precio</p> @endif
                            @if(isset($ad->has_builtin_closets)&&$ad->has_builtin_closets) <p>Armarios empotrados</p> @endif
                            @if(isset($ad->has_furniture)&&$ad->has_furniture) <p>Amueblada</p> @endif
                            @if(isset($ad->has_equipped_kitchen)&&$ad->has_equipped_kitchen) <p>Cocina equipada</p> @endif
                            @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) <p>Aire acondicionado</p> @endif

                            <h4>Edificio</h4>
                            @if(isset($ad->n_floors)&&$ad->n_floors) {{$ad->n_floors}} plantas @endif
                            @if(isset($ad->has_elevator)&&$ad->has_elevator) Con ascensor @endif
                            <?php $certE = \App\EnergyCertification::where('id',$ad->energy_certification_id)->pluck('name'); ?>
                            <p>Certificación energética: {{ $certE }}
                                @if(in_array($certE,range('A','G')))
                                    @if(isset($ad->energy_performance)&&$ad->energy_performance)
                                        ({{$ad->energy_performance}} kWh/m&sup2; a&ntilde;o)
                                    @else
                                        (IPE no indicado)
                                    @endif
                                @endif
                            </p>

                            @if((isset($ad->has_swimming_pool)&&$ad->has_swimming_pool)||(isset($ad->has_garden)&&$ad->has_garden))
                            <h4> @if($typology!=1) Exterior @else Zonas comunes @endif </h4>
                            @if(isset($ad->has_swimming_pool)&&$ad->has_swimming_pool) Piscina @endif
                            @if(isset($ad->has_garden)&&$ad->has_garden) Jardín @endif
                            @endif
                        @elseif($typology==3)
                        {{--business--}}
                            <h4>Características básicas</h4>
                            {{--CARACTERÍSTICAS BÁSICAS basic details: m2 constru (same line) m2 util, planta, estado (2a mano...),
                            distro, n aseos, situacion (a pie de calle), n escaparates--}}

                            <h4>Edificio</h4>
                            {{--EDIFICIO bajo, fachada de x m, certificación energética--}}

                            <h4>Equipamiento</h4>
                            {{--EQUIPAMIENTO almacén/archivo--}}
                        @elseif($typology==4)
                        {{--office--}}
                            <h4>Características básicas</h4>
                            @if(isset($ad->floor_number)&&$ad->floor_number) <p>{{$ad->floor_number}} @if(isset($ad->is_exterior)&&$ad->is_exterior) exterior @endif </p> @endif
                            @if((isset($ad->area_constructed)&&$ad->area_constructed)||(isset($ad->area_usable)&&$ad->area_usable)) <p> @if(isset($ad->area_constructed)&&$ad->area_constructed) {{$ad->area_constructed}} m&sup2; construidos @endif @if(isset($ad->area_usable)&&$ad->area_usable) {{$ad->area_usable}} m&sup2; útiles @endif </p> @endif
                            @if(isset($ad->area_min_for_sale)&&$ad->area_min_for_sale) <p>{{ $ad->area_min_for_sale }} m&sup2; mínimos en @if($operation==0) venta @else alquiler @endif </p> @endif
                            @if(isset($ad->distribution)&&$ad->distribution) <p>{{ $ad->distribution }}</p> @endif
                            @if((isset($ad->n_restrooms)&&$ad->n_restrooms)&&((isset($ad->has_bathrooms)&&$ad->has_bathrooms)||(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside))) <p> {{ $ad->n_restrooms }} @choice('aseo|aseos',$ad->n_restrooms) @if((isset($ad->has_bathrooms)&&$ad->has_bathrooms)||(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside)) y @choice('baño completo|baños completos',$ad->n_restrooms) @endif @if(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside) dentro de la oficina @endif </p> @endif
                            @if(isset($ad->needs_restoration)&&$ad->needs_restoration) <p>A reformar</p> @elseif(!$ad->needs_restoration&&(!isset($ad->is_new_development)||!$ad->is_new_development)&&(!isset($ad->is_new_development_finished)||!$ad->is_new_development_finished)) <p>Segunda mano/buen estado</p> @endif

                            <h4>Edificio</h4>
                            @if(isset($ad->n_floors)&&$ad->n_floors) <p>{{$ad->n_floors}} plantas</p> @endif
                            @if(isset($ad->n_elevators)&&$ad->n_elevators) <p> {{ $ad->n_elevators }} @choice('ascensor|ascensores',$ad->n_elevators) </p> @endif
                            @if(isset($ad->has_offices_only)&&$ad->has_offices_only) <p>Uso exclusivo de oficinas</p> @endif
                            <?php $certE = \App\EnergyCertification::where('id',$ad->energy_certification_id)->pluck('name'); ?>
                            <p>Certificación energética: {{ $certE }}
                                @if(in_array($certE,range('A','G')))
                                    @if(isset($ad->energy_performance)&&$ad->energy_performance)
                                        ({{$ad->energy_performance}} kWh/m&sup2; a&ntilde;o)
                                    @else
                                        (IPE no indicado)
                                    @endif
                                @endif
                            </p>

                            <h4>Equipamiento</h4>
                            @if(isset($ad->n_parking_spaces)&&$ad->n_parking_spaces) <p>{{ $ad->n_parking_spaces }} @choice('plaza|plazas',$ad->n_parking_spaces) de aparcamiento</p> @endif
                            @if(isset($ad->has_steel_door)&&$ad->has_steel_door) <p>Puerta de seguridad</p> @endif
                            @if(isset($ad->has_security_system)&&$ad->has_security_system) <p>Sistema de alarma</p> @endif
                            @if(isset($ad->has_access_control)&&$ad->has_access_control) <p>Control de accesos</p> @endif
                            @if(isset($ad->has_fire_detectors)&&$ad->has_fire_detectors) <p>Detectores de incendios</p> @endif
                            @if(isset($ad->has_fire_extinguishers)&&$ad->has_fire_extinguishers) <p>Extintores</p> @endif
                            @if(isset($ad->has_fire_sprinklers)&&$ad->has_fire_sprinklers) <p>Aspersores</p> @endif
                            @if(isset($ad->has_fireproof_doors)&&$ad->has_fireproof_doors) <p>Puertas cortafuegos</p> @endif
                            @if(isset($ad->has_emergency_lights)&&$ad->has_emergency_lights) <p>Luces de salida de emergencia</p> @endif
                            @if(isset($ad->has_doorman)&&$ad->has_doorman) <p>Portero/seguridad/conserge</p> @endif
                            @if(isset($ad->has_air_conditioning_preinstallation)&&$ad->has_air_conditioning_preinstallation) <p>Preinstalación de aire acondicionado</p> @endif
                            @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) <p>Aire acondicionado</p> @endif
                            @if(isset($ad->has_heating)&&$ad->has_heating) <p>Calefacción</p> @endif
                            @if(isset($ad->has_hot_water)&&$ad->has_hot_water) <p>Agua caliente</p> @endif
                            @if(isset($ad->has_kitchen)&&$ad->has_kitchen) <p>Cocina</p> @endif
                            @if(isset($ad->has_archive)&&$ad->has_archive) <p>Archivo/almacén</p> @endif
                            @if(isset($ad->has_double_windows)&&$ad->has_double_windows) <p>Doble acristalamiento</p> @endif
                            @if(isset($ad->has_suspended_ceiling)&&$ad->has_suspended_ceiling) <p>Falso techo</p> @endif
                            @if(isset($ad->has_suspended_floor)&&$ad->has_suspended_floor) <p>Suelo técnico</p> @endif
                            @if(isset($ad->is_handicapped_adapted)&&$ad->is_handicapped_adapted) <p>Edificio adaptado a personas con discapacidad</p> @endif

                        @elseif($typology==5)
                        {{--garage--}}
                            <h4>Características básicas</h4>
                            {{--CARACTERÍSTICAS BÁSICAS basic details: capacidad, covered, elevator--}}

                            <h4>Extras</h4>
                            {{--EXTRAS sauo doro, alarm, cameras...--}}
                        @elseif($typology==6)
                        {{--land--}}
                            <h4>Características básicas</h4>
                            {{--CARACTERÍSTICAS BÁSICAS total surface, min surface alquilar, edifi surface, acceso, distancias--}}

                            <h4>Situación urbanística</h4>
                            {{--SITUACIÓN URBANÍSTICA terreno urbanizable, certificado para residencial unifamiliar (chalets), plantas edific--}}

                            <h4>Equipamiento</h4>
                            {{--EQUIPAMIENTO agua, elec, alcant, gas, alumbrado, aceras--}}
                        @elseif($typology==7)
                        {{--room--}}
                            <h4>Características básicas</h4>
                            {{--CARACTERÍSTICAS BÁSICAS basic details: habitación en piso de x m2, planta con/sin elevator, n habitaciones,
                            2 wc, estancia mínima, capacidad máxima, género y edad de actuales "Ahora son chica(s), entre 10 y 20 años",
                            no se puede fumar(?), no se admite mascota(?)--}}

                            <h4>Buscan</h4>
                            {{--BUSCAN chico/chica (da igual), estudiante/...--}}

                            <h4>Equipamiento</h4>
                            {{--EQUIPAMIENTO amueblado...--}}
                        @elseif($typology==8)
                        {{--vacation--}}
                            <h4>Características del apartamento</h4>
                            {{--CARACTERÍSTICAS DEL APARTAMENTO--}}
                            {{--Exterior: aparcamiento, vistas...--}}
                            {{--Distro: habitaciones--}}
                            {{--Interior: tv, calefacción, secador--}}
                            {{--Cocina y electrodoms: lavavajillas, nevera, horno...--}}
                            {{--Info adicional: verificado, no fumad, ascensor, no mascot, recom coche--}}
                            {{--Idiomas: español, inglés, francés--}}

                            <h4>Precios</h4>
                            {{--PRECIOS--}}
                            {{--Precios para capacidad de x plazas y un maximo de 2 huespedes extra (precios con IVA incluido)--}}
                            {{--Tabla de precios--}}
                            {{--Fianza: % o euros--}}
                            {{--Reserva: "" ""--}}
                            {{--Forma de pago: transferencia bancaria--}}
                            {{--Limpieza final: incluida--}}
                            {{--Sábanas y toallas: incluidas--}}
                            {{--Gastos (luz, gas, etc.): incluidos--}}
                            {{--* Consultar precios en puentes, navidad y semana santa--}}
                            {{--* Entrada a las 16.00 y salida a las 10.00 salvo acuerdo de lo contrario--}}

                            <h4>Situación</h4>
                            {{--SITUACIÓN--}}
                        @endif

                        {{--common to all--}}
                        @if(!$ad->hide_address)
                            <h4> @if(isset($ad->route)) {{ $ad->route }}, @endif @if(isset($ad->street_number)) {{ $ad->street_number }} @endif </h4>
                            @if(isset($ad->residential_area)&&$ad->residential_area) <p>{{ $ad->residential_area }}</p> @endif
                            <p>{{ $ad->locality }}</p>
                            <p> @if(isset($ad->admin_area_lvl2)&&$ad->admin_area_lvl2) {{ $ad->admin_area_lvl2 }}, @endif @if(isset($ad->admin_area_lvl1)&&$ad->admin_area_lvl1) {{ $ad->admin_area_lvl1 }} @endif </p>
                            <p><a href="https://www.google.es/maps/<?php foreach(preg_split('/[ \r\n]/',$ad->formatted_address) as $piece) { echo $piece.'+'; } ?>" target="_blank"><i class="fa fa-map-marker"></i> Ver localización en Google Maps</a></p>
                        @endif

                        <h4>Actualizado el {{ \Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('d') + 0 }} de
                            @if(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='01') Enero
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='02') Febrero
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='03') Marzo
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='04') Abril
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='05') Mayo
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='06') Junio
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='07') Julio
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='08') Agosto
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='09') Septiembre
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='10') Octubre
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='11') Noviembre
                            @elseif(\Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$ad->updated_at)->format('m')=='12') Diciembre
                            @endif
                        </h4>

                    </div>
                </div>

            </div>

            {{--Contact column--}}
            <div class="hidden-xs hidden-sm col-md-4">
                <div class="well">
                    <h4>Pregúntenos</h4>
                    <form id="contact-form" class="form-horizontal" action="javascript:submitForm();">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="name" required="" type="text" placeholder="Su nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" required="" type="email" placeholder="Su e-mail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea class="form-control" name="message" rows="3" required="" placeholder="¿Tiene alguna duda? ¿Desea visitar el inmueble? ¿Desea realizar una oferta? ¡Pregúntenos!"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-right">
                                <img id="ajax-loader" src="{{ asset('img/input-spinner.gif') }}" class="hidden" style="display:inline-block;">
                                <button class="btn btn-default btn-reset" type="reset">Borrar</button>
                                <button class="btn btn-warning btn-submit" type="submit">Enviar</button>
                            </div>
                        </div>
                    </form>

                    <h4>969 969 969</h4>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script>
        var contactForm = $('#contact-form');
        var btnSubmit = $('.btn-submit');
        var btnReset = $('.btn-reset');
        var ajaxLoader = $('#ajax-loader');
        var inputName = $('input[name=name]');
        var inputEmail = $('input[name=email]');
        var inputMessage = $('textarea[name=message]');
        var submitForm = function() {
            //disable form
            inputName.prop('disabled', true);
            inputEmail.prop('disabled', true);
            inputMessage.prop('disabled', true);
            btnSubmit.prop('disabled', true);
            btnReset.prop('disabled', true);
            //show loading.gif
            ajaxLoader.removeClass('hidden');
            $.post('/sendForm', {
                '_token':       $('input[name=_token]').val(),
                contactName:    inputName.val(),
                contactEmail:   inputEmail.val(),
                contactMessage: inputMessage.val()
            }).done(function(){
                //reset form
                inputName.val('');
                inputEmail.val('');
                inputMessage.val('');
                //show success
                toastr['success']('Su mensaje ha sido enviado. Recibirá nuestra respuesta lo antes posible.', 'Envío realizado',{
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
            }).fail(function(){
                toastr['error']('No ha sido posible enviar su mensaje. Compruebe que ha rellenado todos los campos correctamente.', 'Error',{
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
            }).always(function(){
                //re-enable form
                inputName.prop('disabled', false);
                inputEmail.prop('disabled', false);
                inputMessage.prop('disabled', false);
                btnSubmit.prop('disabled', false);
                btnReset.prop('disabled', false);
                //hide loading.gif
                ajaxLoader.addClass('hidden');
            });
        };
        $(document).ready(function() {

        });
    </script>
@endsection
