<div class="container-fluid" id="footer">
    <div class="row">
        <div class="col-xs-12" style="padding-top:50px;padding-bottom:10px;">
            @if(\App::environment() == 'local')
                <b>Materialista</b>
            @else
                <b>{!! $options->company_name !!}</b>
            @endif
            &copy;
            @if(\Carbon\Carbon::now()->format('Y') > $options->starting_year)
                {!! $options->starting_year !!}-{!! \Carbon\Carbon::now()->format('Y') !!}
            @else
                {!! $options->starting_year !!}
            @endif
        </div>
    </div>
</div>