@extends('layouts.public')
@section('title', 'Beranda')
@section('content')
    <section class="hero">
        <h1>{!! nl2br(e(content('beranda.judul', "Pusat Data dan Teknologi Informasi BNPT"))) !!}</h1>
        <p>{{ content('beranda.subjudul', 'Mendorong efisiensi dan inovasi layanan teknologi informasi untuk mendukung implementasi penanggulangan terorisme yang komprehensif dan terintegrasi.') }}</p>
        <div style="display:flex; gap:14px; flex-wrap:wrap;">
            <a href="{{ route('login') }}" class="btn-merah">Layanan Pengaduan</a>
            <a href="{{ route('sop') }}" class="btn-outline" style="color:#fff;border-color:#fff">Telusuri Pusdatin</a>
        </div>
        <div class="stats">
            <div><b>142+</b><small>Sistem dan Aplikasi</small></div>
            <div><b>99.7%</b><small>UPTIME SERVER</small></div>
            <div><b>2.4 TB</b><small>KAPASITAS STORAGE</small></div>
            <div><b>1,200+</b><small>USER AKTIF</small></div>
        </div>
    </section>

    <section class="konten">
        <h2>Layanan Utama Pusdatin</h2>
        <div class="grid-3">
            <div class="kartu"><h3>Gangguan Perangkat Keras</h3><p>Laporan aduan terkait komputer, laptop, printer, scanner, serta perangkat pendukung operasional lainnya.</p></div>
            <div class="kartu"><h3>Gangguan Perangkat Lunak</h3><p>Meliputi aduan terkait sistem operasi, aplikasi operasional, serta aplikasi-aplikasi pendukung lainnya.</p></div>
            <div class="kartu"><h3>Jaringan dan Infrastruktur Internet</h3><p>Meliputi aduan gangguan ataupun permintaan layanan terkait kabel LAN, server, switch, router, firewall, serta koneksi internet.</p></div>
            <div class="kartu"><h3>Layanan Akun Email</h3><p>Meliputi aduan dan permintaan terkait akun surat elektronik (email) resmi.</p></div>
            <div class="kartu"><h3>Layanan Hak Akses</h3><p>Meliputi aduan dan permintaan terkait Hak Akses Non Fisik (network, database, internet, VPN) dan Hak Akses Fisik (akses kantor dan ruang pusat data).</p></div>
            <div class="kartu"><h3>Dokumen SOP</h3><p>Standar Operasional Prosedur layanan teknologi informasi Pusdatin dapat diunduh melalui menu SOP Pusdatin.</p></div>
        </div>
    </section>

    @if ($pengumuman->count())
    <section class="konten" style="background:var(--abu);">
        <h2>Informasi Terkini</h2>
        <div class="grid-3">
            @foreach ($pengumuman as $item)
                <a href="{{ route('informasi.show', $item) }}" style="text-decoration:none;color:inherit;">
                    <div class="kartu">
                        <div class="berita-thumb"></div>
                        <span class="badge badge-diproses">{{ $item->kategori }}</span>
                        <h3 style="margin-top:10px;">{{ $item->judul }}</h3>
                        <p>{{ Str::limit($item->isi, 120) }}</p>
                        <small style="color:#999;">{{ $item->published_at->format('d F Y') }}</small>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    <section class="konten" style="text-align:center;">
        <h2>Mitra    Pusdatin</h2>
        <div style="display:flex; gap:40px; justify-content:center; flex-wrap:wrap; color:#999; font-weight:600;">
            <span>dgital</span><span>KOMINFO</span><span>JDN</span><span>LAPOR!</span>
        </div>

        {{-- helper content() lama tetap jalan, cukup pakai key yang sesuai --}}
        <h3>{{ content('mitra.nama_1') }}</h3>
        <img src="{{ asset('storage/'.content('mitra.logo_1')) }}" alt="Mitra">
    </section>
@endsection
