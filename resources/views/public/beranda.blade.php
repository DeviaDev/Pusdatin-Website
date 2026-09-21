@extends('layouts.public')
@section('title', 'Beranda')
@php
    $mitraFields = \App\Models\ContentGroupField::where('key', 'like', 'mitra.logo_%')
        ->where('type', 'image')
        ->orderBy('urutan')
        ->get();
@endphp
@section('content')
    <section class="hero">
        <h1>{!! nl2br(e(content('beranda.judul', "Pusat Data dan Teknologi Informasi BNPT"))) !!}</h1>
        <p>{{ content('beranda.subjudul', 'Mendorong efisiensi dan inovasi layanan teknologi informasi untuk mendukung implementasi penanggulangan terorisme yang komprehensif dan terintegrasi.') }}</p>
        <div style="display:flex; gap:14px; flex-wrap:wrap;">
            <a href="{{ route('login') }}" class="btn-merah">Layanan Pengaduan</a>
            <a href="{{ route('sop') }}" class="btn-outline">Telusuri Pusdatin</a>
        </div>
        <div class="stats">
            <div><b>142+</b><small>Sistem dan Aplikasi</small></div>
            <div><b>99.7%</b><small>UPTIME SERVER</small></div>
            <div><b>2.4 TB</b><small>KAPASITAS STORAGE</small></div>
            <div><b>1,200+</b><small>USER AKTIF</small></div>
        </div>
    </section>

    <!-- Section Layanan Utama (Judul langsung tampil dari awal) -->
    <section class="konten">
        <div class="judul-section">
            <span class="sub-judul">AKSES CEPAT</span>
            <h2>Layanan Utama Pusdatin</h2>
        </div>
        
        <!-- Animasi Scroll HANYA untuk Kartu-Kartu Layanan -->
        <div class="grid-layanan reveal-on-scroll">
            <div class="kartu-layanan">
                <div class="ikon-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <h3>Gangguan Perangkat Keras</h3>
                <p>Laporan aduan terkait komputer, laptop, printer, scanner, serta perangkat pendukung operasional lainnya.</p>
            </div>

            <div class="kartu-layanan">
                <div class="ikon-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <h3>Gangguan Perangkat Lunak</h3>
                <p>Meliputi aduan terkait sistem operasi, aplikasi operasional, serta aplikasi-aplikasi pendukung lainnya.</p>
            </div>

            <div class="kartu-layanan">
                <div class="ikon-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                </div>
                <h3>Jaringan & Infrastruktur</h3>
                <p>Meliputi aduan gangguan ataupun permintaan layanan terkait kabel LAN, server, switch, router, serta koneksi internet.</p>
            </div>

            <div class="kartu-layanan">
                <div class="ikon-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </div>
                <h3>Layanan Akun Email</h3>
                <p>Meliputi aduan dan permintaan terkait akun surat elektronik (email) resmi instansi.</p>
            </div>

            <div class="kartu-layanan">
                <div class="ikon-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h3>Layanan Hak Akses</h3>
                <p>Meliputi aduan dan permintaan terkait Hak Akses Non-Fisik (VPN, LAN, DB) dan Hak Akses Fisik (Ruang Server).</p>
            </div>
        </div>
    </section>

    <!-- Section Berita & Informasi -->
    @if ($pengumuman->count())
    <section class="konten reveal-on-scroll" style="background: var(--abu); padding: 36px 5%;">
        <div class="judul-section">
            <span class="sub-judul">BERITA & INFORMASI</span>
            <h2>Informasi Terkini dari Pusdatin</h2>
        </div>

        <div class="berita-scroll-wrapper">
            <button type="button" class="scroll-btn left" id="btnScrollLeft" onclick="scrollBerita(-320)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>

            <div class="grid-berita" id="beritaContainer">
                @foreach ($pengumuman as $item)
                    <a href="{{ route('informasi.show', $item) }}" class="kartu-berita">
                        <div class="berita-thumb"
                            style="background-image:url('{{ $item->foto ? asset('storage/'.$item->foto) : asset('images/default-news.jpg') }}');
                                background-size:cover;
                                background-position:center;">
                        </div>
                        <div class="glass-overlay">
                            <div class="glass-header">
                                <span class="badge-kategori">{{ $item->kategori }}</span>
                                <span class="titik">•</span>
                                <span class="tgl-berita">{{ $item->published_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="berita-judul">{{ $item->judul }}</h3>
                            <p class="berita-ringkasan">{{ Str::limit($item->isi, 90) }}</p>
                            <div class="glass-footer">
                                <span class="btn-panah">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <button type="button" class="scroll-btn right" id="btnScrollRight" onclick="scrollBerita(320)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

        <div class="wrap-selengkapnya">
            <a href="{{ route('informasi') }}" class="link-selengkapnya">
                Lihat Selengkapnya <span class="panah">→</span>
            </a>
        </div>
    </section>
    @endif

  <section class="konten mitra-section">

    <div class="judul-section">
        <span class="sub-judul">KERJA SAMA</span>
        <h2>Mitra Pusdatin</h2>
    </div>

    <div class="mitra-grid">

        @foreach ($mitraFields as $logoField)

            @php
                $nomor = str_replace('mitra.logo_', '', $logoField->key);
                $nama = content('mitra.nama_' . $nomor);
                $logo = content($logoField->key);
            @endphp

            @if ($logo)

                <div class="mitra-item">

                    <img src="{{ asset('storage/' . $logo) }}"
                         class="mitra-logo"
                         alt="{{ $nama ?: 'Mitra Pusdatin' }}">

                    @if ($nama)
                        <span class="mitra-nama">
                            {{ $nama }}
                        </span>
                    @endif

                </div>

            @endif

        @endforeach

    </div>

</section>

    <!-- Script Pendeteksi Scroll & Horizontal Scroll Button -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Script Animasi Scroll dengan Trigger Lebih Dalam
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -80px 0px', /* Trigger baru aktif saat elemen masuk 80px dari bawah layar */
                threshold: 0.25 /* Membutuhkan 25% area elemen terlihat baru animasi berjalan */
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-on-scroll').forEach(section => {
                revealObserver.observe(section);
            });

            // Script Horizontal Scroll Berita
            const container = document.getElementById('beritaContainer');
            const btnLeft = document.getElementById('btnScrollLeft');
            const btnRight = document.getElementById('btnScrollRight');

            function updateScrollButtons() {
                if (!container) return;
                const scrollLeft = container.scrollLeft;
                const maxScrollLeft = container.scrollWidth - container.clientWidth;

                if (container.scrollWidth <= container.clientWidth) {
                    btnLeft.style.display = 'none';
                    btnRight.style.display = 'none';
                    container.style.justifyContent = 'center';
                    return;
                }

                container.style.justifyContent = 'flex-start';
                btnLeft.style.display = scrollLeft <= 5 ? 'none' : 'flex';
                btnRight.style.display = scrollLeft >= maxScrollLeft - 5 ? 'none' : 'flex';
            }

            window.scrollBerita = function(amount) {
                container.scrollBy({ left: amount, behavior: 'smooth' });
            };

            if (container) {
                container.addEventListener('scroll', updateScrollButtons);
                window.addEventListener('resize', updateScrollButtons);
                updateScrollButtons();
            }
        });
    </script>
@endsection