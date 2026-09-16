<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pusdatin BNPT') — Pusat Data dan Teknologi Informasi</title>
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
            <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'aktif' : '' }}">Beranda</a>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil*') ? 'aktif' : '' }}">Profil</a>
            <a href="{{ route('informasi') }}" class="{{ request()->routeIs('informasi*') ? 'aktif' : '' }}">Informasi</a>
            <a href="{{ route('sop') }}" class="{{ request()->routeIs('sop') ? 'aktif' : '' }}">SOP Pusdatin</a>
        </nav>

        {{-- SEARCH
    <form action="{{ route('search') }}" method="GET" class="search-form">
        <input 
            type="text" 
            name="q" 
            placeholder="Cari informasi..."
            value="{{ request('q') }}"
        >

        <button type="submit" aria-label="Cari">
            🔍
        </button>
    </form> --}}
    
        @auth
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('portal.dashboard') }}" class="btn-merah">Portal Saya</a>
        @else
            <a href="{{ route('login') }}" class="btn-merah">Masuk</a>
        @endauth
    </header>

    @if (session('success'))
        <div style="padding: 12px 5%; background:#d1e7dd; color:#146c43;">{{ session('success') }}</div>
    @endif

    @yield('content')

    <footer class="site">
        <div class="kolom">
            <div>
                <h4>PUSDATIN BNPT</h4>
                <p>Pusat Data dan Teknologi Informasi Badan Nasional Penanggulangan Terorisme Republik Indonesia, insfrastruktur TIK strategis penanggulangan terorisme.</p>
            </div>
            <div>
                <h4>Navigasi</h4>
                <a href="{{ route('beranda') }}">Beranda</a>
                <a href="{{ route('profil') }}">Profil Pusdatin</a>
                <a href="{{ route('informasi') }}">Informasi</a>
                <a href="{{ route('sop') }}">Layanan</a>
            </div>
            <div>
                <h4>Layanan</h4>
                <a href="{{ route('login') }}">Gangguan Perangkat Keras</a>
                <a href="{{ route('login') }}">Gangguan Perangkat Lunak</a>
                <a href="{{ route('login') }}">Jaringan dan Infrastruktur Internet</a>
                <a href="{{ route('login') }}">Layanan Akun Email</a>
                <a href="{{ route('login') }}">Layanan Hak Akses</a>
            </div>
            <div>
                <h4>Kontak</h4>
                <p>Jl. H. Juanda No. 1, Jakarta Pusat 10120<br>
                pusdatin@bnpt.go.id<br>
                (021) 384-5555 ext. 200</p>
                <p>Jam Layanan:<br>Senin – Jumat: 08.00 – 16.00 WIB</p>
            </div>
        </div>
        <div class="bawah">
            <span>&copy; 2026 Pusdatin BNPT — Badan Nasional Penanggulangan Terorisme Republik Indonesia</span>
            <span><a href="#" style="display:inline">Kebijakan Privasi</a> &middot; <a href="#" style="display:inline">Syarat &amp; Ketentuan</a> &middot; <a href="#" style="display:inline">Peta Situs</a></span>
        </div>
    </footer>

    <script src="{{ asset('js/accessibility.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
</body>
</html>
