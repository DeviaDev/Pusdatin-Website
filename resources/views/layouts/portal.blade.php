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

    <header class="site">
        <a href="{{ route('beranda') }}" class="logo">
            <div class="kotak">BNPT</div>
            <div class="nama">PUSDATIN BNPT<small>Pusat Data dan Informasi</small></div>
        </a>
        <nav class="main">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.dashboard') }}" class="aktif">Dashboard</a>
            <a href="{{ route('profil') }}">Profil</a>
            <a href="{{ route('informasi') }}">Informasi</a>
            <a href="{{ route('sop') }}">SOP Pusdatin</a>
        </nav>
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="drop" id="notif-drop">
                <button style="background:none;border:none;cursor:pointer;font-size:1.2rem;position:relative;" aria-label="Notifikasi">
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
            <form id="baca-semua" method="POST" action="{{ route('portal.notifikasi.baca') }}" style="display:none">@csrf</form>
            <span style="font-size:.9rem;">&#128100; {{ auth()->user()->nama }}</span>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="btn-outline" style="cursor:pointer">Keluar</button>
            </form>
        </div>
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
            <div class="portal-top">
                <strong>@yield('page-title', 'Dashboard')</strong>
                <a href="{{ route('portal.tiket.create') }}" class="btn-merah">+ Buat Tiket</a>
            </div>
            <div class="portal-body">
                @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/accessibility.js') }}"></script>
    <script>
        document.getElementById('notif-drop').querySelector('button').addEventListener('click', function () {
            document.getElementById('notif-drop').classList.toggle('open');
        });
    </script>
</body>
</html>
