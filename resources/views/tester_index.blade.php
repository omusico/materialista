@extends('basic')

@section('css')
    @if(\App::environment() == 'local')
    <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
    <style>
        h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 136px;
        }
    </style>
    @endif
@endsection

@section('content')
    <div class="container">
        <div class="row" style="padding:50px 0 25px 0;">
            <div class="col-xs-12 text-center">
                @if(\App::environment() == 'local')
                <h1>Materialista</h1>
                @else
                <div style="display:inline-block;height:346px;width:744px;margin-right: 100px;
                        background-image: url('{{ asset('img/logo-valkiria.png') }}');
                        background-size: contain;" >
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-offset-3 col-xs-6">
                <h4>Vistas en desarrollo:</h4>
                <a href="{{ route('form.new.ad') }}" class="btn btn-primary">New ad form</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Home/Search</a>
                <a href="{{ route('results') }}" class="btn btn-primary">Search results and filters</a>
                <a href="javascript:" class="btn btn-primary disabled">Ad profile</a>
            </div>
        </div>
        <div class="row" style="padding-bottom: 100px;">
            <div class="col-xs-offset-3 col-xs-6">
                <h4>Base de datos, tablas:</h4>
                <a href="{{ route('view.table','rent_room') }}" class="btn btn-default">Rent rooms</a>
                <a href="{{ route('view.table','rent_vacation') }}" class="btn btn-default">Rent vacation</a>
                <a href="{{ route('view.table','rent_apartment') }}" class="btn btn-default">Rent apartment</a>
                <a href="{{ route('view.table','sell_apartment') }}" class="btn btn-default">Sell apartment</a>
                <a href="{{ route('view.table','rent_country_house') }}" class="btn btn-default">Rent country house</a>
                <a href="{{ route('view.table','sell_country_house') }}" class="btn btn-default">Sell country house</a>
                <a href="{{ route('view.table','rent_house') }}" class="btn btn-default">Rent house</a>
                <a href="{{ route('view.table','sell_house') }}" class="btn btn-default">Sell house</a>
                <a href="{{ route('view.table','rent_office') }}" class="btn btn-default">Rent office</a>
                <a href="{{ route('view.table','sell_office') }}" class="btn btn-default">Sell office</a>
                <a href="{{ route('view.table','rent_business') }}" class="btn btn-default">Rent business</a>
                <a href="{{ route('view.table','sell_business') }}" class="btn btn-default">Sell business</a>
                <a href="{{ route('view.table','rent_garage') }}" class="btn btn-default">Rent garage</a>
                <a href="{{ route('view.table','sell_garage') }}" class="btn btn-default">Sell garage</a>
                <a href="{{ route('view.table','rent_land') }}" class="btn btn-default">Rent land</a>
                <a href="{{ route('view.table','sell_land') }}" class="btn btn-default">Sell land</a>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
