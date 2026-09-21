<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Pegawai') — Pusdatin BNPT</title>
    <link rel="stylesheet" href="{{ asset('css/pusdatin.css') }}">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="topbar">
        <span>Badan Nasional Penanggulangan Terorisme Republik Indonesia</span>
        <span class="lang"><a href="#" class="aktif">Indonesia</a><a href="#">English</a></span>
    </div>

    <div class="portal-mobile-header">
    <div class="portal-mobile-title">
        <a href="{{ route('beranda') }}" class="logo">
            <div class="kotak">BNPT</div>
            <div class="nama">
                PUSDATIN BNPT
                <small>Pusat Data dan Informasi</small>
            </div>
        </a>
    </div>

    <button type="button"
            class="portal-menu-toggle"
            id="portalMenuToggle"
            aria-label="Buka menu">
        <i class="bi bi-list"></i>
    </button>
</div>

<div class="portal-overlay" id="portalOverlay"></div>

<header class="site">

    {{-- LOGO --}}
    <a href="{{ route('beranda') }}" class="logo">
        <div class="kotak">BNPT</div>
        <div class="nama">
            PUSDATIN BNPT
            <small>Pusat Data dan Informasi</small>
        </div>
    </a>



</header>

    <div class="portal-wrap">
        <aside class="sidebar">
            <div class="grup">Portal Pegawai</div>
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard', 'admin.dashboard') ? 'aktif' : '' }}">&#9638; Dashboard</a>
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.tiket.index') }}" class="{{ request()->routeIs('portal.tiket*', 'admin.tiket*') ? 'aktif' : '' }}">&#9432; Layanan Pengaduan</a>
            <div class="grup">Bantuan</div>
            <div style="padding: 14px 22px; font-size: .85rem; color: #666;">
                Helpdesk TI<br>(021) 384-5555 ext. 200
            </div>
        </aside>

        <main class="portal-main">
            <div class="portal-body">
                @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/accessibility.js') }}"></script>



  <script>
    const portalMenuToggle = document.getElementById('portalMenuToggle');
    const portalSide = document.querySelector('.sidebar');
    const portalOverlay = document.getElementById('portalOverlay');

    if (portalMenuToggle && portalSide && portalOverlay) {

        portalMenuToggle.addEventListener('click', function () {

            portalSide.classList.toggle('mobile-open');
            portalOverlay.classList.toggle('active');

            const icon = this.querySelector('i');

            if (portalSide.classList.contains('mobile-open')) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x-lg');
            } else {
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            }
        });

        portalOverlay.addEventListener('click', function () {

            portalSide.classList.remove('mobile-open');
            portalOverlay.classList.remove('active');

            const icon = portalMenuToggle.querySelector('i');

            icon.classList.remove('bi-x-lg');
            icon.classList.add('bi-list');
        });

    }
</script>


</body>
</html>
