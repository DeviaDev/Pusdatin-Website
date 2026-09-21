<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Pusdatin BNPT</title>
    <link rel="stylesheet" href="{{ asset('css/pusdatin.css') }}">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
    /* =====================================================
       ADMIN MOBILE
       ===================================================== */

    .admin-mobile-header {
        display: none;
    }

    .admin-overlay {
        display: none;
    }

    @media (max-width: 768px) {

        /* ==============================
           MOBILE HEADER
           ============================== */

        .admin-mobile-header {
            display: flex;

            position: sticky;
            top: 0;
            z-index: 1300;

            height: 64px;
            padding: 0 16px;

            align-items: center;
            justify-content: space-between;

            background: #ffffff;
            border-bottom: 1px solid #eeeeee;

            box-sizing: border-box;
        }

        .admin-mobile-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-mobile-title .kotak {
            width: 38px;
            height: 38px;
            min-width: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #c8102e;
            color: #fff;

            border-radius: 5px;

            font-size: 12px;
            font-weight: 700;
        }

        .admin-mobile-title strong {
            font-size: 15px;
            color: #222;
        }

        .admin-menu-toggle {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;
            background: transparent;

            color: #c8102e;
            font-size: 25px;

            cursor: pointer;
        }


        /* ==============================
           SIDEBAR
           ============================== */

        .admin-side {
            position: fixed !important;

            top: 0;
            left: 0;

            width: 280px !important;
            height: 100vh;

            z-index: 1200;

            transform: translateX(-100%);

            transition: transform .25s ease;

            overflow-y: auto;
        }

        .admin-side.mobile-open {
            transform: translateX(0);
        }


        /* ==============================
           OVERLAY
           ============================== */

        .admin-overlay {
            position: fixed;

            inset: 0;

            z-index: 1150;

            background: rgba(0, 0, 0, .45);
        }

        .admin-overlay.active {
            display: block;
        }


        /* ==============================
           MAIN
           ============================== */

        .admin-wrap {
            display: block !important;

            width: 100% !important;
            min-width: 0 !important;
        }

        .admin-main {
            width: 100% !important;
            min-width: 0 !important;

            margin: 0 !important;
        }


        /* ==============================
           TOPBAR DESKTOP
           ============================== */

        .admin-top {
            display: none !important;
        }


        /* ==============================
           CONTENT
           ============================== */

        .admin-body {
            width: 100% !important;
            max-width: 100% !important;

            padding: 20px 16px !important;

            box-sizing: border-box;

            overflow-x: hidden;
        }


        /* ==============================
           PANEL
           ============================== */

        .panel {
            width: 100% !important;
            max-width: 100% !important;

            box-sizing: border-box;

            overflow-x: auto;
        }


        /* ==============================
           TABLE
           ============================== */

        .tabel {
            min-width: 650px;
        }


        /* ==============================
           KARTU / GRID DASHBOARD
           ============================== */

        .admin-body > div {
            max-width: 100%;
        }
    }
</style>
</head>
<body>
    <div class="admin-wrap">


    <div class="admin-mobile-header">

    <div class="admin-mobile-title">
        <div class="kotak">BNPT</div>

        <div>
            <strong>PUSDATIN BNPT</strong>
        </div>
    </div>

    <button type="button"
            class="admin-menu-toggle"
            id="adminMenuToggle"
            aria-label="Buka menu">
        <i class="bi bi-list"></i>
    </button>

    </div>
    
    <div class="admin-overlay" id="adminOverlay"></div>

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
                        <button type="submit"
                                class="btn-keluar"
                                style="cursor:pointer;">
                            Keluar
                        </button>
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
    <script>
    const adminMenuToggle = document.getElementById('adminMenuToggle');
    const adminSide = document.querySelector('.admin-side');
    const adminOverlay = document.getElementById('adminOverlay');

    if (adminMenuToggle && adminSide && adminOverlay) {

        adminMenuToggle.addEventListener('click', function () {

            adminSide.classList.toggle('mobile-open');
            adminOverlay.classList.toggle('active');

            const icon = this.querySelector('i');

            if (adminSide.classList.contains('mobile-open')) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x-lg');
            } else {
                icon.classList.remove('bi-x-lg');
                icon.classList.add('bi-list');
            }
        });


        adminOverlay.addEventListener('click', function () {

            adminSide.classList.remove('mobile-open');
            adminOverlay.classList.remove('active');

            const icon = adminMenuToggle.querySelector('i');

            icon.classList.remove('bi-x-lg');
            icon.classList.add('bi-list');
        });

    }
</script>
</body>
</html>
