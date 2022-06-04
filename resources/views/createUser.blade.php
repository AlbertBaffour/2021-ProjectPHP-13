@extends('layouts.template')

@section('title, Maak nieuwe user')

@section('main')
    <h1>Nieuwe gebruiker aanmaken</h1>
    <form action="createUser" method="post" class="mb-5">
        @csrf
        @method('put')
        <input type="text" name="first_name" id="first_name"
               class="form-control @error('firstname') is-invalid @enderror mb-2"
               placeholder="Voornaam"
               minlength="3"
               required
               value="{{ old('first_name', $user->first_name??'') }}">

        <input type="text" name="last_name" id="last_name"
               class="form-control @error('name') is-invalid @enderror mb-2"
               placeholder="Achternaam"
               minlength="3"
               required
               value="{{ old('last_name', $user->last_name??'') }}">


        <input type="date" name="date_of_birth" id="date_of_birth"
               class="form-control @error('date_of_birth') is-invalid @enderror mb-2"
               placeholder="Geboortedatum"
               minlength="4"
               required
               value="{{old('birth_of_date', $user->birth_of_date??'')}}">

        <select class="form-control bg-info mb-2" name="personnel_type_id" id="personnel_type_id">
            @if($personnel_types ?? ''){
            @foreach($personnel_types as $personnel_type)
                <option value="{{$personnel_type->id}}">{{$personnel_type->name}}</option>
            @endforeach
            }
            @endif
        </select>

        <select class="form-control bg-info mb-2" name="unit_id" id="unit_id">
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
        </select>

        <input type="text" name="email" id="email"
               class="form-control @error('email') is-invalid @enderror mb-2"
               placeholder="Email"
               minlength="4"
               required
               value="{{old('email', $user->email??'')}}">

        <input type="password" name="password" id="password"
               class="form-control @error('password') is-invalid @enderror mb-2"
               placeholder="Password"
               minlength="4"
               required
               value="{{old('password', $user->password??'') }}">

        <input type="tel" name="telephone" id="telephone"
               class="form-control @error('telephone') is-invalid @enderror mb-2"
               placeholder="Telefoonnummer"
               minlength="4"
               value="{{old('telephone', $user->telephone??'')}}">

        <input type="text" name="account_number" id="account_number"
               class="form-control @error('account_number') is-invalid @enderror mb-2"
               placeholder="Rekeningnummer"
               minlength="12"
               value="{{old('account_number', $user->account_number??'')}}">

        <input type="text" name="place" id="place"
               class="form-control @error('place') is-invalid @enderror mb-2"
               placeholder="Woonplaats"
               minlength="4"
               required
               value="{{old('place', $user->place??'')}}">

        <input type="text" name="street_and_number" id="street_and_number"
               class="form-control @error('street_and_number') is-invalid @enderror mb-2"
               placeholder="Straat en nummer"
               minlength="4"
               required
               value="{{old('street_and_number', $user->street_and_number??'')}}">

        <input type="text" name="postcode" id="postcode"
               class="form-control @error('postcode') is-invalid @enderror mb-2"
               placeholder="Postcode"
               minlength="4"
               maxlength="4"
               required
               value="{{old('postcode', $user->postcode??'')}}">

        <input type="date" name="start_date" id="start_date"
               class="form-control @error('date') is-invalid @enderror mb-2"
               placeholder="Startdatum"
               minlength="4"
               required
               value="{{old('start_date', $user->start_date??'')}}">

        <input type="text" name="total_km" id="total_km"
               class="form-control @error('total_km') is-invalid @enderror mb-2"
               placeholder="Aantal km"
               required
               value="{{old('total_km', $user->total_km??'')}}">
        <button type="submit">Gebruiker Toevoegen</button><br>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    $(function (){
        $('input[name="_method"]').val('post');
    });
</script>
