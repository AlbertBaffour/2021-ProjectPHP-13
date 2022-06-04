@extends('layouts.template')

@section('main')
    <div class="container pb-5">
        <h1 class="col-12 text-center">Kostinstellingen beheren</h1>
        <hr>
        <div class="">

                <h4 class="col-12 text-left">Autovergoeding</h4>
                <p class="col-6 text-left" >Euro per km:</p>
            <form class="perKmCar" method="POST" action="cost_settings/{{$cost_settingsCar->id}}">
                @csrf
                @method('put')
                <input id="value" name="value"  value="{{$cost_settingsCar->value}}">
                <button for="laptop" class="btn-outline-primary shadow-sm" type="submit"><i class="fas fa-save"></i></button>
                <br>
            </form>
            <hr>
            <form class="perKmCar" method="POST" action="cost_settings/{{$cost_settingsBike->id}}">
                @csrf
                @method('put')
                <h4 class="col-12 text-left">Fietsvergoeding</h4> <br>
                <p class="col-6 text-left" >Euro per km:</p>
                <input id="value" name="value" value="{{$cost_settingsBike->value}}">
                <button for="laptop" class="btn-outline-primary shadow-sm" type="submit"><i class="fas fa-save"></i></button>
                <br>
            </form>
            <hr>
            <form class="laptop" method="POST" action="cost_settings/{{$cost_settingsLaptop->id}}">
                @csrf
                @method('put')
                <h4 class="col-12 text-left">Laptopvergoeding</h4> <br>
                <p class="col-6 text-left" > Bedrag terugbetaling:</p>
                <input id="laptop" name="value" value="{{$cost_settingsLaptop->value}}">
                <button for="laptop" class="btn-outline-primary shadow-sm" type="submit"><i class="fas fa-save"></i></button>
                <br>
                <label for="Time">Termijn: 1 Jaar</label>
            </form>
        </div>
    </div>
@endsection
