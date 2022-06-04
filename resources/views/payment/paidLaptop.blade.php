@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            $('#approval_value').val("2");
            // submit form when changing dropdown list 'id'

        });

    </script>
@endsection
@extends('layouts.template')
@section('title','Onkostennota\'s')
@section('main')
    <div class="col-12 col-lg-8 m-auto bg-white shadow-sm p-3 pb-5 mb-5 rounded">
    <div class="d-flex flex-wrap justify-content-between"><h4 class="">Laptopvergoeding > Betaling > Betaling verwerken</h4>

    </div>

        <dl>
            <dt>Naam:</dt>
            <dd> {{($laptop_allowance?$laptop_allowance->user->first_name:'')}} {{($laptop_allowance?$laptop_allowance->user->last_name:'')}}</dd>
            <dt>Rekeningnummer:</dt>
            <dd>{{$laptop_allowance?$laptop_allowance->user->account_number:''}}</dd>
            <dt>Mededeling:</dt>
            <dd>{{$laptop_allowance?$laptop_allowance->laptop->brand:''}} {{$laptop_allowance?$laptop_allowance->laptop->name:''}}</dd>
{{--            <dt>Bedrag:</dt>--}}
{{--            <dd></dd>--}}
        </dl>
        <button class="col-12  btn btn-secondary m-2 " ><a class="text-light text-decoration-none" href="/payment_review">Terug naar overzicht</a></button>


    </div>
    @endsection
