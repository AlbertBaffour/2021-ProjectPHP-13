<div id="LaptopBox" class="m-2 mb-5">
    <div id="" class=" p-2">
        <div class="col-12"><label class="d-block" for="purchaseDate">Datum fietsrit:</label>
            <input class="{{ $errors->first('rideDate') ? 'is-invalid' : '' }} approval-disabled form-control" type="date" id="rideDate" name="rideDate" >
            @error('rideDate')
            <div class="invalid-feedback">Kies een datum</div>
            @enderror
        </div>
    </div>
</div>
