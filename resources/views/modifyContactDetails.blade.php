@extends('layouts.template')

@section('main')
    <div class="container">
        <h1>Contactgegevens wijzigen</h1>
    </div>
    <form action="/modifyContactDetails/{{auth()->user()->id}}" method="post" class="col-10 m-auto">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-4">
                <label for="first_name">Voornaam</label><br>
                <input type="text" name="first_name" id="first_name" value="{{old('first_name', auth()->user()->first_name)}}"
                       class="form-control w-auto @error('first_name') is-invalid @enderror" placeholder="Voornaam"
                        required>
            </div>

            <div class="col-4">
                <label for="last_name">Achternaam</label><br>
                <input type="text" name="last_name" id="last_name" value="{{old('last_name', auth()->user()->last_name)}}"
                       class="form-control w-auto @error('last_name') is-invalid @enderror" placeholder="Achternaam"
                       required>
            </div>

            <div class="col-4">
                <label for="date_of_birth">Geboortedatum</label><br>
                <input class="w-25" type="text" name="date_of_birth" id="date_of_birth" value="{{auth()->user()->date_of_birth}}" placeholder="Geboortedatum" disabled placeholder="Geboortedatum"><br>

            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <label for="personnel_type">Personeelstype</label><br>
                <input class="w-auto" type="text" name="personnel_type" id="personnel_type" value="{{auth()->user()->personnel_type->name}}" placeholder="Personeelstype" disabled>
            </div>

            <div class="col-4">
                <label for="unit">Unit</label><br>
                <input type="text" name="unit" id="unit" value="{{auth()->user()->unit->name}}" disabled>
            </div>

            <div class="col-4">
                <label for="email">E-mail</label><br>
                <input type="email" id="email" name="email" value="{{old('email', auth()->user()->email)}}"
                class="form-control w-100 @error('email') is-invalid @enderror" placeholder="E-mail" required><br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <label for="telephone">Telefoonnummer</label>
                <br>
                <input type="tel" name="telephone" id="telephone" value="{{old('telephone', auth()->user()->telephone)}}"
                class="form-control w-auto @error('telephone') is-invalid @enderror" placeholder="Telefoonnummer" minlength="10" required>
            </div>

            <div class="col-4">
                <label for="account_number">Rekeningnummer</label>
                <br>
                <input type="text" name="account_number" id="account_number" value="{{old('account_number', auth()->user()->account_number)}}"

                       class="form-control w-auto @error('account_number') is-invalid @enderror" placeholder="Rekeningnummer" size="16"
                       pattern="[A-Z0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}"
                       required>
            </div>

            <div class="col-4">
                <label for="place">Woonplaats</label><br>
                <input type="text" name="place" id="place" value="{{old('place', auth()->user()->place)}}"
                class="form-control w-auto @error('place') is-invalid @enderror" placeholder="Woonplaats" required><br><br>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-3">
                <label for="street_and_number">Straat en nummer</label><br>
                <input type="text" name="street_and_number" id="street_and_number" value="{{old('street_and_number', auth()->user()->street_and_number)}}" class="form-control @error('street_and_number') is-invalid @enderror" placeholder="Straat en nummer" required>
            </div>

            <div class="col-3">
                <label for="postcode">Postcode</label>
                <input type="text" name="postcode" id="postcode" value="{{old('postcode', auth()->user()->postcode)}}" class="w-25 form-control @error('postcode') is-invalid @enderror" placeholder="Postcode" pattern="[0-9]{4}" required>
            </div>
            <div class="col-2">
                <label for="start_date">Startdatum: </label><br>
                <input type="text" name="start_date" id="start_date" value="{{auth()->user()->start_date}}" required disabled>
            </div>

            <div class="col-4">
                <label for="total_km">Aantal kilometer</label><br>
                <input type="text" name="total_km" id="total_km" value="{{auth()->user()->total_km}}" required disabled>
            </div>
        </div>
        <input type="submit" value="Wijzigen">
    </form>
@endsection
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    $(function (){

    });
</script>
