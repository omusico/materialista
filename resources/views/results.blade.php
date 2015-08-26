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
        .bx-wrapper
        {
            -moz-box-shadow: 0;
            -webkit-box-shadow: 0;
            box-shadow: none;
            border: 0;
            left: 0;
            background: #fff;
            margin-bottom:0;
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
    </style>
@endsection

@section('content')
    {{--Descripción de resultados y tabs--}}
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3>Número de resultados y tipo de resultados</h3>
            </div>
        </div>
        <div class="row" style="padding-top:15px;">
            <div class="col-xs-12 col-sm-offset-3 col-sm-9">
                <ul class="nav nav-tabs">
                    <li @if(true) class="active" @endif>
                        <a href="javascript:">Comprar</a>
                    </li>
                    <li>
                        <a href="javascript:">Alquilar</a>
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
                        Aquí van los filtros
                    </div>
                </div>
                {{--Resultados--}}
                <div class="col-xs-12 col-sm-9">
                    <div id="results">
                        @foreach(\App\SellHouse::all() as $ad)
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
                                <div class="col-xs-12 col-sm-8" style="height:190px;background-color: #FFF;padding-left:0;">

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

        });
    </script>
@endsection
