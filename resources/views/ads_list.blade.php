@extends('dashboard_layout')

@section('title')
    <title>Panel de control | Editar anuncio</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('//cdn.datatables.net/1.10.7/css/jquery.dataTables.css') }}" />
    <style>
        tfoot {
            display: table-header-group;
        }
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
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
                <i class="fa fa-pencil"></i>
                <a href="{{ route('dashboard.editAd') }}">Editar anuncio</a>
            </li>
        </ul>
    </div>

    <table id="tableAds" class="table table-striped table-hover" style="padding-bottom:40px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipo</th>
                <th>Fecha creación</th>
                <th>Última actualización</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="tbodyAds">
        @foreach($ads as $ad)
            <tr class="trAd">
                <input type="hidden" class="adLocalTable" value="{{ $ad->local_table }}">
                <input type="hidden" class="adLocalId" value="{{ $ad->local_id }}">
                <td>{{ $ad->id }}</td>
                <td>@if($ad->local_table=='rent_apartment')
                        Apartamento en alquiler
                    @elseif($ad->local_table=='rent_business')
                        Local o nave en alquiler
                    @elseif($ad->local_table=='rent_country_house')
                        Casa rural en alquiler
                    @elseif($ad->local_table=='rent_garage')
                        Garaje en alquiler
                    @elseif($ad->local_table=='rent_house')
                        Chalet en alquiler
                    @elseif($ad->local_table=='rent_land')
                        Terreno en alquiler
                    @elseif($ad->local_table=='rent_office')
                        Oficinas en alquiler
                    @elseif($ad->local_table=='rent_room')
                        Habitación en alquiler
                    @elseif($ad->local_table=='rent_vacation')
                        Alquiler vacacional
                    @elseif($ad->local_table=='sell_apartment')
                        Apartamento en venta
                    @elseif($ad->local_table=='sell_business')
                        Local o nave en venta
                    @elseif($ad->local_table=='sell_country_house')
                        Casa rural en venta
                    @elseif($ad->local_table=='sell_garage')
                        Garaje en venta
                    @elseif($ad->local_table=='sell_house')
                        Chalet en venta
                    @elseif($ad->local_table=='sell_land')
                        Terreno en venta
                    @elseif($ad->local_table=='sell_office')
                        Oficina en venta
                    @endif
                </td>
                <td>{{ $ad->created_at->format('d/m/Y h:i:s') }}</td>
                <td>{{ $ad->updated_at->format('d/m/Y h:i:s') }}</td>
                <td>
                    <a href="{{ url('/anuncio/'.$ad->id) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-search"></i> Ver anuncio </a>
                    <a href="{{ url('/dashboard/editAd/'.$ad->id) }}" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editar </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('js')

<script type="text/javascript" src="{{ URL::asset('//cdn.datatables.net/1.10.7/js/jquery.dataTables.js') }}"></script>
<script>
    $(document).ready(function () {

        var table = $('#tableAds').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json",
                "searchPlaceholder": "Filtrar por tipo"
            },
            "pagingType": "full_numbers",
            "order": [[0,'desc']],
            "pageLength": 50,
            "columns": [
//                {"orderDataType": "dom-text"},
                {"orderable": true, "searchable": false},
                {"orderDataType": "dom-text", "orderable": true, "searchable": true},
                {"orderable": true, "searchable": false},
                {"orderable": true, "searchable": false},
//                {"orderable": false, "searchable": false},
//                {"orderable": false, "searchable": false},
//                {"orderable": false, "searchable": false},
//                {"orderable": false, "searchable": false},
//                {"orderable": false, "searchable": false},
//                {"orderDataType": "dom-text", "type": "numeric"},
                {"orderable": false, "searchable": false}
            ]
        });

    });
</script>

@endsection
