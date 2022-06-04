@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
        });
        //autocomplete cost centers
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
        //form submit
        $('#submitForm').click(function() {
            if (document.getElementById("cost_center_id").value.trim()==="" || document.getElementById("title").value.trim()===""  ){
                if (document.getElementById("title").value.trim()===""){
                    $('#title').addClass('border-danger');
                    $('#cost_center_search').removeClass('border-danger');
                }else
                {
                    $('#cost_center_search').addClass('border-danger');
                    $('#title').removeClass('border-danger')
                }
            }else {
                  document.getElementById("form").submit();
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


        <div class="mb-5 p-4 col-lg-8 m-auto bg-light font-weight-bold">
            <Form id="form" action="/expense_allowances" method="post">
                @csrf
        <div class="col-12">
            <label class="col-3 col-md-2" for="title">Titel:</label>
            <input class="col-5 col-md-4" type="text" id='title' name='title' placeholder="">
            <label class="col-3 col-md-5"></label>
        <!-- For defining autocomplete -->
        <label class="col-3 col-md-2" for="cost_center_search">Kostenplaats:</label>
        <input class="col-5 col-md-4" type="text" id='cost_center_search' name='cost_center_search' placeholder="zoek kostenplaats">
            <small class="text-muted">kies uit de lijst die verschijnt.</small>
            <!-- For displaying selected option value from autocomplete suggestion -->
        <input type="text" id='cost_center_id' name='cost_center_id' hidden>

        </div>

                 <button id="submitForm" name="submitForm" type="button" class="col-3 btn btn-primary"> Verder</button>
                <a href="/request_menu" type="button" class="col-3 btn btn-outline-danger"><i class="far fa-window-close"></i> Annuleren</a>

            </Form>
        <hr>

        </div>


@endsection
