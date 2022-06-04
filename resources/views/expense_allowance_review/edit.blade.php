@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            $('#approval_value').val("2");
            // submit form when changing dropdown list 'id'
            $('#status_id').change(function () {
                $('#searchForm').submit();
            })
        });
        //view expense
        $(document).on('click',".view_expense", function() {

                // Get data attributes from td tag
                let cost = $(this).closest('td').data('cost');
                let total_km = $(this).closest('td').data('total_km');
                let description = $(this).closest('td').data('description');
                let date = $(this).closest('td').data('date');
                //form aanpassen
                 $('#cost').val(cost);
                $('#description').val(description);
                $('#total_km').val(total_km);
                $('#date').val(date);


        }); // keuring
        $(document.getElementsByName('approval')).change( function () {
            if (document.getElementById('goedkeuren').checked===true) {

                $('#approval_value').val("2");
            } else {
                $('#approval_value').val("4");
            }
        });
        //get proofs
        $(document).ready(function(){
            // Search by userid
            $(document).on('click',".view_expense", function(){
                let expense_id = $(this).closest('td').data('id');
                fetchProofs(expense_id);
            });

        });

        function fetchProofs(expense_id) {
            $.ajax({
                url: '/getProofs/' + expense_id,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    var len = 0;
                    $('#proofBox').empty(); // Empty <tbody>
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    if(len >1){
                        $('#proofTitle').text("Bewijzen :");
                    }else{
                        $('#proofTitle').text("Bewijs :");
                    }

                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var proof = response['data'][i].proof;

                            var tr_str =
                                "<div class=\"mb-2 col-11\" title='Bewijs bekijken' data-toggle=\"tooltip\" data-placement=\"top\">"+
                                "<label readonly class=\"\" for=\"proof1\" data-browse=\"\"><a target='_blank' href='/uploads/proofs/"+proof+"'>"+ proof +" <i class=\"fas fa-external-link-alt\"></i></a></label>" +

                                "</div>";


                            $("#proofBox").append(tr_str);
                        }
                    } else {
                        var tr_str = "<p>" +
                            "Geen bewijzen toegevoegd." +
                            "</p>";

                        $("#proofBox").append(tr_str);
                    }

                }
            });
        }

    </script>
@endsection
@extends('layouts.template')
@section('title','Onkostennota\'s')
@section('main')
    <div class="col-12 col-lg-8 m-auto bg-white shadow-sm p-3 pb-5 mb-5 rounded">
    <div class="d-flex flex-wrap justify-content-between"><h4 class="">Onkostennota > keuring</h4>

    </div>

{{--    table--}}
        <div class="d-flex flex-wrap">
            <div class="form-group col-3">
                <label class="font-weight-bold" >Indiendatum:</label>
                <label class="">{{\Carbon\Carbon::parse($expense_allowance->submission_date)->format('d-M-Y')}}</label>
            </div>
            <div class="form-group col-3 justify-content-start">
                <label class="font-weight-bold">Aanvrager :</label>
                <label>{{$expense_allowance->user->first_name . " ".$expense_allowance->user->last_name}} </label>
            </div>  <div class="form-group col-3 justify-content-start">
                <label class="font-weight-bold">Omschrijving:</label>
                <label>{{$expense_allowance->name}}</label>
            </div>
            <div class="form-group col-3 ">
                <label class="font-weight-bold">Kostenplaats:</label>
                <label>{{ucfirst($expense_allowance->cost_center->name)}}</label>
            </div>
        </div>
        <table class="table table-striped ">
            <h3 id="onkosten">Onkosten:</h3>
        <thead class="thead-mlight">
        <tr>
            <th scope="col">Indiendatum</th>
{{--            <th scope="col">Totaalbedrag</th>--}}
            <th scope="col">Titel</th>
            <th scope="col">Kostenplaats</th>
            <th scope="col">Status</th>
            <th scope="col"></th>

        </tr>
        </thead>
        <tbody>
        @if ($expenses->count() == 0)
            <div class="alert alert-danger alert-dismissible fade show">
                Geen onkosten gevonden :(
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
        @foreach($expenses as $expense)

            <tr>
                <td class="text-right"> € {{ number_format($expense->cost,2) }}</td>
                <td>{{$expense->description}}</td>
                <td>{{$expense->total_km}}</td>
                <td>{{\Carbon\Carbon::parse($expense->date)->format('d-M-Y')}}</td>
                <td data-id="{{$expense->id}}"
                    data-cost="{{$expense->cost}}"
                    data-total_km="{{$expense->total_km}}"
                    data-description="{{$expense->description}}"
                    data-date="{{$expense->date}}"
                    data-toggle="tooltip" data-placement="top" title="bekijken">
                    <a class="view_expense action" href="#geselecteerdOnkost">
                        <i class="fas fa-arrow-circle-down"></i>
                    </a>
                </td>

            </tr>
        @endforeach
        {{ $expenses->links() }}
        </tbody>
    </table>
    {{ $expenses->links() }}
{{--geselecteerd--}}
        <h3 id="geselecteerdOnkost">Geselecteerd onkost:</h3>
        <Form id="expenseForm" action="/expense_allowance_review/{{$expense_allowance->id}}/update"  method="post" class="mb-5" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="shadow-sm p-4 bg-light font-weight-bold">

                <h3 class="m-4">Onkost:</h3>
                <div><div class="d-flex flex-wrap">

                        <div class="col-5"><label for="date">Datum:</label>
                            <input readonly class="" type="date" id="date" name="date"
                                   value=" ">

                        </div>

                    </div>
                    <hr>
                    <div>
                        <div class="d-flex flex-wrap" >

                            <div class="col-6 m-auto"> <label class="d-block costLabel" for="km">Kost (€): </label>
                                <input readonly id="cost" type="text"
                                       value="">

                            </div>
                            <div class="col-6 m-auto"> <label class="d-block kmLabel" for="km">Aantal km (km): </label>
                                <input readonly id="total_km" type="text"
                                       value="">

                            </div>
                            <div class="col-12 mt-3 m-auto"><label class="mt-3" for="descriptionCar">Omschrijving: </label>
                                <textarea readonly class="form-control" id="description" name="description" placeholder="van ... naar ..."  rows="3"
                                ></textarea>

                            </div>

                        </div>

                    </div>
                    <hr>

                </div>

                {{--Bewijs toevoegen--}}
                <div class="font-weight-bold ml-4">

                    <label id="proofTitle" class="d-block">Bewijs: </label>

                </div>
                <div id="proofBox" class="m-auto w-75">

                       <p>Geen bewijs toegevoegd.</p>

                </div>
            </div>


{{--opmerking--}}
        <div class="d-flex p-2 mt-4">
        <div class="col-6">
        <input class="col-2" type="radio" name="approval" id="goedkeuren" value="goekeuren" checked><label class="col-10" for="goedkeuren">Goedkeuren</label>
            <input class="col-2" type="radio" name="approval" id="afkeuren" value="afkeuren"><label class="col-10" for="afkeuren">Afkeuren</label>

             </div>
            <div class="col-6 m-auto opmerking" > <label for="comment">Opmerking</label>
                <textarea class="form-control " name="comment" id="comment" placeholder="Indien van toepassing" rows="2">{{$expense_allowance->comment}}</textarea>
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

