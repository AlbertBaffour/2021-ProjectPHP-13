@section('script_after')
    <script>
        $(function () {

            if(document.getElementById("my_cookie").value.trim()){
                $('#New_cc').attr('hidden',false);
                $('#New_cost_center').attr('hidden',true);

                $('.action').hide();
                $('.search_box').hide();
            }
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            //Zoek functie
            $('#search_word').blur(function () {
                $('#CostCenterForm').attr('action', `/cost_centers`);
                $('input[name="_method"]').val('get');
                $('#CostCenterForm').submit();

            })

        });
        // auto complete verantwoordelijke
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(function(){
            $( "#user_search" ).autocomplete({
                source: function( request, response ) {
                    // Fetch data
                    $.ajax({
                        url:"{{route('cost_center.getUsers')}}",
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
                    $('#user_search').val(ui.item.label); // display the selected text
                    $('#user_id').val(ui.item.value); // save selected id to input
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
        //Nieuwe kostenplaats formulier
        var new_cost_nr=1;
        $('#New_cost_center').click( function() {
            if (new_cost_nr<2) {
                $('#name').val('');
                $('#reference').val('');
                $('#user_search').val('');
                $('#user_id').val('');
                $('#CostCenterForm').attr('action', `/cost_centers`);
                $('input[name="_method"]').val('post');
                $('#new_box_title').text('Nieuwe kostenplaats toevoegen:');

                $('#New_cc').attr('hidden',false);
               $('#New_cost_center').attr('hidden',true);
                $('.action').hide();
                $('.search_box').hide()
                new_cost_nr=2;
                $('#my_cookie').val('100');
            }
        });
        //edit cost center
        $(document).on('click',"#edit_cost_center", function() {
            if (new_cost_nr<2) {
               // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let name = $(this).closest('td').data('name');
                let reference = $(this).closest('td').data('reference');
                let user_id = $(this).closest('td').data('user_id');
                let user_name = $(this).closest('td').data('user_name');
                //form aanpassen
                $('#CostCenterForm').attr('action', `cost_centers/${id}`);
                $('input[name="_method"]').val('put');
                $('#new_box_title').text('Kostenplaats wijzigen:');
                $('#name').val(name);
                $('#reference').val(reference);
                $('#user_search').val(user_name);
                $('#user_id').val(user_id);


                $('#New_cc').attr('hidden',false);
                $('#New_cost_center').attr('hidden',true);
                $('.search_box').hide();
                $('.action').hide();
                new_cost_nr=2;
                $('#my_cookie').val('200');
            }
        });
        $('#New_cost_center_box').on('click',"#cancel_new_cc", function() {
           $('#New_cost_center').attr('hidden',false);
            $('#New_cc').attr('hidden',true);
            $('.action').show();
            $('.search_box').show();
            $('#New_cc input').removeClass('is-invalid')

            new_cost_nr=1;
        });

//delete
            function loadDeleteModal(id, name) {
            $('#modal-cost_center_name').html(name);
            $('#modal-confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteCostCenter').modal('show');
        }

        function confirmDelete(id) {
            $.ajax({
                url: '{{ url('cost_centers') }}/' + id,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'delete',
                },
                success: function (data) {
                    // Success logic goes here..!
                    $('#deleteCostCenter').modal('hide');
                    location.reload(true);
                },
                error: function (error) {
                    // Error logic goes here..!
                }
            });
        }
    </script>
@endsection
@extends('layouts.template')

@section('main')
@csrf
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
<div  class="col-12 col-lg-8 m-auto bg-white p-2">
    <form id="CostCenterForm" action="" method="post">
        @csrf
        @method('')
        <a id="" data-toggle="tooltip" data-placement="top" href="budgets" class="align-self-center text-white btn btn-orangered" title="budget beheren" aria-pressed="true">
            <i class="fas fa-money-check-alt mr-1"></i>Budgetten beheren
        </a>
        <div class="d-flex flex-wrap justify-content-between mr-5">
    <h2 class="">Kostenplaatsen beheren </h2>
        <hr>
    <a id="New_cost_center" data-toggle="tooltip" data-placement="top" href="#!" class="align-self-center btn btn-outline-primary" title="Nieuwe aanvraag" aria-pressed="true">
        <i class="fas fa-plus-circle mr-1"></i>Nieuwe kostenplaats
    </a>
    </div>
    <div id="New_cost_center_box" >
         <div id="New_cc" hidden class=" p-4 bg-white shadow"> <h3 id="new_box_title">Nieuwe kostenplaats toevoegen:</h3>
             <input hidden type="text" value="{{old('my_cookie')}}" name="my_cookie" id="my_cookie">

             <table>
                        <tr>

                            <th>Referentie</th>
                                <th class="col4">Naam kostenplaats</th>
                                <th>Verantwoordelijke <small class="text-muted">(kies uit de lijst die verschijnt)</small></th>
                             </tr>
                     <tr>
                         <td>
                             <input type="text" id="reference" name="reference"
                                    class="form-control  {{ $errors->first('reference')? 'is-invalid' : '' }}"
                                    value="{{old('reference')}}">
                             @error('reference')
                             <div class="invalid-feedback">Geef referenctie in</div>
                             @enderror
                         </td>

                         <td><input type="text" id="name" name="name" class="form-control  {{ $errors->first('name')? 'is-invalid' : '' }}"
                                    value="{{old('name')}}">
                             @error('name')
                             <div class="invalid-feedback">Geef naam in</div>
                             @enderror
                         </td>

                                <td><input class="form-control {{ $errors->first('user_id') ? 'is-invalid' : '' }}" type="text" id='user_search'
                                           name='user_search' placeholder="zoek op naam"
                                    value="{{old('user_search')}}">
                                    @error('user_id')
                                    <div class="invalid-feedback">Kies een kostenplaats</div>
                                @enderror
                             <!-- For displaying selected option value from autocomplete suggestion -->
                            <input type="text" id='user_id' name='user_id' hidden
                                   value="{{old('user_id') }}"> </td>

                            </tr>
                    </table>
                <br>
                <button type="submit" id="submit_new_cc"  class="btn btn-primary">Opslaan</button>
                <button type="button" id="cancel_new_cc"  class="btn btn-danger">Annuleren</button>
            </div>
    </div>
        <div class="col-8 d-flex search_box">
            <input type="text" class="form-control search_box" name="search_word" id="search_word"
                   value="{{ request()->search_word }}"
                   placeholder="Zoek op referentie, naam van kostenplaats of verantwoordelijke">
            <p class="btn search_box"><i class="fas fa-search"></i></p>
        </div>
        <br>
    </form>
        <table class="table table-striped">
        <tr>
            <th>Referentie</th>
            <th>Naam kostenplaats</th>
            <th>Verantwoordelijke</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($cost_centers as $cost_center)
        <tr>


            <td>{{$cost_center->reference}}</td>
            <td>{{$cost_center->name}}</td>
            <td>{{$cost_center->user? $cost_center->user->first_name.' '.$cost_center->user->last_name:''}}</td>
            <td data-id="{{$cost_center->id}}"
                data-name="{{$cost_center->name}}"
                data-reference="{{$cost_center->reference}}"
                data-user_id="{{$cost_center->user_id}}"
                data-user_name="{{$cost_center->user->first_name.' '.$cost_center->user->last_name}}"
                 data-toggle="tooltip" data-placement="top" title="wijzigen">
                <a id="edit_cost_center" class="action">
                    <i class="text-dark fas fa-edit"></i>
                </a>
            </td>
            <td  data-toggle="tooltip" data-placement="top" title="Verwijderen">
                <button class="border-0 action" onclick="loadDeleteModal({{ $cost_center->id }}, `{{ $cost_center->name }}`)"><i class="text-danger far fa-trash-alt"></i>
                </button></td>

        </tr>
        @endforeach
    </table>
<div class="modal fade" id="deleteCostCenter" data-backdrop="static" tabindex="-1" role="dialog"
     aria-labelledby="deleteCostCenter" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kostenplaats verwijderen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 Wilt u <b><span id="modal-cost_center_name"></span></b> zeker verwijderen?
                <input type="hidden" id="cost_center" name="cost_center_id">
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" id="modal-confirm_delete">Verwijder</button>
                <button type="button" class="btn bg-white" data-dismiss="modal">Annuleren</button>
            </div>
        </div>
    </div>
</div></div>

@endsection

