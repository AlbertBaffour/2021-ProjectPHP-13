@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            $('#approval_value').val("3");
            // submit form when changing dropdown list 'id'
            $('#status_id').change(function () {
                $('#searchForm').submit();
            });
            $('.approval-none').addClass('d-none');
            $('.approval-disabled').prop('readonly', true);
            //als die al betaald is
            if(JSON.parse("{{ json_encode($laptop_allowance->status_id) }}")===3){
                $('.paid').attr('hidden',true);
            }
        });
        // keuring
        $(document.getElementsByName('approval')).change( function () {
            if (document.getElementById('goedkeuren').checked===true) {

                $('#approval_value').val("3");
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
    <div class="d-flex flex-wrap justify-content-around"><h4 class="">Laptopvergoeding > Betaling</h4>
    </div>
    @include('shared.alert')
    <Form class="pb-5 shadow  p-3 col-10 m-auto"  id="LForm" action="/payment_review/{{$laptop_allowance->id}}/update2" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-group ">
            <label class="font-weight-bold">Goedgekeurd door:</label>
            <label>{{$cost_center_manager->first_name??""}} {{$cost_center_manager->last_name??""}} </label>
        </div>
        <div class="form-group">
            <label class="font-weight-bold">Betaling uitgevoerd door:</label>
            <label>{{($financial_manager->first_name)??""}} {{$financial_manager->last_name??""}} </label>
        </div>
        @include('laptop_allowance.form')


{{--opmerking--}}
        <hr>
        <div class="paid">
        <div class="d-flex p-2 mt-4">
        <div class="col-6">
        <input class="col-2" type="radio" name="approval" id="goedkeuren" value="goekeuren" checked><label class="col-10" for="goedkeuren">Betalen</label>
            <input class="col-2" type="radio" name="approval" id="afkeuren" value="afkeuren"><label class="col-10" for="afkeuren">Afkeuren</label>

             </div>
            <div class="col-6 m-auto opmerking" > <label for="comment">Opmerking</label>
                <textarea class="form-control " name="comment" id="comment" placeholder="Indien van toepassing" rows="2">{{$laptop_allowance->comment}}</textarea>
                <input hidden type="text" id="approval_value" name="approval_value" value="">
            </div>
            </div></div>
            <div class="d-flex p-2 mt-4">
        <div class="col-6 paid">

            <button type="submit" class="col-12 m-2 btn btn-primary">Bevestig</button>
            </div>
            <div class="col-6 m-auto opmerking" >

                <button class="col-12  btn btn-secondary m-2 " ><a class="text-light text-decoration-none" href="/payment_review">Terug naar overzicht</a></button>
            </div>
            </div>

        </Form>
        </div>
    @endsection
