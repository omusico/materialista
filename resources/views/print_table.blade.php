@extends('basic')

@section('css')

@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                @foreach($columns as $c)
                    <th>{{$c}}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($rows as $r)
                <tr>
                    @foreach($columns as $c)
                        @if($c != 'description')
                        <td>{{$r->$c}}</td>
                        @else
                        <td>{{substr($r->$c,0,20).'...'}}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="container" style="padding: 25px;">
        <div class="row">
            <div class="col-xs-12 text-left">
                <h4>Columns ({{count($columns)}}):</h4>
                @foreach($columns as $c)
                    {{ "'".$c."'," }}
                @endforeach
            </div>
        </div>
    </div>
    <div class="container" style="padding: 25px;">
        <div class="row">
            <div class="col-xs-12 text-left">
                <h4>Save variables pattern:</h4>
                @foreach($columns as $c)
                    {{ '$old->'.$c.' = ;' }}<br/>
                @endforeach
            </div>
        </div>
    </div>
    <div class="container" style="padding: 25px;">
        <div class="row">
            <div class="col-xs-12 text-left">
                <h4>Array pattern:</h4>
                @foreach($columns as $c)
                    {{ '\''.$c.'\' => ,' }}<br/>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
