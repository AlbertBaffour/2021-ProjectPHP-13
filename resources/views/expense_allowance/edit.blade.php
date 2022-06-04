@section('script_after')
    <script>
        $(function () {
            //tooltip
            $('[data-toggle="tooltip"]').tooltip();
        })
        //delete
        function loadDeleteModal(id) {
            $('#modal-confirm_delete').attr('onclick', `confirmDelete(${id})`);
            $('#deleteEAE').modal('show');
        }

        function confirmDelete(id) {
            $.ajax({
                url: '{{ url('expenses') }}/' + id,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'delete',
                },
                success: function (data) {
                    // Success logic goes here..!
                    $('#deleteEAE').modal('hide');
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
@section('title','Onkostennota wijzigen')
@section('main')

    <div class="col-12 col-lg-10 m-auto bg-white shadow-sm p2">
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
<h3>Onkosten:</h3>
        <table class="table table-striped ">
        <thead class="thead-mlight">
        <tr>
            <th scope="col">Bedrag</th>
            <th scope="col">Omschrijving</th>
            <th scope="col">Aantal km</th>
            <th scope="col">Datum</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($expenses as $expense)

        <tr>
            <td> € {{ number_format($expense->cost,2) }}</td>
            <td>{{$expense->description}}</td>
            <td>{{$expense->total_km}}</td>
            <td>{{\Carbon\Carbon::parse($expense->date)->format('d-M-Y')}}</td>

            <td><a  class="btnEdit text-dark" href="/expenses/{{$expense->id}}/edit"  data-toggle="tooltip" data-placement="top" title="wijzigen"><i class="fas fa-edit"></i></a></td>
            <td><a onclick="loadDeleteModal({{ $expense->id }})" id="{{$expense->id}}" class="btn-delet text-danger"  data-toggle="tooltip" data-placement="top" title="Verwijderen"><i class=" far fa-trash-alt"></i></a></td>

        </tr>
        @endforeach
        {{ $expenses->links() }}
        <tr>
            <td class="font-weight-bold">Totaalbedrag</td>
            </tr>
        <tr>
            <td class="font-weight-bold"> € {{ number_format($expenses->sum('cost'),2)}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="d-flex flex-wrap justify-content-around">
        <a  type="button" href="/expense_allowances"  class="col-5 w-50 btn btn-primary">Terug naar overzicht</a>
          </div>
    <hr>
{{--    EAE=expense_allowance-expense --}}
    <div class="modal fade" id="deleteEAE" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="deleteEAE" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Onkost verwijderen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Wilt u dit onkost zeker verwijderen?
                    <input type="hidden" id="eae" name="eae_id">
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="modal-confirm_delete">Verwijder</button>
                    <button type="button" class="btn bg-white" data-dismiss="modal">Annuleren</button>
                </div>
            </div>
        </div>
    </div></div>
@endsection
