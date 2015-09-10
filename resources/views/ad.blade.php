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
        @if($typology==8)
        h5 {
            font-weight: bold;
            font-size: 14px;
            margin-top: 25px;
            color: #666;
        }
        @endif
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
        @media (min-width:768px) {
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
        @if($typology==8)
        #table-payment-details > tbody > tr > td,
        #table-payment-details > tbody > tr {
            border-top:0;
            padding:4px 0;
        }
        #table-payment-details > tbody > tr > td:first-of-type {
            font-weight: bold;
            color: #666;
        }
        @endif
        p > span:after,
        td > span:after {
            content: ',';
        }
        p.orientacion > span:after {
            content: ' -';
        }
        p > span:last-of-type:after,
        p.orientacion > span:last-of-type:after,
        td > span:last-of-type:after {
            content: '';
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
                            <small>Desde</small> <span class="price">{{ number_format((float) $ad->min_price_per_night/29.0,0,',','.') }}</span> <small>&euro;/noche/persona</small>
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
                            <span>{{ number_format((float) $ad->area_total,0,',','.') }}</span> <small>m&sup2;</small>
                            <span>{{ $ad->category_land }}</span>
                        @elseif($typology==7)
                            <span>{{ $ad->n_bedrooms }} habs.</span>
                            <span>@if(isset($ad->deposit)) Fianza de {{ $ad->deposit }} @endif</span>
                        @elseif($typology==8)
                            <span>{{ $ad->surroundings }}</span>
                            <span>{{ number_format((float) $ad->area_total,0,',','.') }}</span> <small>m&sup2;</small>
                            @if($ad->min_capacity < $ad->max_capacity) <small style="margin-left:35px;">De</small> <span style="margin-left:0;">{{ $ad->min_capacity }}</span> <small>a</small> <span style="margin-left:0;">{{ $ad->max_capacity }}</span> <small>personas</small> @elseif($ad->min_capacity) <small>Desde</small> <span>{{$ad->min_capacity}}</span> <small>personas</small> @elseif($ad->max_capacity) <small>Hasta</small> <span>{{$ad->max_capacity}}</span> <small>plazas</small> @endif
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
                            @if((isset($ad->area_constructed)&&$ad->area_constructed)||(isset($ad->area_usable)&&$ad->area_usable)) <p> @if(isset($ad->area_constructed)&&$ad->area_constructed) <span>{{$ad->area_constructed}} m&sup2; construidos</span> @endif @if(isset($ad->area_usable)&&$ad->area_usable) <span>{{$ad->area_usable}} m&sup2; útiles</span> @endif </p> @endif
                            @if(isset($ad->n_bedrooms)&&$ad->n_bedrooms) <p>{{$ad->n_bedrooms}} habitaciones</p> @endif
                            @if(isset($ad->n_bathrooms)&&$ad->n_bathrooms) <p>{{$ad->n_bathrooms}} wc</p> @endif
                            @if(isset($ad->area_land)&&$ad->area_land) <p>{{$ad->area_land}} m&sup2; parcela</p> @endif
                            @if(isset($ad->needs_restoration)&&$ad->needs_restoration) <p>A reformar</p> @elseif(!$ad->needs_restoration&&(!isset($ad->is_new_development)||!$ad->is_new_development)&&(!isset($ad->is_new_development_finished)||!$ad->is_new_development_finished)) <p>Segunda mano/buen estado</p> @endif
                            @if(isset($ad->faces_north)||isset($ad->faces_south)||isset($ad->faces_east)||isset($ad->faces_west)) <p class="orientacion">Orientación @if(isset($ad->faces_north)&&$ad->faces_north) <span>Norte</span> @endif @if(isset($ad->faces_south)&&$ad->faces_south) <span>Sur</span> @endif @if(isset($ad->faces_east)&&$ad->faces_east) <span>Este</span> @endif @if(isset($ad->faces_west)&&$ad->faces_west) <span>Oeste</span> @endif </p> @endif

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
                            @if(isset($ad->n_floors)&&$ad->n_floors) {{$ad->n_floors}} @choice('planta|plantas',$ad->n_floors) @endif
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
                            @if(isset($ad->floor_number)&&$ad->floor_number) <p>{{$ad->floor_number}} @if(isset($ad->is_exterior)&&$ad->is_exterior) exterior @endif </p> @endif
                            @if((isset($ad->area_constructed)&&$ad->area_constructed)||(isset($ad->area_usable)&&$ad->area_usable)) <p> @if(isset($ad->area_constructed)&&$ad->area_constructed) <span>{{$ad->area_constructed}} m&sup2; construidos</span> @endif @if(isset($ad->area_usable)&&$ad->area_usable) <span>{{$ad->area_usable}} m&sup2; útiles</span> @endif </p> @endif
                            @if(isset($ad->distribution)&&$ad->distribution) <p>{{ $ad->distribution }}</p> @endif
                            @if((isset($ad->n_restrooms)&&$ad->n_restrooms)&&((isset($ad->has_bathrooms)&&$ad->has_bathrooms)||(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside))) <p> {{ $ad->n_restrooms }} @choice('aseo|aseos',$ad->n_restrooms) @if((isset($ad->has_bathrooms)&&$ad->has_bathrooms)||(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside)) y @choice('baño completo|baños completos',$ad->n_restrooms) @endif @if(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside) dentro de la oficina @endif </p> @endif
                            @if(isset($ad->needs_restoration)&&$ad->needs_restoration) <p>A reformar</p> @elseif(!$ad->needs_restoration&&(!isset($ad->is_new_development)||!$ad->is_new_development)&&(!isset($ad->is_new_development_finished)||!$ad->is_new_development_finished)) <p>Segunda mano/buen estado</p> @endif
                            @if(isset($ad->location)&&$ad->location) <p>{{ $ad->location }}</p> @endif
                            @if(isset($ad->is_corner_located)&&$ad->is_corner_located) <p>Hace esquina</p> @endif
                            @if(isset($ad->n_shop_windows)&&$ad->n_shop_windows) <p>{{ $ad->n_shop_windows }} @choice('escaparate|escaparates',$ad->n_shop_windows)</p> @endif
                            @if(isset($ad->last_activity)&&$ad->last_activity) <p>{{ $ad->last_activity }}</p> @endif

                            <h4>Edificio</h4>
                            @if(isset($ad->n_floors)&&$ad->n_floors) <p>{{$ad->n_floors}} @choice('planta|plantas',$ad->n_floors)</p> @endif
                            @if(isset($ad->facade)&&$ad->facade) <p>{{ $ad->facade }}</p> @endif
                            <?php $certE = \App\EnergyCertification::where('id',$ad->energy_certification_id)->pluck('name'); ?>
                            <p>Certificación energética: {{ $certE }}
                                @if(in_array($certE,range('A','G')))
                                    @if(isset($ad->energy_performance)&&$ad->energy_performance)
                                        ({{$ad->energy_performance}} kWh/m&sup2; a&ntilde;o)
                                    @else
                                        &lbrack;IPE no indicado]
                                    @endif
                                @endif
                            </p>

                            <h4>Equipamiento</h4>
                            @if(isset($ad->has_archive)&&$ad->has_archive) <p>Almacén</p> @endif
                            @if(isset($ad->has_smoke_extractor)&&$ad->has_smoke_extractor) <p>Salida de humos</p> @endif
                            @if(isset($ad->has_fully_equipped_kitchen)&&$ad->has_fully_equipped_kitchen) <p>Cocina completamente equipada</p> @endif
                            @if(isset($as->has_steel_door)&&$as->has_steel_door) <p>Puerta de seguridad</p> @endif
                            @if(isset($ad->has_alarm)&&$ad->has_alarm) <p>Sistema de alarma</p> @endif
                            @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) <p>Aire acondicionado</p> @endif
                            @if(isset($ad->has_heating)&&$ad->has_heating) <p>Calefacción</p> @endif
                            @if(isset($ad->has_security_camera)&&$ad->has_security_camera) <p>Circuito cerrado de seguridad</p> @endif
                        @elseif($typology==4)
                        {{--office--}}
                            <h4>Características básicas</h4>
                            @if(isset($ad->floor_number)&&$ad->floor_number) <p>{{$ad->floor_number}} @if(isset($ad->is_exterior)&&$ad->is_exterior) exterior @endif </p> @endif
                            @if((isset($ad->area_constructed)&&$ad->area_constructed)||(isset($ad->area_usable)&&$ad->area_usable)) <p> @if(isset($ad->area_constructed)&&$ad->area_constructed) <span>{{$ad->area_constructed}} m&sup2; construidos</span> @endif @if(isset($ad->area_usable)&&$ad->area_usable) <span>{{$ad->area_usable}} m&sup2; útiles</span> @endif </p> @endif
                            @if(isset($ad->area_min_for_sale)&&$ad->area_min_for_sale) <p>{{ $ad->area_min_for_sale }} m&sup2; mínimos en @if($operation==0) venta @else alquiler @endif </p> @endif
                            @if(isset($ad->distribution)&&$ad->distribution) <p>{{ $ad->distribution }}</p> @endif
                            @if((isset($ad->n_restrooms)&&$ad->n_restrooms)&&((isset($ad->has_bathrooms)&&$ad->has_bathrooms)||(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside))) <p> {{ $ad->n_restrooms }} @choice('aseo|aseos',$ad->n_restrooms) @if((isset($ad->has_bathrooms)&&$ad->has_bathrooms)||(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside)) y @choice('baño completo|baños completos',$ad->n_restrooms) @endif @if(isset($ad->has_bathrooms_inside)&&$ad->has_bathrooms_inside) dentro de la oficina @endif </p> @endif
                            @if(isset($ad->needs_restoration)&&$ad->needs_restoration) <p>A reformar</p> @elseif(!$ad->needs_restoration&&(!isset($ad->is_new_development)||!$ad->is_new_development)&&(!isset($ad->is_new_development_finished)||!$ad->is_new_development_finished)) <p>Segunda mano/buen estado</p> @endif

                            <h4>Edificio</h4>
                            @if(isset($ad->n_floors)&&$ad->n_floors) <p>{{$ad->n_floors}} @choice('planta|plantas',$ad->n_floors)</p> @endif
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
                            @if(isset($ad->garage_capacity)&&$ad->garage_capacity) <p>Plaza para {{ strtolower($ad->garage_capacity) }}</p>@endif
                            @if(isset($ad->is_covered)&&$ad->is_covered) <p>Cubierta</p> @endif
                            @if(isset($ad->has_lift)&&$ad->has_lift) <p>Con ascensor</p> @endif

                            <h4>Extras</h4>
                            @if(isset($ad->has_automatic_door)&&$ad->has_automatic_door) <p>Puerta automática de garaje</p> @endif
                            @if(isset($ad->has_alarm)&&$ad->has_alarm) <p>Alarma</p> @endif
                            @if(isset($ad->has_security_camera)&&$ad->has_security_camera) <p>Cámaras de seguridad</p> @endif
                            @if(isset($ad->has_security_guard)&&$ad->has_security_guard) <p>Vigilante</p> @endif
                        @elseif($typology==6)
                        {{--land--}}
                            <h4>Características básicas</h4>
                            @if(isset($ad->area_total)&&$ad->area_total) <p>Superficie total {{ $ad->area_total }} m&sup2;</p> @endif
                            @if(isset($ad->area_min_for_sale)&&$ad->area_min_for_sale) <p>Superficie mínima en venta {{ $ad->area_min_for_sale }} m&sup2;</p> @endif
                            @if(isset($ad->area_building_land)&&$ad->area_building_land) <p>Superficie edificable {{ $ad->area_building_land }} m&sup2;</p> @endif
                            @if(isset($ad->has_road_access)&&$ad->has_road_access) <p>Acceso vía urbana</p> @endif
                            @if(isset($ad->nearest_town)&&$ad->nearest_town) <p>{{ $ad->nearest_town }}</p> @endif

                            <h4>Situación urbanística</h4>
                            @if(isset($ad->category_land)&&$ad->category_land) <p>{{ $ad->category_land }}</p> @endif
                            @if(isset($ad->is_classified_residential_block)&&$ad->is_classified_residential_block) <p>Calificado para residencial en altura (bloques)</p> @endif
                            @if(isset($ad->is_classified_residential_house)&&$ad->is_classified_residential_house) <p>Calificado para residencial unifamiliar (chalets)</p> @endif
                            @if(isset($ad->is_classified_office)&&$ad->is_classified_office) <p>Calificado para terciario oficinas</p> @endif
                            @if(isset($ad->is_classified_commercial)&&$ad->is_classified_commercial) <p>Calificado para terciario comercial</p> @endif
                            @if(isset($ad->is_classified_hotel)&&$ad->is_classified_hotel) <p>Calificado para terciario hoteles</p> @endif
                            @if(isset($ad->is_classified_industrial)&&$ad->is_classified_industrial) <p>Calificado para industrial</p> @endif
                            @if(isset($ad->is_classified_public_service)&&$ad->is_classified_public_service) <p>Calificado para dotaciones (hospitales, escuelas, museos)</p> @endif
                            @if(isset($ad->is_classified_others)&&$ad->is_classified_others) <p>Dispone de calificación (consultar)</p> @endif
                            @if(isset($ad->max_floors_allowed)&&$ad->max_floors_allowed) <p>{{ $ad->max_floors_allowed }} @choice('planta|plantas',$ad->max_floors_allowed) edificables</p> @endif

                            <h4>Equipamiento</h4>
                            @if(isset($ad->has_water)&&$ad->has_water) <p>Agua</p> @endif
                            @if(isset($ad->has_electricity)&&$ad->has_electricity) <p>Electricidad</p> @endif
                            @if(isset($ad->has_sewer_system)&&$ad->has_sewer_system) <p>Alcantarillado</p> @endif
                            @if(isset($ad->has_natural_gas)&&$ad->has_natural_gas) <p>Gas natural</p> @endif
                            @if(isset($ad->has_street_lightning)&&$ad->has_street_lightning) <p>Alumbrado público</p> @endif
                            @if(isset($ad->has_sidewalks)&&$ad->has_sidewalks) <p>Aceras</p> @endif
                        @elseif($typology==7)
                        {{--room--}}
                            <h4>Características básicas</h4>
                            @if(isset($ad->area_room)&&$ad->area_room) <p>Habitación en {{ strtolower($ad->category_room) }} de {{ $ad->area_room }} m&sup2;</p> @endif
                            @if(isset($ad->floor_number)&&$ad->floor_number) <p>{{$ad->floor_number}} @if(isset($ad->has_elevator)&&$ad->has_elevator) con ascensor @endif </p> @endif
                            @if(isset($ad->n_bedrooms)&&$ad->n_bedrooms) <p>{{ $ad->n_bedrooms }} @choice('habitación|habitaciones',$ad->n_bedrooms)</p> @endif
                            @if(isset($ad->n_bathrooms)&&$ad->n_bathrooms) <p>{{ $ad->n_bathrooms }} @choice('wc|wc',$ad->n_bathrooms)</p> @endif
                            @if(isset($ad->min_stay)&&$ad->min_stay) <p>Estancia mínima de {{ $ad->min_stay }}</p> @endif
                            @if(isset($ad->n_people)&&$ad->n_people) <p>Capacidad máxima de {{ $ad->n_people }} @choice('persona|personas',$ad->n_people)</p> @endif
                            @if(isset($ad->current_gender)&&$ad->current_gender) <p>Ahora son {{ $ad->current_gender }}@if(isset($ad->min_current_tenants_age)&&isset($ad->max_current_tenants_age)&&($ad->min_current_tenants_age<=$ad->max_current_tenants_age)), entre {{ $ad->min_current_tenants_age }} y {{ $ad->max_current_tenants_age }} a&ntilde;os @endif </p> @endif
                            @if(isset($ad->is_smoking_allowed)&&$ad->is_smoking_allowed) <p>No se puede fumar</p> @endif
                            @if(isset($ad->is_pet_allowed)&&$ad->is_pet_allowed) <p>No se admite mascota</p> @endif

                            <h4>Buscan</h4>
                            @if(isset($ad->gender)&&$ad->gender) <p> @if($ad->gender=='Da igual') Chico o chica, {{ strtolower($ad->gender) }} @else {{ $ad->gender }} @endif </p> @endif
                            @if(isset($ad->occupation)&&$ad->occupation) <p> @if($ad->occupation=='Da igual') Trabajador o estudiante, {{ strtolower($ad->occupation) }} @else {{ $ad->occupation }} @endif  @endif

                            <h4>Equipamiento</h4>
                            @if(isset($ad->has_furniture)&&$ad->has_furniture) <p>Amueblado</p> @endif
                            @if(isset($ad->has_builtin_closets)&&$ad->has_builtin_closets) <p>Armarios empotrados</p> @endif
                            @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) <p>Aire acondicionado</p> @endif
                            @if(isset($ad->has_internet)&&$ad->has_internet) <p>Conexión a internet</p> @endif
                            @if(isset($ad->has_house_keeper)&&$ad->has_house_keeper) <p>Asistente/a del hogar</p> @endif
                        @elseif($typology==8)
                        {{--vacation--}}
                            <h4>Características del apartamento</h4>
                            <h5>Exterior</h5>
                            <p>
                            @if(isset($ad->has_barbecue)&&$ad->has_barbecue) <span>Barbacoa</span> @endif
                            @if(isset($ad->has_terrace)&&$ad->has_terrace) <span>Terraza</span> @endif
                            @if(isset($ad->has_private_swimming_pool)&&$ad->has_private_swimming_pool) <span>Piscina privada</span>  @endif
                            @if(isset($ad->has_shared_swimming_pool)&&$ad->has_shared_swimming_pool) <span>Piscina compartida</span>  @endif
                            @if(isset($ad->has_indoor_swimming_pool)&&$ad->has_indoor_swimming_pool) <span>Piscina cubierta</span> @endif
                            @if(isset($ad->has_private_garden)&&$ad->has_private_garden) <span>Jardín privado</span> @endif
                            @if(isset($ad->has_shared_garden)&&$ad->has_shared_garden) <span>Jardín compartido</span> @endif
                            @if(isset($ad->has_furnished_garden)&&$ad->has_furnished_garden) <span>Muebles de jardín</span> @endif
                            @if(isset($ad->has_parking_space)&&$ad->has_parking_space) <span>Aparcamiento</span> @endif
                            @if(isset($ad->has_playground)&&$ad->has_playground) <span>Parque infantil</span> @endif
                            @if(isset($ad->has_mountain_sights)&&$ad->has_mountain_sights) <span>Vistas a la monta&ntilde;a</span> @endif
                            @if(isset($ad->has_sea_sights)&&$ad->has_sea_sights) <span>Vistas al mar</span> @endif
                            </p>

                            <h5>Distribución</h5>
                            <p>
                            @if(isset($ad->n_double_bedroom)&&$ad->n_double_bedroom) <span>{{ $ad->n_double_bedroom }} @choice('habitación doble|habitaciones dobles',$ad->n_double_bedroom) </span> @endif
                            @if(isset($ad->n_two_beds_room)&&$ad->n_two_beds_room) <span>{{ $ad->n_two_beds_room }} @choice('habitación|habitaciones',$ad->n_two_beds_room) de matrimonio</span> @endif
                            @if(isset($ad->n_single_bed_room)&&$ad->n_single_bed_room) <span>{{ $ad->n_single_bed_room }} @choice('habitación individual|habitaciones individuales',$ad->n_single_bed_room) </span> @endif
                            @if(isset($ad->n_three_beds_room)&&$ad->n_three_beds_room) <span>{{ $ad->n_three_beds_room }} @choice('habitación|habitaciones',$ad->n_three_beds_room) con tres camas </span> @endif
                            @if(isset($ad->n_four_beds_room)&&$ad->n_four_beds_room) <span>{{ $ad->n_four_beds_room }} @choice('habitación|habitaciones',$ad->n_four_beds_room) con cuatro camas </span> @endif
                            @if(isset($ad->n_sofa_bed)&&$ad->n_sofa_bed) <span>{{ $ad->n_sofa_bed }} @choice('sofá cama|sofás cama',$ad->n_sofa_bed)</span> @endif
                            @if(isset($ad->n_double_sofa_bed)&&$ad->n_double_sofa_bed) <span>{{ $ad->n_double_sofa_bed }} @choice('sofá cama doble|sofás cama dobles',$ad->n_double_sofa_bed)</span> @endif
                            @if(isset($ad->n_extra_bed)&&$ad->n_extra_bed) <span>{{ $ad->n_extra_bed }} @choice('cama supletoria|camas supletorias',$ad->n_extra_bed)</span> @endif
                            @if(isset($ad->is_american_kitchen)&&$ad->is_american_kitchen) <span>Cocina americana</span> @else <span>Cocina independiente</span> @endif
                            @if(isset($ad->area_total)&&$ad->area_total) <span>{{ $ad->area_total }} m&sup2; total</span> @endif
                            @if(isset($ad->area_garden)&&$ad->area_garden) <span>{{ $ad->area_garden }} m&sup2; de jardín</span> @endif
                            @if(isset($ad->area_terrace)&&$ad->area_terrace) <span>{{ $ad->area_terrace }} m&sup2; de terraza</span> @endif
                            </p>

                            <h5>Interior</h5>
                            <p>
                            @if(isset($ad->has_fireplace)&&$ad->has_fireplace) <span>Chimenea</span> @endif
                            @if(isset($ad->has_air_conditioning)&&$ad->has_air_conditioning) <span>Aire acondicionado</span> @endif
                            @if(isset($ad->has_jacuzzi)&&$ad->has_jacuzzi) <span>Jacuzzi</span> @endif
                            @if(isset($ad->has_tv)&&$ad->has_tv) <span>TV</span> @endif
                            @if(isset($ad->has_cable_tv)&&$ad->has_cable_tv) <span>TV satélite/por cable</span> @endif
                            @if(isset($ad->has_internet)&&$ad->has_internet) <span>Internet</span> @endif
                            @if(isset($ad->has_heating)&&$ad->has_heating) <span>Calefacción</span> @endif
                            @if(isset($ad->has_fan)&&$ad->has_fan) <span>Ventilador</span> @endif
                            @if(isset($ad->has_cradle)&&$ad->has_cradle) <span>Cuna</span> @endif
                            @if(isset($ad->has_hairdryer)&&$ad->has_hairdryer) <span>Secador de pelo</span> @endif
                            </p>

                            <h5>Cocina y electrodomésticos</h5>
                            <p>
                            @if(isset($ad->has_dishwasher)&&$ad->has_dishwasher) <span>Lavavajillas</span> @endif
                            @if(isset($ad->has_fridge)&&$ad->has_fridge) <span>Frigorífico</span> @endif
                            @if(isset($ad->has_oven)&&$ad->has_oven) <span>Horno</span> @endif
                            @if(isset($ad->has_microwave)&&$ad->has_microwave) <span>Microondas</span> @endif
                            @if(isset($ad->has_coffee_maker)&&$ad->has_coffee_maker) <span>Cafetera</span> @endif
                            @if(isset($ad->has_dryer)&&$ad->has_dryer) <span>Secadora</span> @endif
                            @if(isset($ad->has_washer)&&$ad->has_washer) <span>Lavadora</span> @endif
                            @if(isset($ad->has_iron)&&$ad->has_iron) <span>Plancha</span> @endif
                            </p>

                            <h5>Información adicional</h5>
                            <p>
                            @if(isset($ad->is_smoking_allowed)&&!$ad->is_smoking_allowed) <span>No se puede fumar</span> @endif
                            @if(isset($ad->is_pet_allowed)&&!$ad->is_pet_allowed) <span>No se admite mascota</span> @endif
                            @if(isset($ad->is_car_recommended)&&$ad->is_car_recommended) <span>Recomendable tener coche</span> @endif
                            @if(isset($ad->is_handicapped_adapted)&&$ad->is_handicapped_adapted) <span>Adaptado para personas con discapacidad</span> @endif
                            </p>

                            <h4>Precios</h4>
                            @if(isset($ad->season_prices)&&$ad->season_prices->count())
                                @if(isset($ad->min_capacity)&&$ad->min_capacity) <p>Precios para una capacidad de {{ $ad->min_capacity }} plazas @if(isset($ad->max_capacity)&&($ad->min_capacity<$ad->max_capacity)) y un máximo de {{ ($ad->max_capacity - $ad->min_capacity) }} @choice('huésped|huéspedes',($ad->max_capacity - $ad->min_capacity)) extra. @endif &lbrack;Precios con IVA incluido&rbrack;</p> @endif
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr style="font-size:12px;">
                                            <th style="min-width:20%;">Temporada</th>
                                            <th style="text-align:center;min-width:11%;">1 Noche</th>
                                            <th style="text-align:center;min-width:12%;">1 Noche fin de semana</th>
                                            <th style="text-align:center;min-width:11%;">1 Semana <br><small>(7 noches)</small></th>
                                            <th style="text-align:center;min-width:11%;">1 Quincena <br><small>(14 noches)</small></th>
                                            <th style="text-align:center;min-width:11%;">1 Mes <br><small>(29 noches)</small></th>
                                            <th style="text-align:center;min-width:11%;">Coste por huesped extra/noche</th>
                                            <th style="text-align:center;min-width:13%;">Noches de alquiler mínimo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ad->season_prices as $season)
                                            <tr>
                                            @if($season->n_season=='1')
                                                <td style="vertical-align:middle;">Precio básico</td>
                                            @else
                                                <td style="vertical-align:middle;">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$season->from_date)->format('d M') }} a {{ \Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$season->to_date)->format('d M') }}</td>
                                            @endif
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->p_one_night)&&$season->p_one_night) {{ $season->p_one_night }} &euro; @else - @endif</td>
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->p_weekend_night)&&$season->p_weekend_night) {{ $season->p_weekend_night }} &euro; @else - @endif</td>
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->p_one_week)&&$season->p_one_week) {{ $season->p_one_week }} &euro; @else - @endif</td>
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->p_half_month)&&$season->p_half_month) {{ $season->p_half_month }} &euro; @else - @endif</td>
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->p_one_month)&&$season->p_one_month) {{ $season->p_one_month }} &euro; @else - @endif</td>
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->p_extra_guest_per_night)&&$season->p_extra_guest_per_night) {{ $season->p_extra_guest_per_night }} &euro; @else - @endif</td>
                                                <td style="text-align:center;vertical-align:middle;">@if(isset($season->n_min_nights)&&$season->n_min_nights) {{ $season->n_min_nights }} @choice('noche|noches',$season->n_min_nights) @else - @endif</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <table class="table" id="table-payment-details">
                                <tbody>
                                    @if(isset($ad->has_deposit)&&$ad->has_deposit)
                                    <tr>
                                        <td width="160">Fianza:</td>
                                        <td>{{ $ad->deposit }} @if($ad->has_deposit=='1') % @else &euro; @endif </td>
                                    </tr>
                                    @endif
                                    @if(isset($ad->has_booking)&&$ad->has_booking)
                                    <tr>
                                        <td width="160">Reserva:</td>
                                        <td>{{ $ad->booking }} @if($ad->has_booking=='1') % @else &euro; @endif </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td width="160">Formas de pago:</td>
                                        <td>
                                            @if(isset($ad->accepts_cash)&&$ad->accepts_cash) <span>En efectivo</span> @endif
                                            @if(isset($ad->accepts_transfer)&&$ad->accepts_transfer) <span>Transferencia bancaria</span> @endif
                                            @if(isset($ad->accepts_credit_card)&&$ad->accepts_credit_card) <span>Tarjeta de crédito</span> @endif
                                            @if(isset($ad->accepts_paypal)&&$ad->accepts_paypal) <span>Paypal</span> @endif
                                            @if(isset($ad->accepts_check)&&$ad->accepts_check) <span>Cheque</span> @endif
                                            @if(isset($ad->accepts_western_union)&&$ad->accepts_western_union) <span>Western Union</span> @endif
                                            @if(isset($ad->accepts_money_gram)&&$ad->accepts_money_gram) <span>Money Gram</span> @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="160">Día de pago:</td>
                                        <td>
                                            @if(isset($ad->payment_day)&&$ad->payment_day) <span>@if($ad->payment_day=='Días antes de la entrada') {{ $ad->n_days_before }} {{ strtolower($ad->payment_day) }} @else {{ $ad->payment_day }} @endif </span> @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="160">Limpieza final:</td>
                                        <td>@if(isset($ad->has_cleaning)&&$ad->has_cleaning) No incluida: {{$ad->cleaning }} &euro; @else Incluida @endif</td>
                                    </tr>
                                    <tr>
                                        <td width="160">Sábanas y toallas:</td>
                                        <td>@if(isset($ad->has_included_towels)&&$ad->has_included_towels) Incluidas @else No incluidas @endif</td>
                                    </tr>
                                    <tr>
                                        <td width="160">Gastos: </td>
                                        <td>@if(isset($ad->has_included_expenses)&&$ad->has_included_expenses) Incluidos @else No incluidos @endif</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>* Entrada a las 16.00 y salida a las 10.00 salvo acuerdo de lo contrario</p>
                        @endif

                        {{--common to all--}}
                        @if(!$ad->hide_address)
                            <h4> @if(isset($ad->route)) {{ $ad->route }}, @endif @if(isset($ad->street_number)) {{ $ad->street_number }} @endif </h4>
                            @if(isset($ad->residential_area)&&$ad->residential_area) <p>{{ $ad->residential_area }}</p> @endif
                            <p>{{ $ad->locality }}</p>
                            <p> @if(isset($ad->admin_area_lvl2)&&$ad->admin_area_lvl2) {{ $ad->admin_area_lvl2 }}, @endif @if(isset($ad->admin_area_lvl1)&&$ad->admin_area_lvl1) {{ $ad->admin_area_lvl1 }} @endif </p>
                            <p><a href="https://www.google.es/maps/search/<?php foreach(preg_split('/[ \r\n]/',$ad->formatted_address) as $piece) { echo $piece.'+'; } ?>" target="_blank"><i class="fa fa-map-marker"></i> Ver localización en Google Maps</a></p>
                        @endif

                        @if($typology==8)
                            <h4>Ubicación y entorno</h4>
                            <p>
                            @if(isset($ad->is_out_town_center)&&$ad->is_out_town_center) <span>Fuera del casco urbano</span> @endif
                            @if(isset($ad->is_isolated)&&$ad->is_isolated) <span>Aislado</span> @endif
                            @if(isset($ad->distance_to_beach)&&$ad->distance_to_beach) <span>{{ $ad->distance_to_beach }} m a la playa</span> @endif
                            @if(isset($ad->distance_to_town_center)&&$ad->distance_to_town_center) <span>{{ $ad->distance_to_town_center }} m al centro de la localidad</span> @endif
                            @if(isset($ad->distance_to_ski_area)&&$ad->distance_to_ski_area) <span>{{ $ad->distance_to_ski_area }} m a pistas de ski</span> @endif
                            @if(isset($ad->distance_to_golf_course)&&$ad->distance_to_golf_course) <span>{{ $ad->distance_to_golf_course }} m a campo de golf</span> @endif
                            @if(isset($ad->distance_to_airport)&&$ad->distance_to_airport) <span>{{ $ad->distance_to_airport }} m al aeropuerto</span> @endif
                            @if(isset($ad->distance_to_supermarket)&&$ad->distance_to_supermarket) <span>{{ $ad->distance_to_supermarket }} m al supermercado</span> @endif
                            @if(isset($ad->distance_to_river_or_lake)&&$ad->distance_to_river_or_lake) <span>{{ $ad->distance_to_river_or_lake }} m al río o lago</span> @endif
                            @if(isset($ad->distance_to_marina)&&$ad->distance_to_marina) <span>{{ $ad->distance_to_marina }} m al puerto deportivo</span> @endif
                            @if(isset($ad->distance_to_horse_riding_area)&&$ad->distance_to_horse_riding_area) <span>{{ $ad->distance_to_horse_riding_area }} m a centro ecuestre</span> @endif
                            @if(isset($ad->distance_to_scuba_diving_area)&&$ad->distance_to_scuba_diving_area) <span>{{ $ad->distance_to_scuba_diving_area }} m a escuela de submarinismo</span> @endif
                            @if(isset($ad->distance_to_train_station)&&$ad->distance_to_train_station) <span>{{ $ad->distance_to_train_station }} m a estación de tren</span> @endif
                            @if(isset($ad->distance_to_bus_station)&&$ad->distance_to_bus_station) <span>{{ $ad->distance_to_bus_station }} m a estación de autobús</span> @endif
                            @if(isset($ad->distance_to_hospital)&&$ad->distance_to_hospital) <span>{{ $ad->distance_to_hospital }} m al hospital</span> @endif
                            @if(isset($ad->distance_to_hiking_area)&&$ad->distance_to_hiking_area) <span>{{ $ad->distance_to_hiking_area }} m a ruta de senderismo</span> @endif
                            @if(isset($ad->is_nudist_area)&&$ad->is_nudist_area) <span>Turismo nudista</span> @endif
                            @if(isset($ad->is_bar_area)&&$ad->is_bar_area) <span>Zona de bares</span> @endif
                            @if(isset($ad->is_gayfriendly_area)&&$ad->is_gayfriendly_area) <span>Ambiente gayfriendly</span> @endif
                            @if(isset($ad->is_family_tourism_area)&&$ad->is_family_tourism_area) <span>Turismo familiar</span> @endif
                            @if(isset($ad->is_luxury_area)&&$ad->is_luxury_area) <span>Alojamiento de lujo</span> @endif
                            @if(isset($ad->is_charming)&&$ad->is_charming) <span>Alojamiento con encanto</span> @endif
                            </p>

                            <h4>Actividades y atracciones</h4>
                            <p>
                            @if(isset($ad->has_bicycle_rental)&&$ad->has_bicycle_rental) <span>Alquiler de bicicleta</span> @endif
                            @if(isset($ad->has_car_rental)&&$ad->has_car_rental) <span>Alquiler de coche</span> @endif
                            @if(isset($ad->has_adventure_activities)&&$ad->has_adventure_activities) <span>Actividades multiaventura</span> @endif
                            @if(isset($ad->has_kindergarten)&&$ad->has_kindergarten) <span>Guardería</span> @endif
                            @if(isset($ad->has_sauna)&&$ad->has_sauna) <span>Sauna</span> @endif
                            @if(isset($ad->has_tennis_court)&&$ad->has_tennis_court) <span>Pista de tenis</span> @endif
                            @if(isset($ad->has_paddle_court)&&$ad->has_paddle_court) <span>Pista de pádel</span> @endif
                            @if(isset($ad->has_gym)&&$ad->has_gym) <span>Gimnasio</span> @endif
                            </p>
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
