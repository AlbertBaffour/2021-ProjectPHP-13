@extends('layouts.template')

@section('main')
    <h1>Mailtekst wijzigen</h1>
    <br>
    @foreach($email_texts as $email_text)
        <a href="#" data-name="{{($email_text->name)}}" data-text="{{($email_text->text)}}"></a>
    @endforeach

    <form action="email_texts/{{$email_text->id}}" method="post">
        @csrf
        @method('put')
        <label for="name">Naam Mailtekst:</label>
        <input type="text" id="name" name="name" value="{{$email_text->name}}"><br><br>



        <label for="lname">Nieuwe tekst:</label>
        <br>
        <textarea placeholder="{{$email_text->text}}" rows="5" cols="80" id="text" name="text"></textarea>
        <br>


        <button onclick="sendMail()" for='name' for='text' type="submit" >Email versturen</button>
        <button for='name' for='text' type="submit" >Wijziging Oplsaan</button><br>


    </form>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
    function sendMail() {
        var link = "mailto:docie.test@gmail.com, verant@gmail.com, finea@gmail.com"
            + "?cc="
            + "&subject=" + encodeURIComponent(document.getElementById('name').value)
            + "&body=" + encodeURIComponent(document.getElementById('text').value)
        ;

        window.location.href = link;
    }
</script>

