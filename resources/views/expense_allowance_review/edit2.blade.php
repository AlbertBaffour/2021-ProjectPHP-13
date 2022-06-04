@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            $('#approval_value').val("2");
            // submit form when changing dropdown list 'id'
            $('#status_id').change(function () {
                $('#searchForm').submit();
            });
            $('.approval-none').addClass('d-none');
            $('.approval-disabled').prop('readonly', true);
        });
        // keuring
        $(document.getElementsByName('approval')).change( function () {
            if (document.getElementById('goedkeuren').checked===true) {

                $('#approval_value').val("2");
            } else {
                $('#approval_value').val("4");
            }
        });


    </script>
@endsection
@extends('layouts.template')
@section('title','Onkostennota\'s')
@section('main')

    <div class="col-12 col-lg-10 m-auto bg-white shadow-sm p-3 mb-5 rounded">
    <div class="d-flex flex-wrap justify-content-around"><h4 class="">Laptopvergoeding > Keuring</h4>
    </div>
    @include('shared.alert')
    <Form class="pb-5 shadow  p-3 col-10 m-auto"  id="LForm" action="/expense_allowance_review/{{$laptop_allowance->id}}/update2" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('laptop_allowance.form')


{{--opmerking--}}
        <hr>
        <div class="d-flex p-2 mt-4">
        <div class="col-6">
        <input class="col-2" type="radio" name="approval" id="goedkeuren" value="goekeuren" checked><label class="col-10" for="goedkeuren">Goedkeuren</label>
            <input class="col-2" type="radio" name="approval" id="afkeuren" value="afkeuren"><label class="col-10" for="afkeuren">Afkeuren</label>

             </div>
            <div class="col-6 m-auto opmerking" > <label for="comment">Opmerking</label>
                <textarea class="form-control " name="comment" id="comment" placeholder="Indien van toepassing" rows="2">{{$laptop_allowance->comment}}</textarea>
                <input hidden type="text" id="approval_value" name="approval_value" value="">
            </div>
            </div>
            <div class="d-flex p-2 mt-4">
        <div class="col-6">

            <button type="submit" class="col-12 m-2 btn btn-primary">Bevestig</button>
            </div>
            <div class="col-6 m-auto opmerking" >

                <button class="col-12  btn btn-secondary m-2 " ><a class="text-light text-decoration-none" href="/expense_allowance_review">Terug naar overzicht</a></button>
            </div>
            </div>

        </Form>
        </div>
    @endsection
