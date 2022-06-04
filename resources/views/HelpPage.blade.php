@extends('layouts.template')

@section('main')
    <div class="container">
        <h1 class="col-12 text-center">Hulppagina</h1>
        <hr>
        <br>
            @auth()
            <div class="row">
                <video class="col-6" controls>
                    <source src="{{URL::asset("/videos/Docent.mp4")}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endauth
            @if(auth()->user()->personnel_type_id == 2)
                <video class="col-6" controls>
                    <source src="{{URL::asset("/videos/KostenplaatsVerantwoordelijke.mp4")}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
            @if(auth()->user()->admin)
                <video class="col-6" controls>
                    <source src="{{URL::asset("/videos/Financieel.mp4")}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
        </div>
    </div>
@endsection
