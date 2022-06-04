@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            filterOpType();
            // submit form when changing dropdown list 'id'
            $('#status_id').change(function () {
                $('#searchForm').submit();
            });
            $('#cost_center_id').change(function () {
                $('#searchForm').submit();
            });
            $('#type_v').change(function () {
               filterOpType();
            });
        });
        //filter op type
        function filterOpType() {
            var e = document.getElementById("type_v");
            var v = e.options[e.selectedIndex].value;
            if(v==="%"){
                $('.lijstOverzicht').removeClass('d-none');

            }else{
                $('.lijstOverzicht').addClass('d-none');
                $('.'+v).removeClass('d-none');
            }
        }
        //filter op kolom
        $('.filterKolom').on('click',"th", function() {
            let value = $(this).closest('th').data('value');
            if(value){
                $('form').attr('action', `/getSorted/${value}`);
                $('form').submit();
            }
        });

            //delete expense
        function loadDeleteModal(id, name,type) {
            var r,t;
                if(type==="e"){
                r="/expense_allowances";
                t="Onkostennota aanvraag verwijderen?";
            }else{
                    if(type==="l"){
                        r="/laptop_allowances";
                        t="Laptopvergoeding aanvraag verwijderen?";
                    }else{
                        if(type==="b"){
                            r="/bike_allowances";
                            t="Fietsvergoeding aanvraag verwijderen?";

                        }
                    }
            }
            $('.modal-title').html(t);
            $('#modal-name').html(name);
            $('#modal-confirm_delete').attr('onclick', `confirmDelete(${id},"${r}")`);
            $('#delete').modal('show');
        }

        function confirmDelete(id,r) {

            url= '\{\{ url("'+r+'")\}\}' ;
            $.ajax({
                url: r+ '/' + id,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'delete',
                },
                success: function (data) {
                    // Success logic goes here..!
                    $('#delete').modal('hide');
                    location.reload(true);
                },
                error: function (error) {
                    // Error logic goes here..!
                }
            });
        }

    </script>

@endsection
@extends('layouts.template')
@section('title','Onkostennota\'s')
@section('main')
    <div class="col-12  col-lg-10 m-auto bg-white shadow-sm p-3 mb-5 rounded">
    <div class="d-flex flex-wrap justify-content-between"><h1 class="">Onkostennota's</h1>
        <a data-toggle="tooltip" data-placement="top" href="/request_menu" class="align-self-center btn btn-outline-primary" title="Nieuwe aanvraag" aria-pressed="true">
            <i class="fas fa-plus-circle mr-1"></i>Nieuwe aanvraag
        </a>
    </div>
        <div class="bg-light">
            Hint:   <span> <i class="text-info fas fa-square"></i> Algemene onkosten |
        </span>
            <span> <i class="text-orangered fas fa-laptop"></i> Laptopvergoeding |
        </span>
            <span> <i class="text-success fas fa-biking"></i> Fietsvergoeding
        </span>
        </div>
        <br>
{{--    status filter--}}
    <form class="row" method="get" action="/expense_allowances" id="searchForm">
        @csrf

        <select class="form-control w-25 m-2" name="status_id" id="status_id">
        <option value="%">Kies status</option>
        @foreach($statuses as $status)
            <option value="{{ $status->id }}"
{{--                    combo box opvullen--}}
                {{ (request()->status_id ==  $status->id ? 'selected' : '') }}>{{ ucfirst($status->name) }}</option>
        @endforeach
        </select>
        <select class="form-control w-25 m-2" name="cost_center_id" id="cost_center_id">
        <option value="%">Kies kostenplaats</option>
        @foreach($cost_centers as $cost_center)
            <option value="{{ $cost_center->id }}"
{{--                    combo box opvullen--}}
                {{ (request()->cost_center_id ==  $cost_center->id ? 'selected' : '') }}>{{ ucfirst($cost_center->name) }}</option>
        @endforeach
        </select>
        <select class="form-control w-25 m-2" name="type_v" id="type_v">
        <option value="%">Kies soort vergoeding</option>
            <option value="expense"
                {{ (request()->type_v == "expense" ? 'selected' : '') }}><i class="text-danger fas fa-square"></i>Algemene onkosten</option>
        <option value="laptop"
                {{ (request()->type_v == "laptop" ? 'selected' : '') }}>Laptopvergoeding</option>
        <option value="bike"
                {{ (request()->type_v == "bike" ? 'selected' : '') }}>Fietsvergoeding</option>
    </select>
    </form>
{{--        And $bike_allowances->count()== 0--}}
    @if ($expense_allowances->count() == 0 And $laptop_allowances->count() == 0)
            <div class="alert alert-danger alert-dismissible fade show">
                Geen onkostennota's gevonden :(
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
{{--    table--}}

        <table class="table table-striped">
        <thead class="thead-mlight expense">
        <tr class="filterKolom border-left b-custom ">
            <th scope="col" class="sticky-th" title="Sorteer"  data-toggle="tooltip" data-value="created_at"><i class="fas fa-sort-amount-down"></i> Indiendatum</th>
{{--            <th scope="col">Totaalbedrag</th>--}}
            <th scope="col" class="sticky-th">Titel</th>
            <th scope="col" class="sticky-th" title="Sorteer"  data-toggle="tooltip" data-value="cost_center_id"><i class="fas fa-sort-amount-down"></i> Kostenplaats</th>
            <th scope="col" class="sticky-th" >Bedrag</th>
            <th scope="col" class="sticky-th" title="Sorteer"  data-toggle="tooltip" data-value="status_id"><i class="fas fa-sort-amount-down-alt"></i> Status</th>
            <th scope="col" class="sticky-th" title="Sorteer"  data-toggle="tooltip" data-value="approval_date"><i class="fas fa-sort-amount-down"></i> Keuringdatum</th>
            <th scope="col"  class="sticky-th">Opm.</th>
            <th scope="col" class="sticky-th" ></th>
            <th scope="col" class="sticky-th"></th>
        </tr>
        </thead>
        <tbody>
{{--        <tr>--}}
{{--            <td colspan="9" class="expense lijstOverzicht font-weight-bolder text-center">Transport/Aankoop</td>--}}
{{--        </tr>--}}
        @foreach($expense_allowances as $expense_allowance)

        <tr class="border-left b-custom border-info expense lijstOverzicht">
            <td>{{\Carbon\Carbon::parse($expense_allowance->submission_date)->format('d-M-Y')}}</td>
{{--            <td> € {{ number_format($expense_allowance->id,2) }}</td>--}}
            <td>{{$expense_allowance->name}}</td>
            <td>{{ucfirst($expense_allowance->cost_center->name)}}</td>
            <td><i class="fas fa-info-circle" data-toggle="tooltip" title="Zie details"></i></td>
             <td>{{$expense_allowance->status->name}}</td>
            <td>{{$expense_allowance->approval_date}}</td>
            <td class="">{{$expense_allowance->comment}}</td>
            <input id="name{{$expense_allowance->id}}" value="{{$expense_allowance->name}}" hidden/>
            <td ><a href="{{ ($expense_allowance->status_id=="1"||$expense_allowance->status_id=="4")?"/expense_allowances/".$expense_allowance->id."/edit":"#!" }}" data-toggle="tooltip" data-placement="top" title="wijzigen" class="{{ ($expense_allowance->status_id=="1"||$expense_allowance->status_id=="4")?"d-block":"d-none" }}"><i class="text-dark fas fa-edit"></i></a></td>
            <td>
                <a onclick="loadDeleteModal({{ $expense_allowance->id }}, `vergoeding aanvraag voor {{ $expense_allowance->name }}`,'e')" id="{{$expense_allowance->id}}" data-toggle="tooltip" data-placement="top" title="Verwijderen" class="{{ ($expense_allowance->status_id=="1"||$expense_allowance->status_id=="4")?"d-block":"d-none" }}" ><i class="text-danger far fa-trash-alt"></i></a>
                </td>
        </tr>
        @endforeach
{{--        <tr>--}}
{{--            <td colspan="9" class="laptop lijstOverzicht font-weight-bolder text-center">Laptopvergoeding</td>--}}
{{--        </tr>--}}
        @foreach($laptop_allowances as $laptop_allowance)
<tr class="border-left b-custom border-orangered laptop lijstOverzicht">

                <td>{{\Carbon\Carbon::parse($laptop_allowance->created_at)->format('d-M-Y')}}</td>
                <td>{{$laptop_allowance->laptop->brand}} {{$laptop_allowance->laptop->name}}</td>
                <td>{{ucfirst($laptop_allowance->cost_center->name)}}</td>
                <td class="text-right"> €{{ number_format($laptop_allowance->laptop->price,2) }}</td>
                <td>{{$laptop_allowance->status->name}}</td>
                <td>{{$laptop_allowance->approval_date}}</td>
                <td class="">{{$laptop_allowance->comment}}</td>
                <input id="name{{$laptop_allowance->id}}" value="{{$laptop_allowance->name}}" hidden/>
                <td ><a href="{{ ($laptop_allowance->status_id=="1"||$laptop_allowance->status_id=="4")?"/laptop_allowances/".$laptop_allowance->id."/edit":"#!" }}" data-toggle="tooltip" data-placement="top" title="wijzigen" class="{{ ($laptop_allowance->status_id=="1"||$laptop_allowance->status_id=="4")?"d-block":"d-none" }}"><i class="text-dark fas fa-edit"></i></a></td>
                <td>
                    <a onclick="loadDeleteModal({{ $laptop_allowance->id }}, `laptopvergoeding aanvraag voor {{$laptop_allowance->laptop->brand}} {{$laptop_allowance->laptop->name}}`,'l')" id="{{$laptop_allowance->id}}" data-toggle="tooltip" data-placement="top" title="Verwijderen" class="{{ ($laptop_allowance->status_id=="1"||$laptop_allowance->status_id=="4")?"d-block":"d-none" }}" ><i class="text-danger far fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
{{--        <tr>--}}
{{--            <td colspan="9" class="bike lijstOverzicht font-weight-bolder text-center bg-white">Fietsvergoeding</td>--}}
{{--        </tr>--}}
        </tbody>
    </table>
{{--    EA = Expense Allowance--}}
    <div class="modal fade" id="delete" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="delete" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Wilt u <b><span id="modal-name"></span></b> zeker verwijderen?
                    <input type="hidden" id="allowance" name="a_id">
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="modal-confirm_delete">Verwijder</button>
                    <button type="button" class="btn bg-white" data-dismiss="modal">Annuleren</button>
                </div>
            </div>
        </div>
    </div>
    </div><br><br>
@endsection
