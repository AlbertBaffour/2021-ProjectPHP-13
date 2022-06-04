@extends('layouts.template')

@section('main')
<div class="container">
        <h1 class="col-12 text-center">Fietsvergoeding aanvragen of wijzigen</h1>
        <hr>
        <br>
        <div class="row">
            <h4 class="col-12 text-center">Fietsvergoeding aanvragen</h4>
            <p class="col-6 text-right">Datum fietsrit:</p>
            <div class="col-6">
                <form>
                    <input type="date" name="datum" id="datum"><br>
                    <input type="submit" value="Fietsrit Opslaan">
                </form>
            </div>
        </div>
        <div class="row">
            <h4 class="col-12 text-center">Fietsvergoeding wijzigen</h4>
            <div class="col-12 text-center">
                <form>
                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                    <label for="vehicle1">Fietsrit1</label><br>
                    <input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
                    <label for="vehicle2">Fietsrit2</label><br>
                    <input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
                    <label for="vehicle3">Fietsrit3</label><br>
                    <input type="submit" value="Fietsrit Wijzigen">
                </form>
            </div>
        </div>
    </div>
@endsection