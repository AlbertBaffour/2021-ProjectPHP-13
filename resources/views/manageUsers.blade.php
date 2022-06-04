@extends('layouts.template')

@section('main')
{{--    <div>$users[0]->unit->name</div>--}}
    <div class="container">
        <h1>Gebruikers beheren</h1>
        <div class="row">
            <div class="col-3">
                <label for="city">Zoek personeel</label><br>
                <input type="text" placeholder="Personeelslid" id="personeeel">
            </div>

            <div class="col-3">
                <label for="personeelstypes">Personeelstypes: </label><br>
                <select name="personeelstypes" id="personeelstypes" size="1">
                    <option value="D" selected>Docent</option>
                    <option value="K">Kostenplaats verantwoordelijke</option>
                    <option value="F">Financieel medewerker</option>
                </select>
            </div>

            <div class="col-2">
                <label for="status">Status: </label> <br>
                <select name="status" id="status" size="1">
                    <option value="A">Actief</option>
                    <option value="I">Inactief</option>
                </select><br>
            </div>

            <div class="col-3">
                <label for="units">Unit: </label><br>
                <select name="units" id="units">
                    <option value="ICT" selected>IT Factory </option>
                    <option value="Bouw">Bouw</option>
                    <option value="BaT">Business and Tourism</option>
                    <option value="MaD">Media and communication</option>
                    <option value="PaH">People and Health</option>
                </select>
            </div>

            <div class="col-1">
                <br>
                <input type="button" value="Zoek" id="zoekPersoon">
            </div>
        </div>
        <br>

        <div class="d-flex">
            <div class="col-4">
                <ul class="list-group list-group-flush">
                    @foreach($users as $user)
                        <li class="list-unstyled">
                            <a href="#" data-firstname="{{$user->first_name}}" data-lastname="{{$user->last_name}}"
                               data-personneltype="{{$user->personnel_type->id}}" data-birth="{{$user->date_of_birth}}"
                               data-unit="{{$user->unit->id}}" data-mail="{{$user->email}}"
                               data-telephone="{{$user->telephone}}" data-accountnr="{{$user->account_number}}"
                               data-place="{{$user->place}}" data-street_and_number="{{$user->street_and_number}}"
                               data-postcode="{{$user->postcode}}" data-startdate="{{$user->start_date}}"
                               data-total_km="{{$user->total_km}}" data-statuses="{{$user->active}}" data-id="{{$user->id}}">{{ $user->first_name.' '.$user->last_name }}
                            </a>
                        </li>

                    @endforeach
                </ul>
            </div>

            <div class="col-8 border-dark">
                <div class="col m-2 border border-dark">
                    <form id="userForm" method="post">
                        @method('put')
                        @csrf
                        <div class="d-flex">
                            <div class="col-4">
                                <label for="first_name">Voornaam</label><br>
                                <input type="text" name="first_name" id="first_name" value="">
                            </div>

                            <div class="col-4">
                                <label for="last_name">Achternaam</label><br>
                                <input type="text" name="last_name" id="last_name"><br>
                            </div>

                            <div class="col-4">
                                <label for="date_of_birth" class="ml-2">Geboortedatum</label>
                                <input type="text" name="date_of_birth" id="date_of_birth"><br>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="col-4">
                                <label for="personnel_type">Personeelstype</label>
                                <select name="personnel_type" id="personnel_type">
                                    <option value="Kies Personeelstype">Kies personeelstype</option>
                                    @foreach($personnel_types as $personnel_type)
                                        <option value="{{$personnel_type->id}}">{{$personnel_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="unit">Unit</label>
                                <select name="unit_id" id="unit">
                                    <option value="Kies unit">Kies unit</option>
                                @foreach($units as $unit)

                                    <option value="{{$unit->id}}">{{$unit->name}}
                                    </option>
                                @endforeach
                                </select>
{{--                                <select name="units" id="units">--}}
{{--                                    <option value="ICT" selected>IT Factory </option>--}}
{{--                                    <option value="Bouw">Bouw</option>--}}
{{--                                    <option value="BaT">Business and Tourism</option>--}}
{{--                                    <option value="MaD">Media and communication</option>--}}
{{--                                    <option value="PaH">People and Health</option>--}}
{{--                                </select>--}}
                            </div>

                            <div class="col-4">
                                <label for="email">E-mail</label><br>
                                <input type="email" id="email" name="email"><br><br>
                            </div>
                        </div>


                        <div class="d-flex">
                            <div class="col-4">
                                <label for="telephone">Telefoonnummer</label>
                                <br>
                                <input type="tel" name="telephone" id="telephone">
                            </div>

                            <div class="col-4">
                                <label for="accountnr">Rekeningnummer</label>
                                <br>
                                <input type="text" name="account_number" id="accountnr">
                            </div>

                            <div class="col-4">
                                <label for="place">Woonplaats</label>
                                <input type="text" name="place" id="place"><br><br>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="col-4">
                                <label for="street_and_number">Straat en nummer</label>
                                <input type="text" name="street_and_number" id="street_and_number">
                            </div>

                            <div class="col-4">

                            </div>

                            <div class="col-4">
                                <label for="postcode">Postcode</label>
                                <input type="text" name="postcode" id="postcode"><br><br><br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="startdate">Startdatum: </label>
                                <input type="text" name="start_date" id="startdate">
                            </div>

                            <div class="col-6">
                                <label for="totalkm">Aantal kilometer</label>
                                <input type="text" name="total_km" id="total_km">
                            </div>
                        </div>
                        <input type="submit" value="Wijzigen" >
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-4">
            <a href="/createUser" class="btn btn-outline-success">Voeg nieuwe user toe</a>
        </div>
        <div class="col-4">

        </div>

        <div class="col-4">

            <label for="status2">Status</label><br>
            <input type="text" name="status2" id="status2"><i class="fas fa-check"></i>
            <input type="button" value="Deactiveren" id="activatie" >
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-4">

        </div>

        <div class="col-4">

        </div>

        <div class="col-4">

        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-4">

        </div>

        <div class="col-4">

        </div>

        <div class="col-4">

        </div>
    </div>

    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    $(function (){
        $('i').removeClass('fa-check');
        $('i').removeClass('fa-times');

        $('#activatie').click(function (){
            if ($('#status2').val('actief')){
                $("#status2").val('inactief');
                $('.fas').addClass('fa-times');
                $('.fas').removeClass('fa-check');
                $('#activatie').val('Activeren');
            }
            else if ($('#status2').val('inactief')){
                $("#status2").val('actief');
                $('.fas').removeClass('fa-times');
                $('.fas').addClass('fa-check');
                $('#activatie').val('Deactiveren');
            }
        });

        $(".list-group li a").click(function(){

            $('#userForm').attr('action', '/manageUsers/'+ $(this).data('id'));
            $('input[name="_method"]').val('put');

            $("#first_name").text($(this)).text();
            $("#first_name").val($(this).data('firstname')).text();

            $("#last_name").text($(this)).text();
            $("#last_name").val($(this).data('lastname')).text();

            $("#date_of_birth").text($(this)).text();
            $("#date_of_birth").val($(this).data('birth').toString()).text();

            var personnel_type_id = $(this).data('personneltype');
            $('#personnel_type option:eq('+personnel_type_id+')').prop('selected', true);

            // $("#Unit").text($(this)).text();
            var unit_id = $(this).data('unit');
            $('#unit option:eq('+unit_id+')').prop('selected', true);
            // $("#Unit").val($(this).data('unit'));

            $("#email").text($(this)).text();
            $("#email").val($(this).data('mail')).text();

            $("#telephone").text($(this)).text();
            $("#telephone").val($(this).data('telephone')).text();

            $("#accountnr").text($(this)).text();
            $("#accountnr").val($(this).data('accountnr')).text();

            $("#place").text($(this)).text();
            $("#place").val($(this).data('place')).text();

            $("#street_and_number").text($(this)).text();
            $("#street_and_number").val($(this).data('street_and_number')).text();

            $("#postcode").text($(this)).text();
            $("#postcode").val($(this).data('postcode')).text();

            $("#startdate").text($(this)).text();
            $("#startdate").val($(this).data('startdate').toString()).text();

            $("#total_km").text($(this)).text();
            $("#total_km").val($(this).data('total_km')).text();

            $("#status2").text($(this)).text();
            $("#status2").val($(this).data('statuses')).text();
            if ($("#status2").val($(this).data('statuses')))
            {
                $("#status2").val('actief');
                $('.fas').removeClass('fa-times')
                $('.fas').addClass('fa-check');
            }
            else
            {
                $("#status2").val('inactief');
                $('.fas').addClass('fa-times');
                $('.fas').removeClass('fa-check');
            }

        });
    });
</script>
