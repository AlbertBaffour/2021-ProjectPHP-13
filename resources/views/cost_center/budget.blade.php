@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
            if(document.getElementById("my_cookie").value.trim()){
                $('#New_cc').attr('hidden',false);
                $('#New_cost_center').attr('hidden',true);

                $('.action').hide();
                $('.search_box').hide();

                if(document.getElementById("my_cookie").value.trim()==="100"){
                    $('#cost_center').hide();
                }else{
                    $('#cost_center_id').hide();
                }
            }
            //Zoek functie
            $('#yearf').change(function () {
                $('#CostCenterForm').attr('action', `/budgets`);
                $('input[name="_method"]').val('get');
                $('#CostCenterForm').submit();

            })

        });
        //Nieuwe budget
        var new_cost_nr=1;
        $('#New_cost_center').click( function() {
            if (new_cost_nr<2) {
                $('#cost_center').val('');
                $('#cost_center_id').val('');
                $('#amount').val('');
                $('#year').val('');
                $('#CostCenterForm').attr('action', `/budgets`);
                $('input[name="_method"]').val('post');
                $('#new_box_title').text('Nieuw budget toevoegen:');

                $('#cost_center').hide();
                $('#New_cc').attr('hidden',false);
               $('#New_cost_center').attr('hidden',true);
                $('.action').hide();
                $('.search_box').hide()
                new_cost_nr=2;
                $('#my_cookie').val('100');
            }
        });
        //edit budget
        $(document).on('click',"#edit_cost_center", function() {
            if (new_cost_nr<2) {
               // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let cc_id = $(this).closest('td').data('cc_id');
                let cc_name = $(this).closest('td').data('cc_name');
                let amount = $(this).closest('td').data('amount');
                let year = $(this).closest('td').data('year');

                //form aanpassen

                $('#cost_center_id').hide();
                $('#CostCenterForm').attr('action', `budgets/${id}`);
                $('input[name="_method"]').val('put');
                $('#new_box_title').text('Budget wijzigen:');

                $('#cost_center_id2').val(cc_id);
                $('#cost_center').val(cc_name);
                $('#amount').val(amount);
                $('#year').val(year);


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
            $('#cost_center').show();
            $('#cost_center_id').show();
            new_cost_nr=1;
        });
        //delete
        function loadDeleteModal(id) {
            $('#modal-confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteBudget').modal('show');
        }

        function confirmDelete(id) {
            $.ajax({
                url: '{{ url('budgets') }}/' + id,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'delete',
                },
                success: function (data) {
                    // Success logic goes here..!
                    $('#deleteBudget').modal('hide');
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
        <a id="" data-toggle="tooltip" data-placement="top" href="cost_centers" class="align-self-center text-white btn btn-orangered" title="kostenplaatsen beheren" aria-pressed="true">
            <i class="fas fa-caret-left mr-1"></i>Kostenplaatsen beheren
        </a>
        <div class="d-flex flex-wrap justify-content-between mr-5">
    <h2 class="">Budgetten </h2>
        <hr>
    <a id="New_cost_center" data-toggle="tooltip" data-placement="top" href="#!" class="align-self-center btn btn-outline-primary" title="Nieuwe aanvraag" aria-pressed="true">
        <i class="fas fa-plus-circle mr-1"></i>Budget toevoegen
    </a>
    </div>
    <div id="New_cost_center_box" >
         <div id="New_cc" hidden class=" p-4 bg-li shadow"> <h3 id="new_box_title">Nieuwe kostenplaats toevoegen:</h3>
             <input hidden type="text" value="{{old('my_cookie')}}" name="my_cookie" id="my_cookie">

             <table>
                        <tr>

                            <th>Kostenplaats</th>
                            <th>Bedrag</th>
                            <th>Jaar</th>
                             </tr>
                     <tr>
                         <td>
                             <select class="form-control {{ $errors->first('cost_center_id') ? 'is-invalid' : '' }} " name="cost_center_id" id="cost_center_id">
                                 <option value="">--Kies kostenplaats--</option>
                                 @foreach($cost_centers as $cost_center)
                                     <option value="{{ $cost_center->id }}"
                                         {{--                    combo box opvullen--}}
                                         {{ old('cost_center_id') ==  $cost_center->id ? 'selected' : '' }}>{{ ucfirst($cost_center->name) }} <span class="font-weight-lighter">( {{$cost_center->reference}} )</span></option>
                                 @endforeach
                             </select>
                             @error('cost_center_id')
                             <div class="invalid-feedback">Kies een kostenplaats</div>
                             @enderror
                             <input class="form-control" disabled type="text" id='cost_center'
                                    name='cost_center'
                                    value="{{old('cost_center')}}">
                             <input  class="form-control" hidden type="text" id='cost_center_id2'
                                    name='cost_center_id2'
                                    value="{{old('cost_center_id2')}}">
                         </td>
                         <td>
                             <input class="form-control {{ $errors->first('amount') ? 'is-invalid' : '' }}" type="text" id='amount'
                                    name='amount'
                                    value="{{old('amount')}}">
                             @error('amount')
                             <div class="invalid-feedback">Geef het juiste bedrag in</div>
                             @enderror
                         </td>
                         <td><input type="text" id="year" name="year" class="form-control  {{ $errors->first('year')? 'is-invalid' : '' }}"
                                    value="{{old('year')}}">
                             @error('year')
                             <div class="invalid-feedback">Geef het jaar in</div>
                             @enderror
                         </td>


                            </tr>
                    </table>
                <br>
                <button type="submit" id="submit_new_cc"  class="btn btn-primary">Opslaan</button>
                <button type="button" id="cancel_new_cc"  class="btn btn-danger">Annuleren</button>
            </div>
    </div>
        <div class="col-8 d-flex search_box">
            <label class="align-self-center mr-1 text-nowrap" for="year">Filter op jaar </label>
            <select class="form-control" name="yearf" id="yearf">
                <option value="%">Kies jaar:</option>
            @foreach($years as $year)
                    <option value="{{$year}}"
                        {{ (request()->yearf==  $year ? 'selected' : '') }}
                    >{{$year}}</option>
                @endforeach
            </select>

        </div>
        <br>
    </form>
        <table class="table table-striped">
        <tr>
            <th>Referentie</th>
            <th>Naam kostenplaats</th>
            <th>Verantwoordelijke</th>
            <th>Bedrag</th>
            <th>Jaar</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($budgets as $budget)
        <tr>


            <td>{{$budget->cost_center->reference}}</td>
            <td>{{$budget->cost_center->name}}</td>
            <td>{{$budget->cost_center->user? $budget->cost_center->user->first_name.' '.$budget->cost_center->user->last_name:''}}</td>
            <td class="text-right">€{{ number_format($budget->amount,2)}}</td>
            <td>{{$budget->year}}</td>
            <td data-id="{{$budget->id}}"
                data-cc_id="{{$budget->cost_center_id}}"
                data-cc_name="{{$budget->cost_center->name}} ({{ $budget->cost_center->reference }})"
                data-amount="{{$budget->amount}}"
                data-year="{{$budget->year}}"
                 data-toggle="tooltip" data-placement="top" title="wijzigen">
                <a id="edit_cost_center" class="action">
                    <i class="text-dark fas fa-edit"></i>
                </a>
            </td>
            <td  data-toggle="tooltip" data-placement="top" title="Verwijderen">
                <button class="border-0 action" onclick="loadDeleteModal({{ $budget->id }})"><i class="text-danger far fa-trash-alt"></i>
                </button></td>



        </tr>
        @endforeach
    </table>
    <div class="modal fade" id="deleteBudget" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="deleteBudget" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Budget verwijderen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Wilt u dit budget zeker verwijderen?
                    <input type="hidden" id="budget" name="budget_id">
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="modal-confirm_delete">Verwijder</button>
                    <button type="button" class="btn bg-white" data-dismiss="modal">Annuleren</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

