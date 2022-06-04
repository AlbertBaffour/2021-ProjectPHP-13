
@section('script_after')
    <script>
        $(".red_text").click(function () {
            $(".hulpmenu").find("p").removeClass("text-dmblack");
            $(".hulpmenu").find("p").css("color", "red");
        });
        $(".big_text").click(function () {
            $(".hulpmenu").find("p").css("fontSize", "18px");
        });
        $(".reset").click(function () {
            location.reload(true);
        });
    </script>
@endsection
<div class="header bg-light ">
    <div class="container">
        <div class="row">

        </div>
        <!--/row-->
    </div>
    <!--container-->
</div>
<nav class="navbar navbar-expand-lg d-flex flex-wrap sticky-top navbar-dark bg-dark">
    <div class="col-12 d-xl-none"> <a class="text ttl text-decoration-none h5 font-weight-bolder align-self-center text-light" href="/">
            <img src="images/logo-alt.png" width="40px"   alt=""> Onkostenvergoeding webapp</a>
    </div>
    <a class="d-none d-xl-block text ttl text-decoration-none h5 font-weight-bolder align-self-center text-light" href="/">
        <img src="images/logo-alt.png" width="40px"   alt=""> Onkostenvergoeding webapp</a>

    <div class="container d-flex small">

        <button id="nav" class="border-white navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse align-self-end" id="collapsNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap">
                    <a class="nav-link text-light" href="/login"><i class="fas fa-home"></i> Home</a>
                </li>
                {{--  Auth navigation  --}}

                @auth
                    <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap">
                        <a class="nav-link text-light" href="/expense_allowances"><i class="far fa-clipboard"></i> Onkostennota's</a>
                    </li>

                    @if(auth()->user()->admin)


                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap" >
                            <a class="nav-link text-light font-weight-light" href="/payment_review"><i class="fas fa-euro-sign"></i> Betaling afhandelen</a>
                        </li>
                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap" >
                            <a class="nav-link text-light font-weight-light" href="/mailtekst"><i class="fas fa-envelope-open-text"></i> Mailtekst aanpassen</a>
                        </li>
                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap" >
                            <a class="nav-link text-light" href="/cost_settings"><i class="fas fa-clipboard"></i> Kosteninstellingen</a>
                        </li>
                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap">
                            <a class="nav-link text-light" href="/cost_centers"><i class="fas fa-cog"></i> Kostenplaatsen</a>
                        </li>
                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap">
                            <a class="nav-link text-light" href="/budgets"><i class="fas fa-money-check-alt"></i> Budgetten</a>
                        </li>
                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap">
                            <a class="nav-link text-light" href="/manageUsers"> <i class="fas fa-users-cog"></i> Gebruikers</a>
                        </li>

                    @endif
                    @if(auth()->user()->personnel_type_id == 2)
                        <li class="nav-item text-center border-left align-self-center bg-darkO w-100 text-nowrap">
                            <a class="nav-link text-light" href="/expense_allowance_review"><i class="fas fa-tasks"></i> Onkostennota keuren</a>
                        </li>
                    @endif
                @endauth
                <div class="text-center text-light align-self-center w-100 text-nowrap">
                    @guest
                        <a class="btn btn-light w-100" href="/login"><i class="fas fa-sign-in-alt"></i>&nbsp;Inloggen</a>
                        <!--
                        <li class="nav-item">
                            <a class="nav-link" href="/register"><i class="fas fa-signature"></i>Register</a>
                        </li>
                        -->
                    @endguest
                    @auth()
                        <div class="dropdown w-100">
                            <a class="btn btn-light text-dark nav-link dropdown-toggle w-100" href="#!" data-toggle="dropdown">

                                {{ auth()->user()->first_name}} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="z-index:99999">
                                <a class="dropdown-item" href="/modifyContactDetails"><i class="fas fa-user-cog"></i> Profiel updaten</a>
                                <a class="dropdown-item" href="/password"><i class="fas fa-key"></i> Nieuw wachtwoord</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i> Uitloggen</a>
                            </div>
                        </div>

                    @endauth

                </div>

            </ul>
        </div>
        <div class="dropdown p-1 ml-1">
            <a class="btn btn-light text-dark nav-link dropdown-toggle" href="#!" data-toggle="dropdown">Hulpmenu<span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item text-center big_text">Tekst vergroten</button>
                <hr>
                <button class="dropdown-item text-center red_text">Contrast wijzigen</button>
                <hr>
                <button class="dropdown-item text-center reset">Pagina herstellen</button>
             @auth
            <hr>
            <a class="dropdown-item text-center reset" href="/HelpPage">Hulp video's</a>
            @endauth
           </div>
  
        </div>
    </div>

</nav>
