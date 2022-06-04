@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
           // $('#date').datepicker().datepicker("setDate", new Date());
        });

        //make extra upload
        var proof_id_nr=1;
        if (proof_id_nr<3)
        $('#extraProof').click( function() {
            if (proof_id_nr<4){
        $('#proofBox').append('<div class="d-flex mb-2" id="proof_line'+proof_id_nr+'">' +
            '<div id="proof'+proof_id_nr+'" class="col-11 ">\n' +
            '          <input type="file" name="filenames[]" class="form-control" >\n' +
            '</div>' +
            '<div class="col-1">' +
            '<button type="button" id="'+proof_id_nr+'" class="proofClose close ml-1 mt-1">\n' +
            '                <span aria-hidden="true">&times;</span>\n' +
            '            </button></div> </div>');
        if (proof_id_nr>1){
            $("#proofTitle").text("Bewijzen")
        }
        proof_id_nr++;
            }
        });
        $('#proofBox').on('click','.proofClose', function() {
            var id = "proof_line"+this.id;
            var element = document.getElementById(id);
            element.parentNode.removeChild(element);
            proof_id_nr--;
            if (proof_id_nr<=2){
                $("#proofTitle").text("Bewijs")
            }
        });
        //form build
        //type expense
        $(document.getElementsByName('typeExpense')).change( function () {
            if (document.getElementById('transport').checked===true) {
               document.getElementById('transportField').style.display = 'block';
                $('#purchaseField').addClass('d-none');
            } else {
                $('#purchaseField').removeClass('d-none');
                document.getElementById('transportField').style.display = 'none';
            }
        })
        // type verplaatsing
        $(document.getElementsByName('typeTransport')).change( function () {
            if (document.getElementById('car').checked===true) {

                $('.carField').attr('hidden',false);
                $('.trainField').attr('hidden',true);
            } else {
                $('.carField').attr('hidden',true);
                $('.trainField').attr('hidden',false);
            }
        });
        //controles en submit
        $('#addExpense').click(function() {
            if (document.getElementById('purchase').checked===true){
                document.getElementById("cost").name="cost";
                document.getElementById("productName").name="name";
                document.getElementById("ticketPrice").name="";
                document.getElementById("purchaseDescription").name="description";
                document.getElementById("descriptionCar").name="";
                document.getElementById("descriptionTrain").name="";
                document.getElementById("km").name="";
                if (document.getElementById("productName").value.trim()===""){
                    $('#productName').addClass('border-danger');$('#cost').removeClass('border-danger');
                }else{
                    if (document.getElementById("cost").value.trim()==="" || isNaN( document.getElementById("cost").value.trim() )){
                        $('#productName').removeClass('border-danger');$('#cost').addClass('border-danger');
                    }else{
                        if (document.getElementById("purchaseDescription").value.trim()===""){
                            $('#purchaseDescription').addClass('border-danger');$('#cost').removeClass('border-danger');
                        }
                        else{
                            document.getElementById("expenseForm").submit();
                        }

                    }
                }

            }
            else {
                if (document.getElementById('transport').checked===true){
                    if (document.getElementById("car").checked===true){
                        document.getElementById("productName").name="";
                        document.getElementById("cost").name="";
                        document.getElementById("ticketPrice").name="";
                        document.getElementById("purchaseDescription").name="";
                        document.getElementById("descriptionCar").name="description";
                        document.getElementById("descriptionTrain").name="";
                        document.getElementById("km").name="km";
                        document.getElementById("carCheck").name="car";
                        if (document.getElementById("km").value.trim()==="" || isNaN( document.getElementById("km").value.trim() )){
                            $('#descriptionCar').removeClass('border-danger');$('#km').addClass('border-danger');
                        }else{
                            if (document.getElementById("descriptionCar").value.trim()===""){
                                $('#descriptionCar').addClass('border-danger');$('#km').removeClass('border-danger');
                            }
                            else{
                                document.getElementById("expenseForm").submit();
                            }
                        }
                    }else{
                        document.getElementById("productName").name="";
                        document.getElementById("cost").name="";
                        document.getElementById("ticketPrice").name="cost";
                        document.getElementById("purchaseDescription").name="";
                        document.getElementById("descriptionCar").name="";
                        document.getElementById("descriptionTrain").name="description";
                        document.getElementById("km").name="";
                        if (document.getElementById("ticketPrice").value.trim()==="" || isNaN( document.getElementById("ticketPrice").value.trim() )){
                            $('#descriptionTrain').removeClass('border-danger');$('#ticketPrice').addClass('border-danger');
                        }else{
                            if (document.getElementById("descriptionTrain").value.trim()===""){
                                $('#descriptionTrain').addClass('border-danger');$('#ticketPrice').removeClass('border-danger');
                            }
                            else {
                                document.getElementById("expenseForm").submit();
                            }
                        }
                    }

                }
            }
        });


    </script>

@endsection
@extends('layouts.template')
@section('title','Onkostennota | aanvraag')
@section('main')
    @csrf
    <div class="d-flex flex-wrap justify-content-around"><h1 class="">Onkostennota</h1>
          </div>

    <hr>

        <div class="mb-5 pb-5 col-12 col-lg-8 m-auto shadow-sm">
        <div class="p-4 m-auto bg-light font-weight-bold">
            <Form id="expenseForm" action="/expenses" method="post" enctype="multipart/form-data">
            @csrf
        <div class="col-12">
            <label class="" for="title">Titel:</label>
            <input class="border-0 col-3 bg-light" type="text" id='title' name='title' value="{{$expense_allowance->name}}" readonly placeholder="">

        <!-- For defining autocomplete -->
        <label class="" for="cost_center_search">Kostenplaats:</label>
        <input class="col-3 border-0 bg-light" type="text" id='cost_center_search' value="{{$expense_allowance->cost_center->name}}" readonly name='cost_center_search' placeholder="zoek kostenplaats">
{{--Parameters--}}
        <!-- For displaying selected option value from autocomplete suggestion -->
        <input type="text" id='cost_center_id' value="{{$expense_allowance->cost_center_id}}" hidden>
        <input type="text" name='expense_allowance_id' value="{{$expense_allowance->id}}" hidden>
        <input type="text" id='carCheck' value="0" hidden>

        </div>


            <div id="onkost_body" class="shadow bg-white p-2">
        <h3 class="m-4">Onkost:</h3>
        <div><div class="d-flex flex-wrap">
                <div class="col-7">
                    <label for="type" class="col-12 m-auto pr-2">Type onkost:</label>
                    <input class="col-2" type="radio" name="typeExpense" id="transport" value="transport" checked><label class="col-10" for="transport">Verplaatsing</label>
                    <input class="col-2" type="radio" name="typeExpense" id="purchase" value="purchase"><label class="col-10" for="purchase">Aankoop</label>

                </div>
                <div class="col-5"><label for="date">Datum:</label>
                    <input class="col-12" type="date" id="date" name="date" >
                    @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <hr>
            <div id="transportField">
                <div class="d-flex flex-wrap" >
                    <div class="col-2 m-auto"><input type="radio" name="typeTransport" id="car" value="auto" checked>
                        <label for="car">Auto</label></div>
                        <div class="col-5 m-auto">
                            <label class="d-block" for="km">Aantal km: </label>
                            <input id="km" type="text" class="carField">
                            @error('km')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    <div class="col-5 m-auto"><label for="descriptionCar">Omschrijving: </label>
                        <textarea class="form-control carField" id="descriptionCar" placeholder="van ... naar ..."  rows="1"></textarea>
                        @error('descriptionCar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            <hr>
            <div class="d-flex flex-wrap">
                    <div class="col-2 m-auto"><input type="radio" name="typeTransport" id="train" value="train"><label for="train">Trein: </label>
                    </div>
                <div class="col-5 m-auto"> <label for="ticketPrice" class="d-block">Prijs van het ticket (€): </label>
                    <input id="ticketPrice" type="text" hidden class="trainField">
                    @error('ticketPrice')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                    <div class="col-5 m-auto"> <label for="descriptionTrain">Omschrijving: </label>
                        <textarea class="form-control trainField" hidden id="descriptionTrain" placeholder="van ... naar ..." rows="1"></textarea>
                        @error('descriptionTrain')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="purchaseField" class="d-none">
            <div class="d-flex flex-wrap">
                <div class="col-7 m-auto"> <label for="productName" class="d-block" >Naam Product: </label>
                    <input id="productName" type="text" class="d-block">
                    @error('productName')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                   <label for="cost" class="d-block">Kost (€): </label>
                    <input id="cost" type="text" class="d-block">
                    @error('cost')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-5 m-auto"><label for="purchaseDescription">Omschrijving: </label>
                    <textarea class="form-control" id="purchaseDescription" rows="2"></textarea>
                    @error('purchaseDescription')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            </div>
        </div>

        <hr>
{{--Bewijs toevoegen--}}
        <div class="font-weight-bold ml-4">
            <label id="proofTitle" class="d-block">Bewijs: </label>
            <a data-toggle="tooltip" data-placement="top" id="extraProof" class="btn" title="bewijs toevoegen" aria-pressed="true">
                <i class="fas fa-plus"></i></a>
        </div>
        <div id="proofBox" class="m-auto w-75">

        </div>
        <hr>
        <button id="addExpense" type="button" class="col-4 btn btn-primary">Onkost toevoegen</button>
    </div>
            </Form>
        </div>
        {{--    table--}}
        <div id="onkosten_table" class="p-3  bg-light" >
            <h3>Onkosten:</h3>
        <table class="table table-striped ">
            <thead class="thead-mlight">
            <tr>
                <th scope="col">Bedrag</th>
                <th scope="col">Omschrijving</th>
                <th scope="col">Aantal km</th>
                <th scope="col">Datum</th>
            </tr>
            </thead>
            <tbody>
            @if(count($expenses)>0)
            @foreach($expenses as $expense)
                <tr>
                   <td>€ {{ number_format($expense->cost,2)}}</td>
                    <td>{{ucfirst($expense->description)}}</td>
                    <td>{{$expense->total_km}}</td>
                    <td>{{\Carbon\Carbon::parse($expense->date)->format('d-M-Y')}}</td>
                </tr>
            @endforeach
            @endif
            <thead class="thead-dark">
            <tr>
                <th colspan="4" class="font-weight-bold">Totaalbedrag</th>
            </tr>
            </thead>
            <tr>
                <td colspan="4" class="font-weight-bold"> € {{ number_format($expenses->sum('cost'),2)}}</td>
            </tr>
            </tbody>
        </table>
            <div class="d-flex flex-wrap justify-content-around">
                <a type="button" href="/expense_allowances" class="col-4   btn btn-primary">Afronden</a>
{{--                <a href="/expense_allowances" class="col-4 btn text-danger btn-outline-danger text-decoration-none text-light">Annuleren</a>--}}
            </div>
        </div>
        </div>

@endsection
