@section('script_after')
@endsection
@extends('layouts.template')
@section('title','Fietsrit | aanvraag')
@section('main')

    @csrf
    <div class="d-flex flex-wrap justify-content-around"><h1 class="">Fietsvergoeding Aanvraag</h1>
    </div>
    @include('shared.alert')
    <Form class="pb-5 shadow  p-3 col-10 m-auto"  id="LForm" action="/bicycle_allowance" method="post" enctype="multipart/form-data">
        @csrf
        @include('bicycle_allowance.form')

        <div class="m-auto">
            <button id="addBicycleAllowance" type="submit" class="col-4 btn btn-primary">Aanvraag indienen</button>
            <a href="/request_menu" type="button" class="col-3 btn btn-outline-danger">Annuleren</a>
        </div>

    </Form>

    </div>


@endsection
