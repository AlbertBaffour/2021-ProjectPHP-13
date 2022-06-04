
                <div class="col-12">
                    <!-- For defining autocomplete -->
                    <label class="col-3 col-md-2" for="cost_center_search">Kostenplaats:</label>
                    <input  value="{{($laptop_allowance??'') ? ($laptop_allowance->cost_center->name): old('cost_center_search') }}"  class="approval-disabled col-5 col-md-4 form-control {{ $errors->first('cost_center_id') ? 'is-invalid' : '' }}" type="text" id='cost_center_search' name='cost_center_search' placeholder="zoek kostenplaats">
                    <small class="text-muted approval-none">kies uit de lijst die verschijnt.</small>
                    @error('cost_center_id')
                    <div class="invalid-feedback">Kies een kostenplaats</div>
                @enderror
                    <!-- For displaying selected option value from autocomplete suggestion -->
                    <input  value="{{ ($laptop_allowance??'') ? ($laptop_allowance->cost_center_id):old('cost_center_id') }}"
                        class="{{ $errors->first('cost_center_id') ? 'is-invalid' : '' }}" type="text" id='cost_center_id' name='cost_center_id' hidden>

                </div>
                <hr>
                    <div id="LaptopBox" class="m-2 mb-5">
                        <div id="" class=" p-2">
                            <div class="d-flex flex-wrap" id="">
                                <div class="col-4 m-auto mb-2">
                                    <label for="name" class="d-block" >Naam Product: </label>
                                    <input  value="{{($laptop_allowance??'') ? ($laptop_allowance->laptop->name):old('name') }}" id="name"
                                            name="name" type="text" class="d-block form-control {{ $errors->first('name') ? 'is-invalid' : '' }} approval-disabled">
                                    @error('name')
                                    <div class="invalid-feedback">Geef de naam in</div>
                                    @enderror
                                </div>
                                    <div class="col-4 m-auto">
                                    <label for="brand" class="d-block">Merk : </label>
                                    <input  value="{{ ($laptop_allowance??'') ? ($laptop_allowance->laptop->brand):old('brand') }}" id="brand"
                                            name="brand" type="text" class="d-block form-control {{ $errors->first('brand') ? 'is-invalid' : '' }} approval-disabled">
                                    @error('brand')
                                    <div class="invalid-feedback">Geef het merk in</div>
                                    @enderror
                                </div>
                                    <div class="col-4 m-auto">
                                    <label for="price" class="d-block">Kostprijs (€): </label>
                                    <input  value="{{($laptop_allowance??'') ? ($laptop_allowance->laptop->price): old('price') }}"
                                            id="price" name="price" type="text" class="form-control d-block {{ $errors->first('price') ? 'is-invalid' : '' }} approval-disabled">
                                    @error('price')
                                    <div class="invalid-feedback">Geef de prijs in</div>
                                    @enderror
                                </div>
                                <div class="col-8 m-auto"><label for="description">Omschrijving: </label>
                                    <textarea class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }} approval-disabled"
                                              id="description" name="description" rows="2">{{ ($laptop_allowance??'') ? ($laptop_allowance->laptop->description): old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">Geef een omschrijving</div>
                                    @enderror
                                </div>
                                <div class="col-4"><label class="d-block" for="purchaseDate">Aankoopdatum:</label>
                                    <input  value="{{ ($laptop_allowance??'') ? ($laptop_allowance->laptop->purchase_date):old('purchaseDate') }}"
                                            class="{{ $errors->first('purchaseDate') ? 'is-invalid' : '' }} approval-disabled form-control" type="date" id="purchaseDate" name="purchaseDate" >
                                    @error('purchaseDate')
                                    <div class="invalid-feedback">Kies een datum</div>
                                    @enderror
                                </div>
                            </div>
                            {{--Bewijs toevoegen--}}

                            <div id="proofBox" class=" col-11 m-auto">
                                <label class="d-block" for="">Factuur:</label>
                                <div class="d-flex mb-2" id="">
                                    <div id="invoice" class="col-11 ">
                                        <a target='_blank' href='/uploads/proofs/{{ ($laptop_allowance??'') ? ($laptop_allowance->laptop->invoice):old('invoice') }}'>{{ ($laptop_allowance??'') ? ($laptop_allowance->laptop->invoice ):old('invoice') }} <i class="{{ ($laptop_allowance->laptop->invoice??'') ? 'fas fa-external-link-alt':''}}"></i> </a>
                                        <br><span class="approval-none new-none"> Factuur opnieuw uploaden?</span>
                                        <input value="{{ ($laptop_allowance??'') ? ($laptop_allowance->laptop->invoice):old('invoice') }}" type="file" id="invoice" name="invoice" class="form-control approval-none" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
