@extends('layouts.template')


@section('main')
    <div class="container border-left shadow border-info mt-3">

        <h5 class="text-center  text-dmblack">Welkom bij de onkostenvergoeding webapp!</h5>
        <p class="p-3 text-dmblack">  Deze webapplicatie is gemaakt in het kader van Project-PHP.
            Het is een online onkostenvergoedingsportaal waar werknemers
            van Thomas More hun fietsvergoedingen, laptopvergoedingen en alle
            andere onkostenvergoedingen kunnen aanvragen.
        </p>

    </div>

    <ul class="d-flex flex-wrap col-md-10 col-lg-8  m-auto">

        {{--  Auth navigation  --}}

        @auth
            <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/expense_allowances"><i class="far fa-clipboard"></i> Onkostennota's</a>
            </li>


            @if(auth()->user()->admin)
                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/payment_review"> <i class="fas fa-euro-sign"></i> Betaling afhandelen</a>
                </li>
                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/manageUsers"> <i class="fas fa-users-cog"></i> Gebruikers beheren</a>
                </li>

                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/mailtekst"><i class="fas fa-envelope-open-text"></i> Standaardmailtekst aanpassen</a>
                </li>
                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/cost_centers"><i class="fas fa-cog"></i> Kostenplaatsen beheren</a>
                </li>
                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/budgets"><i class="fas fa-money-check-alt"></i> Budgetten</a>
                </li>
                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/cost_settings"><i class="fas fa-clipboard"></i> Kosteninstellingen</a>
                </li>
            @endif
            @if(auth()->user()->personnel_type_id == 2)
                <li  class="card border card-body m-2 p-0 shadow-sm text-center">
                    <a class="m-0 p-4 h4 text-secondary bg-white text-decoration-none" href="/expense_allowance_review"><i class="fas fa-cog"></i> Onkostennota keuren</a>
                </li>
            @endif
        @endauth


    </ul>
@endsection
