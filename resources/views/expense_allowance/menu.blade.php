@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
        });


    </script>

@endsection
@extends('layouts.template')
@section('title','Onkostennota | aanvraag')
@section('main')
    @csrf
    <div class="d-flex flex-wrap justify-content-around"><h2 class="">Kies soort aanvraag:</h2>
          </div>
        <div class=" d-flex flex-wrap justify-content-around col-lg-6 m-auto bg-light font-weight-bold">

                <a href="/expense_allowances/create"   type="button" class="col-5 mb-2 btn btn-primary"><i class="fas fa-dolly"></i> Algemene onkosten</a>
                 <a href="/laptop_allowances/create"  type="button" class="col-5 mb-2 btn btn-orangered"> <i class="fas fa-laptop"></i> Laptopvergoeding</a>

                 <a href="/bicycle_allowance/create"  type="button" class="col-5 mb-2 btn btn-success"><i class="fas fa-biking"></i> Fietsvergoeding</a>
                <a href="/expense_allowances" type="button" class=" col-5 mb-2 btn btn-outline-danger"><i class="far fa-window-close"></i> Annuleren</a>



        </div>
        </div>


@endsection
