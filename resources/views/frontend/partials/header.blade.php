<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center" style="background:#044085 !important;">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo">
            <a href="{{ url('/') }}"></a>
        </h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link {{ request()->route()->uri=='/'?'active':'' }}" href="{{ url('/') }}">Beranda</a></li>
                <li><a class="nav-link {{ request()->route()->uri == 'laporan-kejadian' ? 'active':'' }}" href="{{ url('/laporan-kejadian') }}">Laporan Kejadian</a></li>
                <li><a class="nav-link {{ request()->route()->uri=='data-bencana'?'active':'' }}" href="{{ url('/data-bencana') }}">Data Bencana</a></li>
                <li><a class="nav-link {{ request()->route()->uri=='grafik-kejadian'?'active':'' }}" href="{{ url('/grafik-kejadian') }}">Grafik</a></li>
                <li><a class="nav-link {{ request()->route()->uri=='dokumentasi'?'':'' }}" href="{{ url('/dokumentasi') }}">Dokumentasi</a></li>
                <li><a class="nav-link {{ request()->route()->uri=='kontak'?'':'' }}" href="{{ url('/kontak') }}">Kontak</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->