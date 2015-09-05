@extends('layout')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/uniform.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.bxslider.min.css') }}">

    @if(\App::environment() == 'local')
        <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
        <style>
            h1 {
                font-family: 'Dancing Script', cursive;
                font-size: 50px;
            }
        </style>
    @endif
    <style>
        h3 {
            font-weight: bold;
            color: #4A4A4A;
        }
        .nav-tabs {
            margin-bottom: 0;
            border-bottom: 3px solid #DDD;
        }
        .nav-tabs > li {
            margin-bottom: -3px;
        }
        .nav-tabs > li.active > a,
        .nav-tabs > li.active > a:focus,
        .nav-tabs > li.active > a:hover {
            font-size: 16px;
            cursor: default;
            border-bottom: 3px solid #F26721;
            color: #F26721;
            border-top: 0;
            border-left: 0;
            border-right: 0;
        }
        .nav-tabs > li > a:hover {
            border-color: #FFF;
            border-bottom: 3px solid #F26721;
            color: #F26721;
            background-color: #FFF;
        }
        .nav-tabs > li > a:focus {
            background-color: #FFF;
        }
        .nav-tabs > li.disabled > a,
        .nav-tabs > li.disabled > a:focus,
        .nav-tabs > li.disabled > a:hover {
            border-bottom: 3px solid #DDD;
            color: #DDD;
        }
        .nav-tabs > li > a {
            font-weight: bold;
            color: #808080;
            font-size: 16px;
            background-color: #FFF;
            line-height: 1.42857;
            border-width: 0;
            padding: 10px 0;
            margin-right:30px;
        }
        .thumbs-slider li {
            height:190px;
        }
        .bx-wrapper {
            -moz-box-shadow: 0;
            -webkit-box-shadow: 0;
            box-shadow: none;
            border: 0;
            left: 0;
            background: #fff;
            margin-bottom:0;
        }
        .bx-wrapper .bx-prev,
        .bx-wrapper .bx-next {
            opacity: 0.5;
        }
        .bx-wrapper .bx-prev:hover,
        .bx-wrapper .bx-next:hover {
            opacity: 1;
        }
        .slide-counter {
            font-size: 16px;
            font-weight: bold;
            text-shadow: 0 2px 1px rgba(51, 51, 51, 0.5);
            color: #FFF;
            position: relative;
            margin-top: -25px;
            padding-right: 5px;
        }
        .ad-address,.ad-price,.ad-details,.ad-description {
            padding-left: 35px;
        }
        .ad-address {
            font-size: 16px;
            color: #1260ff;
            padding-top: 10px;
        }
        .ad-price {
            font-size: 20px;
            color: #111111;
            font-weight: bold;
            padding-top: 10px;
        }
        .ad-details {
            font-size: 14px;
            color: #2e2e2e;
            padding-top: 5px;
        }
        .ad-details > span {
            margin-right:6px;
        }
        .ad-description {
            font-size: 15px;
            color: #808080;
            padding-top: 5px;
        }
        @media (max-width:767px) {
            .ad-info { min-height: 50px; }
        }
        @media (min-width:768px) {
            .ad-info { height: 190px; }
        }
        @media (min-width:992px) {
            .ad-info { height: 190px; }
        }
        @media (min-width:1200px) {
            .ad-info { height: 190px; }
        }
        .col-price-min {
            padding: 0 1px 0 0;
        }
        .col-price-max {
            padding: 0 0 0 1px;
        }
    </style>
@endsection

@section('content')
    <input type="hidden" name="operation" value="{!! $input['operation'] !!}">
    <input type="hidden" name="typology" value="{!! $input['typology'] !!}">
    <input type="hidden" name="locality" value="@if(isset($input['locality'])){!! $input['locality'] !!}@endif">
    <input type="hidden" name="address" value="@if(isset($input['address'])){!! $input['address'] !!}@endif">
    <input type="hidden" name="search_type" value="{!! $input['search_type'] !!}">

    {{--Descripción de resultados y tabs--}}
    <div class="container">
        <div class="row">
            <div class="col-xs-12" style="padding-top:10px;">
                <h3>{{ count($ads) }} {{ $typology }} @if($search_type=='0') en @else cerca de @endif {{ $locality }}</h3>
            </div>
        </div>
        <div class="row" style="padding-top:15px;">
            <div class="col-xs-12 col-sm-offset-3 col-sm-9">
                <ul class="nav nav-tabs">
                    <li class=" @if($input['operation']=='0') active @endif @if($input['typology']==2 || $input['typology']==3) disabled @endif ">
                        <a id="btn-buy" href="javascript:">Comprar</a>
                    </li>
                    <li class=" @if($input['operation']=='1') active @endif ">
                        <a id="btn-rent" href="javascript:">Alquilar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{--Filtro y lista de resultados--}}
    <div class="container-fluid" style="background-color: #f5f5f5;margin-top:-3px;border-top:3px solid #DDD;">
        <div class="container">
            <div class="row">
                {{--Filtros--}}
                <div class="hidden-xs col-sm-3">
                    <div class="well">
                        <div class="row">
                            <label class="col-xs-12" style="padding-left:1px;">Precio</label>
                        </div>
                    @if($input['operation']=='0')
                        <div class="row">
                            <div class="col-xs-6 col-price-min">
                                <select name="price-min" class="form-control" title="Precio mínimo">
                                    <option value="">Mín</option>
                                    <option value="0">OPTION</option>
                                </select>
                            </div>
                            <div class="col-xs-6 col-price-max">
                                <select name="price-max" class="form-control" title="Precio máximo">
                                    <option value="">Máx</option>
                                    <option value="0">OPTION</option>
                                </select>
                            </div>
                        </div>
                    @elseif($input['operation']=='1'&&$input['typology']!='2')
                        <div class="row">
                            <div class="col-xs-6 col-price-min">
                                <select name="price-min" class="form-control" title="Precio mínimo">
                                    <option value="">Mín</option>
                                    <option value="0">OPTION</option>
                                </select>
                            </div>
                            <div class="col-xs-6 col-price-max">
                                <select name="price-max" class="form-control" title="Precio máximo">
                                    <option value="">Máx</option>
                                    <option value="0">OPTION</option>
                                </select>
                            </div>
                        </div>
                    @elseif($input['operation']=='1'&&$input['typology']=='2')
                        <div class="row">
                            <div class="col-xs-6 col-price-min">
                                <select name="price-min" class="form-control" title="Precio mínimo">
                                    <option value="">Mín</option>
                                    <option value="0">OPTION</option>
                                </select>
                            </div>
                            <div class="col-xs-6 col-price-max">
                                <select name="price-max" class="form-control" title="Precio máximo">
                                    <option value="">Máx</option>
                                    <option value="0">OPTION</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    @if($input['typology']=='0'||$input['typology']=='1')

                    @elseif($input['typology']=='2')

                    @elseif($input['typology']=='3')

                    @elseif($input['typology']=='4')

                    @elseif($input['typology']=='5')

                    @elseif($input['typology']=='6')

                    @elseif($input['typology']=='7')

                    @endif
                    </div>
                </div>
                {{--Resultados--}}
                <div class="col-xs-12 col-sm-9">
                    <div id="results">
                    @if(count($ads)===0)
                        <div style="margin-top:30px;">
                            No se encontraron resultados con los criterios de búsqueda elegidos.
                        </div>
                    @endif
                    @foreach($ads as $ad)
                        <div class="row" style="margin-top:30px;">
                            {{--Slider de thumbnails--}}
                            <div class="hidden-xs col-sm-4 slider-container" style="padding-right:0;">
                                <ul class="thumbs-slider">
                                @foreach(\App\AdPic::where('ad_id',$ad->ad_id)->get() as $thumb)
                                    @if(substr($thumb->filename, 0, 4) === 'http')
                                    <li style="background-image: url('{{ $thumb->filename }}');
                                            background-size: cover;">&nbsp;</li>
                                    @else
                                    <li style="background-image: url('{{ asset('ads/thumbnails/thumb_'.$thumb->filename) }}');
                                            background-size: cover;">&nbsp;</li>
                                    @endif
                                @endforeach
                                </ul>
                                <div class="slide-counter text-right" style="width:100%;">
                                    <i class="fa fa-camera"></i> <span class="current-index"></span>/<span class="total-slides"></span>
                                </div>
                            </div>
                            {{--Info del AD--}}
                            <div class="col-xs-12 col-sm-8 ad-info" style="background-color: #FFF;padding-left:0;">
                                {{--Tipo de inmueble y dirección--}}
                                <div class="row">
                                    <div class="col-xs-12 ad-address">
                                        {{--route,street_number,price,has_parking_space--}}
                                        {{ $ad->type }} en @if(!$ad->hide_address) @if(isset($ad->route)) {{ $ad->route }}, @endif @if(isset($ad->street_number)) {{ $ad->street_number }}, @endif @endif {{ $ad->locality }}
                                    </div>
                                </div>
                                {{--Precio y aquello importante que incluye--}}
                                <div class="row">
                                    <div class="col-xs-12 ad-price">
                                    @if($input['typology']=='2')
                                        <small style="font-weight: normal;">Desde</small> {{ number_format((float) $ad->min_price_per_night,0,',','.') }} <small style="font-weight: normal;">&euro;/noche/persona</small>
                                    @else
                                        {{ number_format((float) $ad->price,0,',','.') }} <small style="font-weight: normal;"> @if($input['operation']=='0') &euro; @else &euro;/mes @endif </small>
                                    @endif
                                    @if($input['typology']=='0'||$input['typology']=='1')
                                        @if(isset($ad->has_parking_space)&&$ad->has_parking_space) <small style="font-weight: normal;margin-left:10px;">Garaje incluido</small> @endif
                                    @elseif($input['typology']=='2')
                                        {{--Vacation includeds--}}
                                    @elseif($input['typology']=='3')
                                        {{--Room includeds--}}
                                    @endif
                                    </div>
                                </div>
                                {{--Detalles importantes: tamaño, no. habitaciones, planta, si ascensor--}}
                                <div class="row">
                                    <div class="col-xs-12 ad-details">
                                    @if($input['typology']=='0'||$input['typology']=='1')
                                        <span>{{ $ad->rooms }} habs.</span>
                                        <span>{{ number_format((float) $ad->area,0,',','.') }} m&sup2;</span>
                                        @if(isset($ad->floor)&&$ad->floor) <span>{{ $ad->floor }} @if(isset($ad->has_elevator)&&$ad->has_elevator) con ascensor @endif</span> @endif
                                    @elseif($input['typology']=='2')
                                        <span>{{ $ad->surroundings }}</span>
                                        <span>{{ number_format((float) $ad->area,0,',','.') }} m&sup2;</span>
                                        @if($ad->min_capacity < $ad->max_capacity)<span>Para {{ $ad->min_capacity }} a {{ $ad->max_capacity }} personas</span>@elseif($ad->min_capacity) Desde {{$ad->min_capacity}} personas @elseif($ad->max_capacity) Hasta {{$ad->max_capacity}} personas @endif
                                    @elseif($input['typology']=='3')
                                        <span>{{ number_format((float) $ad->area,0,',','.') }} m&sup2;</span>
                                        {{--Other room details--}}
                                    @elseif($input['typology']=='4' || $input['typology']=='5')
                                        <span>{{ number_format((float) $ad->area,0,',','.') }} m&sup2;</span>
                                        @if($ad->area)<span>{{ number_format((float) $ad->price/$ad->area,0,',','.') }} @if($input['operation']=='0') &euro;/m&sup2; @else &euro;/mes/m&sup2; @endif</span>@endif
                                    @elseif($input['typology']=='6')
                                        <span>{{ $ad->garage_capacity }}</span>
                                    @elseif($input['typology']=='7')
                                        <span>{{ number_format((float) $ad->area,0,',','.') }} m&sup2;</span>
                                        <span>{{ $ad->land_category }}</span>
                                    @endif
                                    </div>
                                </div>
                                {{--Descripción excerpt--}}
                                <div class="row hidden-xs">
                                    <div class="col-xs-12 ad-description">
                                    @if($ad->description!='') {{ substr($ad->description,0,135).'...' }} @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    <script type="text/javascript" src="{{ asset('js/jquery.bxslider.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            Metronic.init(); // init metronic core components >> uniform checkboxes

            $('#btn-buy').click(function(){
                if($('input[name=operation]').val() == '0')
                    return false;
                if($(this).parent().hasClass('disabled'))
                    return false;
                window.location.href = '/resultados?' + $.param({
                    operation: '0',
                    typology: $('input[name=typology]').val(),
                    locality: $('input[name=locality]').val(),
                    address: $('input[name=address]').val(),
                    search_type: $('input[name=search_type]').val()
                });
            });
            $('#btn-rent').click(function(){
                if($('input[name=operation]').val() == '1')
                    return false;
                window.location.href = '/resultados?' + $.param({
                    operation: '1',
                    typology: $('input[name=typology]').val(),
                    locality: $('input[name=locality]').val(),
                    address: $('input[name=address]').val(),
                    search_type: $('input[name=search_type]').val()
                });
            });

            $('.thumbs-slider').each(function() {
                var slider = $(this);
                var slideIndex = slider.parent().find('.current-index');
                var totalSlides = slider.parent().find('.total-slides');
                var slideCount = $(this).bxSlider({
                    auto: true,
                    onSliderLoad: function (currentIndex) {
                        slideIndex.text(currentIndex + 1);
                    },
                    onSlideBefore: function ($slideElement, oldIndex, newIndex) {
                        slideIndex.text(newIndex + 1);
                    },
                    pager: false,
                    autoStart: false
                }).getSlideCount();
                totalSlides.text(slideCount);
            });

            $('select').select2({
                placeholder: "Seleccione",
                allowClear: true,
                escapeMarkup: function(m) {
                    return m;
                }
            });

        });
    </script>
@endsection
