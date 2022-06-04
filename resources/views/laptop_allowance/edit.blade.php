@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            //$('#purchaseDate').datepicker();
            //fetchLaptops();
        });
        //Auto complete cost centers
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(function(){
            $( "#cost_center_search" ).autocomplete({
                source: function( request, response ) {
                    // Fetch data
                    $.ajax({
                        url:"{{route('expense_allowance.getCostCenters')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    // Set selection
                    $('#cost_center_search').val(ui.item.label); // display the selected text
                    $('#cost_center_id').val(ui.item.value); // save selected id to input
                    return false;
                },
                change:
                    function( event, ui ){
                        var selfInput = $(this); //stores the input field
                        if ( !ui.item ) {
                            var writtenItem = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val().toLowerCase()) + "$", "i"),
                                valid = false;

                            $('ul.for_' + specificInput).children("li").each(function () {
                                if ($(this).text().toLowerCase().match(writtenItem)) {
                                    this.selected = valid = true;
                                    selfInput.val($(this).text()); // shows the item's name from the autocomplete
                                    selfInput.next('span').text('(Existing)');
                                    selfInput.data('id', $(this).data('id'));
                                    return false;
                                }
                            });

                            if (!valid) {
                                selfInput.next('span').text('(New)');
                                selfInput.data('id', -1);
                            }
                        }
                    }
            });

        });
    </script>

@endsection
@extends('layouts.template')
@section('title','Onkostennota | aanvraag')
@section('main')

    @csrf
    <div class="d-flex flex-wrap justify-content-around"><h1 class="">Laptopvergoeding aanvraag > Wijziging</h1>
    </div>
    @include('shared.alert')
    <Form class="pb-5 shadow  p-3 col-10 m-auto"  id="LForm" action="/laptop_allowances/{{$laptop_allowance->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input hidden type="text"
               id="laptop_id" name="laptop_id"
               value="{{$laptop_allowance->laptop_id}}">
        @include('laptop_allowance.form')

        <div class="m-auto">
            <button id="editLaptopAllowance" type="submit" class="col-4 btn btn-primary">Wijziging opslaan</button>
            <a href="/expense_allowances" type="button" class="col-3 btn btn-outline-danger">Annuleren</a>
        </div>

    </Form>


@endsection
