<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Pegawai') — Pusdatin BNPT</title>
    <link rel="stylesheet" href="{{ asset('css/pusdatin.css') }}">
</head>
<body>
    <div class="topbar">
        <span>Badan Nasional Penanggulangan Terorisme Republik Indonesia</span>
        <span class="lang"><a href="#" class="aktif">Indonesia</a><a href="#">English</a></span>
    </div>

    <form id="baca-semua" method="POST" action="{{ route('portal.notifikasi.baca') }}" style="display:none">@csrf</form>

    @php
        $renderNotif = function() {
            return view()->exists('partials.notif-items') ? null : null;
        };
    @endphp

    {{-- ===== HEADER MOBILE ===== --}}
    <div class="portal-mobile-header">
        <a href="{{ route('beranda') }}" class="logo">
            <div class="kotak">BNPT</div>
            <div class="nama">PUSDATIN BNPT<small>Pusat Data dan Informasi</small></div>
        </a>

        <div class="portal-mobile-actions">
            <div class="drop portal-mobile-notif">
                <button aria-label="Notifikasi" style="position:relative;">
                    &#128276;
                    @if (auth()->user()->unreadNotifications->count())
                        <span class="notif-dot">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>
                <div class="drop-menu">
                    @forelse (auth()->user()->notifications()->latest()->take(6)->get() as $n)
                        <div class="item" style="{{ $n->read_at ? '' : 'background:#fbf1f3;' }}">
                            {{ $n->data['pesan'] ?? 'Notifikasi' }}<br>
                            <small>{{ $n->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="item">Belum ada notifikasi.</div>
                    @endforelse
                    <div class="item" style="text-align:center;">
                        <a href="{{ route('portal.notifikasi.baca') }}" onclick="event.preventDefault(); document.getElementById('baca-semua').submit();" style="color:var(--merah)">Tandai semua dibaca</a>
                    </div>
                </div>
            </div>

            <button type="button" class="portal-menu-toggle" id="portalMenuToggle" aria-label="Buka menu">☰</button>
        </div>
    </div>

    <div class="portal-overlay" id="portalOverlay"></div>

    {{-- ===== HEADER DESKTOP ===== --}}
    <header class="site portal-topnav">
        <a href="{{ route('beranda') }}" class="logo">
            <div class="kotak">BNPT</div>
            <div class="nama">PUSDATIN BNPT<small>Pusat Data dan Informasi</small></div>
        </a>

        <nav class="main">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard', 'admin.dashboard') ? 'aktif' : '' }}">Dashboard</a>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil*') ? 'aktif' : '' }}">Profil</a>
            <a href="{{ route('informasi') }}" class="{{ request()->routeIs('informasi*') ? 'aktif' : '' }}">Informasi</a>
            <a href="{{ route('sop') }}" class="{{ request()->routeIs('sop') ? 'aktif' : '' }}">SOP Pusdatin</a>
        </nav>

        <div style="display:flex; align-items:center; gap:16px;">
            <div class="drop">
                <button style="background:none; border:none; cursor:pointer; font-size:1.2rem; position:relative; line-height:1;" aria-label="Notifikasi">
                    &#128276;
                    @if (auth()->user()->unreadNotifications->count())
                        <span class="notif-dot">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>
                <div class="drop-menu">
                    @forelse (auth()->user()->notifications()->latest()->take(6)->get() as $n)
                        <div class="item" style="{{ $n->read_at ? '' : 'background:#fbf1f3;' }}">
                            {{ $n->data['pesan'] ?? 'Notifikasi' }}<br>
                            <small>{{ $n->created_at->diffForHumans() }}</small>
                        </div>
                    @empty
                        <div class="item">Belum ada notifikasi.</div>
                    @endforelse
                    <div class="item" style="text-align:center;">
                        <a href="{{ route('portal.notifikasi.baca') }}" onclick="event.preventDefault(); document.getElementById('baca-semua').submit();" style="color:var(--merah)">Tandai semua dibaca</a>
                    </div>
                </div>
            </div>

            <span style="font-size:.9rem; white-space:nowrap;">&#128100; {{ auth()->user()->nama }}</span>

            <form method="POST" action="{{ route('logout') }}" style="margin:0; padding:0; display:inline-block;">@csrf
                <button type="submit" class="btn-merah" style="cursor:pointer; font-family:inherit; border:none; outline:none;">Keluar</button>
            </form>
        </div>
    </header>

    <div class="portal-wrap">
        <aside class="sidebar" id="portalSidebar">
            <div class="grup">Portal Pegawai</div>
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard', 'admin.dashboard') ? 'aktif' : '' }}">&#9638; Dashboard</a>
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.tiket.index') }}" class="{{ request()->routeIs('portal.tiket*', 'admin.tiket*') ? 'aktif' : '' }}">&#9432; Layanan Pengaduan</a>
            <div class="grup">Bantuan</div>
            <div style="padding: 14px 22px; font-size: .85rem; color: #666;">
                Helpdesk TI<br>(021) 384-5555 ext. 200
            </div>

            <div class="sidebar-mobile-footer">
                <div class="nama-user">&#128100; {{ auth()->user()->nama }}</div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-keluar">Keluar</button>
                </form>
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
        // Semua dropdown notifikasi (desktop & mobile) pakai satu logika ini
        document.querySelectorAll('.drop').forEach(function (dropEl) {
            const btn = dropEl.querySelector('button');
            if (!btn) return;
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                document.querySelectorAll('.drop.open').forEach(function (d) {
                    if (d !== dropEl) d.classList.remove('open');
                });
                dropEl.classList.toggle('open');
            });
        });
        document.addEventListener('click', function () {
            document.querySelectorAll('.drop.open').forEach(d => d.classList.remove('open'));
        });

        const portalMenuToggle = document.getElementById('portalMenuToggle');
        const portalSide = document.getElementById('portalSidebar');
        const portalOverlay = document.getElementById('portalOverlay');

        if (portalMenuToggle && portalSide && portalOverlay) {
            portalMenuToggle.addEventListener('click', function () {
                portalSide.classList.toggle('mobile-open');
                portalOverlay.classList.toggle('active');
                this.textContent = portalSide.classList.contains('mobile-open') ? '✕' : '☰';
            });

            portalOverlay.addEventListener('click', function () {
                portalSide.classList.remove('mobile-open');
                portalOverlay.classList.remove('active');
                portalMenuToggle.textContent = '☰';
            });
        }
    </script>
</body>
</html>