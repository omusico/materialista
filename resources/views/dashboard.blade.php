@extends('dashboard_layout')

@section('title')
    <title>Panel de control | Inicio</title>
@endsection

@section('css')
    @if(\App::environment() == 'local')
        <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
        <style>
            #logo {
                text-decoration: none;
                color: #FFF;
            }
            #logo > h2, h1 {
                font-family: 'Dancing Script', cursive;
            }
            h1 {
                font-size: 136px;
            }
        </style>
    @endif
    <style>
        .db-test > .btn-default {
            margin-bottom:4px;
        }
    </style>
@endsection

@section('content')
    <!-- BEGIN PAGE HEADER-->
    <h3 class="page-title">
        Panel de control
    </h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ route('dashboard.home') }}">Inicio</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat red-intense">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        {{ \App\Ad::all()->count() }}
                    </div>
                    <div class="desc">
                        Anuncios publicados
                    </div>
                </div>
                <a class="more" href="{{ route('dashboard.editAd') }}">
                    Editar anuncios <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat blue-madison">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        0
                    </div>
                    <div class="desc">
                        Mensajes recibidos
                    </div>
                </div>
                <a class="more" href="javascript:">
                    Abrir buzón <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="dashboard-stat green-haze">--}}
                {{--<div class="visual">--}}
                    {{--<i class="fa fa-shopping-cart"></i>--}}
                {{--</div>--}}
                {{--<div class="details">--}}
                    {{--<div class="number">--}}
                        {{--549--}}
                    {{--</div>--}}
                    {{--<div class="desc">--}}
                        {{--New Orders--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<a class="more" href="#">--}}
                    {{--View more <i class="m-icon-swapright m-icon-white"></i>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="dashboard-stat purple-plum">--}}
                {{--<div class="visual">--}}
                    {{--<i class="fa fa-globe"></i>--}}
                {{--</div>--}}
                {{--<div class="details">--}}
                    {{--<div class="number">--}}
                        {{--+89%--}}
                    {{--</div>--}}
                    {{--<div class="desc">--}}
                        {{--Brand Popularity--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<a class="more" href="#">--}}
                    {{--View more <i class="m-icon-swapright m-icon-white"></i>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>

    @if(\App::environment() == 'local')
        <div class="row" style="padding-bottom: 100px;">
            <div class="col-xs-12 db-test">
                <h4>Base de datos. Ver tablas:</h4>
                <a href="{{ route('view.table','rent_room') }}" class="btn btn-default" target="_blank">Rent rooms</a>
                <a href="{{ route('view.table','rent_vacation') }}" class="btn btn-default" target="_blank">Rent vacation</a>
                <a href="{{ route('view.table','rent_apartment') }}" class="btn btn-default" target="_blank">Rent apartment</a>
                <a href="{{ route('view.table','sell_apartment') }}" class="btn btn-default" target="_blank">Sell apartment</a>
                <a href="{{ route('view.table','rent_country_house') }}" class="btn btn-default" target="_blank">Rent country house</a>
                <a href="{{ route('view.table','sell_country_house') }}" class="btn btn-default" target="_blank">Sell country house</a>
                <a href="{{ route('view.table','rent_house') }}" class="btn btn-default" target="_blank">Rent house</a>
                <a href="{{ route('view.table','sell_house') }}" class="btn btn-default" target="_blank">Sell house</a>
                <a href="{{ route('view.table','rent_office') }}" class="btn btn-default" target="_blank">Rent office</a>
                <a href="{{ route('view.table','sell_office') }}" class="btn btn-default" target="_blank">Sell office</a>
                <a href="{{ route('view.table','rent_business') }}" class="btn btn-default" target="_blank">Rent business</a>
                <a href="{{ route('view.table','sell_business') }}" class="btn btn-default" target="_blank">Sell business</a>
                <a href="{{ route('view.table','rent_garage') }}" class="btn btn-default" target="_blank">Rent garage</a>
                <a href="{{ route('view.table','sell_garage') }}" class="btn btn-default" target="_blank">Sell garage</a>
                <a href="{{ route('view.table','rent_land') }}" class="btn btn-default" target="_blank">Rent land</a>
                <a href="{{ route('view.table','sell_land') }}" class="btn btn-default" target="_blank">Sell land</a>
            </div>
        </div>
    @endif
@endsection

@section('js')

@endsection
