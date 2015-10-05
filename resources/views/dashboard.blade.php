@extends('dashboard_layout')

@section('title')
    <title>Panel de control | Inicio</title>
@endsection

@section('css')
    <style>
        .db-test > .btn-default {
            margin-bottom:4px;
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

                <a href="{{ route('view.table','glocal_cms_constants') }}" class="btn btn-default" target="_blank">Config constants</a>
                <a href="{{ route('view.table','migrations') }}" class="btn btn-default" target="_blank">Migrations</a>
                <a href="{{ route('view.table','users') }}" class="btn btn-default" target="_blank">Users</a>
                <a href="{{ route('view.table','password_resets') }}" class="btn btn-default" target="_blank">Password resets</a>

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
                <a href="{{ route('view.table','ad') }}" class="btn btn-default" target="_blank">Ads</a>
                <a href="{{ route('view.table','ad_pic') }}" class="btn btn-default" target="_blank">Ad pictures</a>

                <a href="{{ route('view.table','energy_certification') }}" class="btn btn-default" target="_blank">Energy certification</a>
                <a href="{{ route('view.table','category_business') }}" class="btn btn-default" target="_blank">Category: bussiness</a>
                <a href="{{ route('view.table','category_country_house') }}" class="btn btn-default" target="_blank">Category: country house</a>
                <a href="{{ route('view.table','category_house') }}" class="btn btn-default" target="_blank">Category: house</a>
                <a href="{{ route('view.table','category_land') }}" class="btn btn-default" target="_blank">Category: land</a>
                <a href="{{ route('view.table','category_lodging') }}" class="btn btn-default" target="_blank">Category: lodging</a>
                <a href="{{ route('view.table','category_room') }}" class="btn btn-default" target="_blank">Category: room</a>
                <a href="{{ route('view.table','business_distribution') }}" class="btn btn-default" target="_blank">Business: distribution</a>
                <a href="{{ route('view.table','business_facade') }}" class="btn btn-default" target="_blank">Business: facade</a>
                <a href="{{ route('view.table','business_location') }}" class="btn btn-default" target="_blank">Business: location</a>
                <a href="{{ route('view.table','garage_capacity') }}" class="btn btn-default" target="_blank">Garage: capacity</a>
                <a href="{{ route('view.table','office_distribution') }}" class="btn btn-default" target="_blank">Office: distribution</a>
                <a href="{{ route('view.table','current_tenants_gender') }}" class="btn btn-default" target="_blank">Room: tenants gender</a>
                <a href="{{ route('view.table','tenant_gender') }}" class="btn btn-default" target="_blank">Room: gender</a>
                <a href="{{ route('view.table','tenant_min_stay') }}" class="btn btn-default" target="_blank">Room: min stay</a>
                <a href="{{ route('view.table','tenant_occupation') }}" class="btn btn-default" target="_blank">Room: tenant occupation</a>
                <a href="{{ route('view.table','tenant_sexual_orientation') }}" class="btn btn-default" target="_blank">Room: sexual orientation</a>
                <a href="{{ route('view.table','vacation_season_price') }}" class="btn btn-default" target="_blank">Lodging: season price</a>
                <a href="{{ route('view.table','payment_day') }}" class="btn btn-default" target="_blank">Lodging: payment day</a>
                <a href="{{ route('view.table','surroundings') }}" class="btn btn-default" target="_blank">Lodging: surroundings</a>
                <a href="{{ route('view.table','nearest_town_distance') }}" class="btn btn-default" target="_blank">Land: nearest town</a>

            </div>
        </div>
    @endif
@endsection

@section('js')

@endsection
