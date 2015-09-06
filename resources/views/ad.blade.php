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
                            @if($ad->area_constructed) <span>{{ number_format((float) $ad->price/$ad->area_constructed,0,',','.') }}</span> @if($operation==0) <small>&euro;/m&sup2;</small> @else <small>&euro;/mes/m&sup2;</small> @endif @endif
                        @elseif($typology==4)
                            <span>{{ number_format((float) $ad->area_constructed,0,',','.') }}</span> <small>m&sup2;</small>
                            @if($ad->area_constructed) <span>{{ number_format((float) $ad->price/$ad->area_constructed,0,',','.') }}</span> @if($operation==0) <small>&euro;/m&sup2;</small> @else <small>&euro;/mes/m&sup2;</small> @endif @endif
                        @elseif($typology==5)
                            <span>{{ $ad->garage_capacity }}</span>
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
                    <div class="col-xs-12">
                        {{--Here goes more details about the ad--}}
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
