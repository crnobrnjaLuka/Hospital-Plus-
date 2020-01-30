@extends('layouts.index')

@section('content')

<div class="mainContent">
    <div class="contentOptions">
        <div class="contentItems">
            @auth
            @if (Auth::user()->role==2)
            <div class="optionsItems">
                <a href="/kartoniStranica">
                    <div class="nav-btn btn-icons btn-icons">
                        <p class="records">Kartoni</p>
                        <img src="/images/medical-report.png" alt="report">
                    </div>
                </a>
            </div>
            @endif
            @if (Auth::user()->role==3)
            <div class="optionsItems optionKorisnik">
                <a href="/admin">
                    <div class="nav-btn btn-icons">
                        <p class="records">Spisak korisnika</p>
                        <img src="/images/medical-doctor.png" alt="doctor">
                    </div>
                </a>
            </div>
            @endif
            @if (Auth::user()->role==1)
            <div class="optionsItems">
                <a href="/osoblje">
                    <div class="nav-btn btn-icons">
                        <p class="records">Pacijenti</p>
                        <img src="/images/patient.png" alt="patient">
                    </div>
                </a>
            </div>
            @endif
            @if (Auth::user()->role==1 or Auth::user()->role==2)
            <div class="optionsItems">
                <a href="/bolesti">
                    <div class="nav-btn btn-icons">
                        <p class="records">Oboljenja</p>
                        <img src="/images/medical-notes.png" alt="medical-notes">
                    </div>
                </a>
            </div>
            <div class="optionsItems">
                <a href="/lekovi">
                    <div class="nav-btn btn-icons">
                        <p class="records">Medikamenti</p>
                        <img src="/images/medical-pills.png" alt="pills">
                    </div>
                </a>
            </div>
            @endif
            @endauth
        </div>
        <div class="weather">
            <div class="weatherItems">
                <div class="marginWeather">
                    <div id="vreme"></div>
                    <script src="/js/app.js"></script>
                </div>
            </div>
        </div>
        <div class="info">
            <div class="infoItems">
                <div class="infoContainer">
                    <div class="hospitalInfo">
                        <img src="/images/location.png" alt="location"><span>Savski Nasip 1</span>
                    </div>
                    <div class="hospitalInfo">
                        <img src="/images/phone.png" alt="phone"><span>011/1111-222</span>
                    </div>
                    <div class="hospitalInfo">
                        <img src="/images/hour.png" alt="hour"><span>00 - 24</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection