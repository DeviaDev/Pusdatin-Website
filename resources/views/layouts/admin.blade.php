<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Pusdatin BNPT</title>
    <link rel="stylesheet" href="{{ asset('css/pusdatin.css') }}">
</head>
<body>
    <div class="admin-wrap">
        {{-- ===== SIDEBAR ADMIN ===== --}}
        <aside class="admin-side">
            <div class="admin-logo">
                <div class="kotak">BNPT</div>
                <div>
                    <b style="color:#fff;">PUSDATIN BNPT</b><br>
                    <small style="color:#888;">Panel Administrator</small>
                </div>
            </div>

            <div class="grup">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'aktif' : '' }}">&#9638; Dashboard</a>

            <div class="grup">Layanan Pengaduan</div>
            <a href="{{ route('admin.tiket.index') }}" class="{{ request()->routeIs('admin.tiket.*') ? 'aktif' : '' }}">&#9432; Tiket Pengaduan</a>

           <div class="grup">Publikasi & Konten</div>
            <a href="{{ route('admin.pengumuman.index') }}" class="{{ request()->routeIs('admin.pengumuman.*') ? 'aktif' : '' }}">&#128196; Informasi / Pengumuman</a>
            <a href="{{ route('admin.sop.index') }}" class="{{ request()->routeIs('admin.sop.*') ? 'aktif' : '' }}">&#128737; Dokumen SOP</a>

            <div class="grup">Konten Website</div>
            @foreach (\App\Models\ContentGroup::orderBy('urutan')->get() as $g)
            <a href="{{ route('admin.konten.edit', $g) }}" class="{{ request()->routeIs('admin.konten.edit') && request()->route('group')?->slug === $g->slug ? 'aktif' : '' }}">
                &#9998; {{ $g->label }}
            </a>
            @endforeach

            <div class="grup">Lainnya</div>
            <a href="{{ route('beranda') }}" target="_blank">&#8599; Lihat Situs Publik</a>
            <div style="padding: 10px 20px; font-size: .8rem; color: #666;">
                Helpdesk TI<br>(021) 384-5555 ext. 200
            </div>
        </aside>

        {{-- ===== MAIN ===== --}}
        <div class="admin-main">
            <header class="admin-top">
                <div>
                    <strong style="font-size:1.05rem;">@yield('page-title', 'Dashboard')</strong><br>
                    <small style="color:#999;">{{ now()->translatedFormat('l, d F Y') }}</small>
                </div>
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
                        </div>
                    </div>
                    <span style="font-size:.9rem;">&#128100; {{ auth()->user()->nama }} <span class="badge badge-ditolak" style="font-size:.7rem;">ADMIN</span></span>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="btn-outline" style="cursor:pointer">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="admin-body">
                @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                @if (session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/accessibility.js') }}"></script>
    <script>
        document.getElementById('notif-drop').querySelector('button').addEventListener('click', function () {
            document.getElementById('notif-drop').classList.toggle('open');
        });
    </script>
</body>
</html>
