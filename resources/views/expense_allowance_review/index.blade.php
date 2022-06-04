@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            filterOpType();
            // submit form when changing dropdown list 'id'
            $('#searchForm').change(function () {
                $('#searchForm').submit();
            })
            $('#name').blur(function () {
                $('#searchForm').submit();
            })
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
        $('.table').removeClass('d-none');
    </script>
@endsection
@extends('layouts.template')
@section('title','Onkostennota\'s')
@section('main')
    <div class="col-12 col-lg-10 m-auto bg-white shadow-sm p-3 mb-5 rounded">
    <div class="float-lg-right">  Hint:   <span> <i class="text-info fas fa-square"></i> Algemene onkosten |
        </span>
        <span> <i class="text-orangered fas fa-laptop"></i> Laptopvergoeding |
        </span>
        <span> <i class="text-success fas fa-biking"></i> Fietsvergoeding
        </span>
    </div>
        <div class="d-flex flex-wrap justify-content-between"><h1 class="">Onkostennota's keuren</h1>
        </div>

{{--    status filter--}}
    <form method="get" action="/expense_allowance_review" id="searchForm">
        @csrf

    <div class="d-flex p-2 flex-wrap">
        <div class="col-4">
            <label for="name">Naam(Medewerker)</label>
            <input type="text" class="form-control" name="name" id="name"
                   value="{{ request()->name }}"
                   placeholder="Zoek op voornaam of achternaam">
        </div>
        <div class="col-4">
            <label for="status_id">Status</label>
        <select class="form-control " name="status_id" id="status_id">
        <option value="%">Kies status</option>
        @foreach($statuses as $status)
            <option value="{{ $status->id }}"
{{--                    combo box opvullen--}}
                {{ (request()->status_id ==  $status->id ? 'selected' : '') }}>{{ ucfirst($status->name) }}</option>
        @endforeach
    </select></div><div class="col-4">
            <label for="status_id">Kostenplaats</label>
        <select class="form-control " name="cost_center_id" id="cost_center_id">
        <option value="%">Kies kostenplaats</option>
        @foreach($cost_centers as $cost_center)
            <option value="{{ $cost_center->id }}"
{{--                    combo box opvullen--}}
                {{ (request()->cost_center_id ==  $cost_center->id ? 'selected' : '') }}>{{ ucfirst($cost_center->name) }}</option>
        @endforeach
    </select></div>

        <div class="col-4"><br>
            <label for="type_v">Soort vergoeding</label>
            <select class="form-control " name="type_v" id="type_v">
                <option value="%">Kies soort vergoeding</option>
                <option value="expense"
                    {{ (request()->type_v == "expense" ? 'selected' : '') }}><i class="text-danger fas fa-square"></i>Algemene onkosten</option>
                <option value="laptop"
                    {{ (request()->type_v == "laptop" ? 'selected' : '') }}>Laptopvergoeding</option>
                <option value="bike"
                    {{ (request()->type_v == "bike" ? 'selected' : '') }}>Fietsvergoeding</option>
            </select>
        </div>
    </div>
    </form>
        @if ($expense_allowances->count() == 0 And $laptop_allowances->count() == 0)
            <div class="alert alert-danger alert-dismissible fade show">
                Geen onkostennota's gevonden :(
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

{{--    table--}}

        <table class="table d-none table-striped ">
        <thead class="thead-mlight">
        <tr>
            <th scope="col">Indiendatum</th>
{{--            <th scope="col">Totaalbedrag</th>--}}
            <th scope="col">Naam(Medewerker)</th>
            <th scope="col">Titel</th>
            <th scope="col">Kostenplaats</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>

        @foreach($expense_allowances as $expense_allowance)

        <tr class="border-left b-custom border-info expense lijstOverzicht">
            <td>{{\Carbon\Carbon::parse($expense_allowance->submission_date)->format('d-M-Y')}}</td>
{{--            <td> € {{ number_format($expense_allowance->id,2) }}</td>--}}
            <td>{{$expense_allowance->user->first_name . " ".$expense_allowance->user->last_name}} </td>
            <td>{{$expense_allowance->name}}</td>
            <td>{{ucfirst($expense_allowance->cost_center->name)}}</td>
            <td>{{$expense_allowance->status->name}}</td>
            <input id="name{{$expense_allowance->id}}" value="{{$expense_allowance->name}}" hidden/>
            <td ><a href="{{$expense_allowance->status_id=="3"?'#!': 'expense_allowance_review/'.$expense_allowance->id.'/edit'}}" data-toggle="tooltip" data-placement="top" title="Keuren" class=""><i class="{{$expense_allowance->status_id=="3"?'':'fas fa-check-double text-dark'}}"></i></a></td>
        </tr>
        @endforeach
        @foreach($laptop_allowances as $laptop_allowance)

        <tr class="border-left b-custom border-orangered laptop lijstOverzicht">
            <td>{{\Carbon\Carbon::parse($laptop_allowance->created_at)->format('d-M-Y')}}</td>
{{--            <td> € {{ number_format($expense_allowance->id,2) }}</td>--}}
            <td>{{$laptop_allowance->user->first_name . " ".$laptop_allowance->user->last_name}} </td>
            <td>{{$laptop_allowance->laptop->brand}} {{$laptop_allowance->laptop->name}}</td>
            <td>{{ucfirst($laptop_allowance->cost_center->name)}}</td>
            <td>{{$laptop_allowance->status->name}}</td>
            <input id="name{{$laptop_allowance->id}}" value="{{$laptop_allowance->id}}" hidden/>
            <td ><a href="{{$laptop_allowance->status_id=="3"?'#!':('expense_allowance_review/'.$laptop_allowance->id.'/edit2')}}" data-toggle="tooltip" data-placement="top" title="Keuren" class=""><i class="{{$laptop_allowance->status_id=="3"?'':'fas fa-check-double text-dark'}}"></i></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>

    </div>

@endsection
