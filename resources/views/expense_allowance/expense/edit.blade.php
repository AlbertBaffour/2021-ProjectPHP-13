@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            if(document.getElementById("km").value.trim()==="0"){
                $('#km').addClass('d-none');
                document.getElementById("cost").name="cost";
            }else{
                $('#cost').addClass('d-none');
                document.getElementById("km").name="km";
            }
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
                        '            </button></div>\n   </div>');
                    if (proof_id_nr>1){
                        $("#proofTitle").text("Bewijzen:")
                    }
                    proof_id_nr++;
                }
            });
        $('#proofBox').on('click','.proofClose', function() {
            var cla = "proof_line"+this.id;
            var element = document.getElementById(cla);
            element.parentNode.removeChild(element);
            proof_id_nr--;
            if (proof_id_nr<=2){
                $("#proofTitle").text("Bewijs(zen): ")
            }
        });

        //controles en submit
        $('#saveExpense').click(function() {

                if (document.getElementById('km').value.trim()==="0"){
                    $('#cost').addClass('d-none');$('#cost').removeClass('border-danger');
                    if (document.getElementById("cost").value.trim()==="" || isNaN( document.getElementById("cost").value.trim() )){
                        $('#description').removeClass('border-danger');$('#cost').addClass('border-danger');
                    }else{
                        if (document.getElementById("description").value.trim()===""){
                            $('#description').addClass('border-danger');$('#cost').removeClass('border-danger');
                        }
                        else{
                            document.getElementById("expenseForm").submit();
                        }

                    }

                }else{
                    if (document.getElementById("km").value.trim()==="" || isNaN( document.getElementById("cost").value.trim() )){
                        $('#description').removeClass('border-danger');$('#km').addClass('border-danger');
                    }else{
                        if (document.getElementById("description").value.trim()===""){
                            $('#description').addClass('border-danger');$('#km').removeClass('border-danger');
                        }
                        else{
                            document.getElementById("expenseForm").submit();
                        }

                    }
                }

        });
    </script>
@endsection
@extends('layouts.template')
@section('title','Onkostennota wijzigen')
@section('main')
    <div class="col-12 col-lg-8 m-auto bg-white">
    <div class="d-flex flex-wrap justify-content-around"><h1 class="">Onkostennota wijzigen</h1>
    </div>
    <div class="d-flex flex-wrap">
        <div class="form-group col-md-4 col-lg-3">
            <label class="font-weight-bold">Indiendatum:</label>
            <label class="">{{\Carbon\Carbon::parse($expense_allowance->submission_date)->format('d-M-Y')}}</label>
        </div>
        <div class="form-group col-md-5 col-lg-9 justify-content-start">
            <label class="font-weight-bold">Omschrijving:</label>
            <label>{{$expense_allowance->name}}</label>
        </div>
        <div class="form-group col-md-3 col-lg-12">
            <label class="font-weight-bold">Kostenplaats:</label>
            <label>{{ucfirst($expense_allowance->cost_center->name)}}</label>
        </div>
    </div>
    {{--    table--}}

    <h3>Geselecteerd onkost:</h3>
    <Form id="expenseForm" action="/expenses/{{$expense->id}}"  method="post" class="mb-5" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="p-4 bg-light font-weight-bold">

            <h3 class="m-4">Onkost:</h3>
            <div><div class="d-flex flex-wrap">

                    <div class="col-5"><label for="date">Datum:</label>
                        <input class="" type="date" id="date" name="date"
                               value="{{ old('date', $expense->date) }}">
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <hr>
                <div>
                    <div class="d-flex flex-wrap" >

                        <div class="col-6 m-auto"> <label class="d-block costLabel" for="km">Kost (€): </label>
                            <input id="cost" type="text"
                                   value="{{ old('cost', number_format($expense->cost,2)) }}">
                            @error('cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6 m-auto"> <label class="d-block kmLabel" for="km">Aantal km (km): </label>
                            <input id="km" type="text"
                                   value="{{ old('km', $expense->total_km) }}">
                            @error('km')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mt-3 m-auto"><label class="mt-3" for="descriptionCar">Omschrijving: </label>
                            <textarea class="form-control carField" id="description" name="description" placeholder="van ... naar ..."  rows="3"
                            >{{ old('description', $expense->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>
                <hr>

            </div>

            {{--Bewijs toevoegen--}}
            <div class="font-weight-bold ml-4">
                <label id="proofTitle" class="d-block">Bewijs: </label>
                <a data-toggle="tooltip" data-placement="top" id="extraProof" class="btn" title="bewijs toevoegen" aria-pressed="true">
                    <i class="fas fa-plus"></i></a>
            </div>
            <div id="proofBox" class="m-auto w-75">
                @foreach($proofs as $proof)
                   <br> <a target='_blank' href='/uploads/proofs/{{ old('proof',$proof->proof)}}'> {{ old('proof',$proof->proof)}} <i class="fas fa-external-link-alt"></i> </a>

{{--                    <div class="d-flex"><div class="mb-2 col-11 custom-file">--}}

{{--                            <input disabled type="file" name="filenames[]" class="custom-file-input" id="proof1">--}}
{{--                                  </div><div class="col-1">--}}
{{--                            --}}{{--                                    <button type="button" id="1" class="proofClose close ml-1 mt-1">--}}
{{--                            --}}{{--                                                       <span aria-hidden="true">&times;</span>--}}
{{--                            --}}{{--                                                    </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                @endforeach

            </div>
            <hr>
            <div class="d-flex flex-wrap justify-content-around">
                <a  type="button" id="saveExpense" class="col-5 w-50 btn btn-primary">Wijziging opslaan</a>
                <a  type="button" href="/expense_allowances/{{$expense->expense_allowance_id}}/edit" class="col-5 m-auto btn-outline-danger text-danger w-50 btn">Annuleren</a>
            </div>
        </div>
    </Form>
    </div>
@endsection
