<div class="border-top border-dg footer p-2 bg-li text-dark text-center d-flex flex-wrap">
    <div class="col-12 d-flex flex-wrap text-dg">
        <div class=" col-12 col-sm-6 col-md-3 text-left p-3">
            <p class="font-weight-bold mb-0">Team</p> <p class="text-dg1">CM-C</p>

            <p class="font-weight-bold mb-0">Opdrachtgever:</p>
            <p class="text-dg1"> Mevr. Christel Maes
            </p>
            <p class="">Thomas More <span id="copyright-year"></span></p>

        </div>

        <div class=" col-12 col-sm-6 col-md-3 border-left border-light text-left p-3">
            <p class="font-weight-bold">Teamleden</p>

            <ul class="text-dg1 list-unstyled text-left">
                <li>Albert A. Baffour </li>
                <li>Jetze Luyten</li>
                <li>Michiel Hendrickx</li>
                <li>Miel Goossens</li>
                <li>Seppe Jacobin</li>
            </ul>
        </div>

        <div class="border-light col-12 col-sm-12 col-md-6 border-left text-left p-3">
            <p class="font-weight-bold">Info</p>
            <p>  Deze webapplicatie is gemaakt in het kader van Project-PHP.
                Het is een online onkostenvergoedingsportaal waar werknemers
                van Thomas More hun vergoedingen kunnen aanvragen.
            </p>
            <a href="https://thomasmore.be" title="bezoek Thomas More website" target="_blank">
                <img src="/images/tm_logo.png" width="150px" alt="TM logo">
            </a>
        </div>
    </div>


</div>

{{--        DO NOT DELETE - TIMESTAMP IN FOOTER!--}}
<script>
    const date = new Date();
    const year = date.getFullYear();

    document.getElementById('copyright-year').innerHTML = ("© " + year);
</script>
