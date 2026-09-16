@extends('layouts.public')
@section('title', 'Tentang Pusdatin')

@section('content')
<div class="header-profil">
    <div class="header-profil-body">
        <span class="sub-judul-profil">TENTANG KAMI</span>
        <h1>Profile Pusdatin BNPT</h1>
    </div>
</div>

<div class="tab-profil-wrapper">
    <div class="tab-profil-container">
        <a href="{{ route('profil', 'tentang') }}" class="tab-item {{ request('section', 'tentang') == 'tentang' ? 'aktif' : '' }}">Tentang Pusdatin</a>
        <a href="{{ route('profil', 'tugas-fungsi') }}" class="tab-item {{ request('section') == 'tugas-fungsi' ? 'aktif' : '' }}">Tugas & Fungsi</a>
        <a href="{{ route('profil', 'visi-misi') }}" class="tab-item {{ request('section') == 'visi-misi' ? 'aktif' : '' }}">Visi & Misi</a>
        <a href="{{ route('profil', 'struktur') }}" class="tab-item {{ request('section') == 'struktur' ? 'aktif' : '' }}">Struktur Organisasi</a>
        <a href="{{ route('profil', 'kontak') }}" class="tab-item {{ request('section') == 'kontak' ? 'aktif' : '' }}">Kontak</a>
    </div>
</div>

<section class="konten-profil-wrap reveal-tab">
    <div class="grid-profil-main">
        <div class="kolom-teks-profil">
            <span class="sub-judul-merah">SEKILAS PUSDATIN</span>
            <h2>Pusat Data dan Informasi Badan Nasional Penanggulangan Terorisme</h2>

            {!! nl2br(e(content('profil.tentang', "Pusat Data dan Informasi (Pusdatin) Badan Nasional Penanggulangan Terorisme (BNPT) adalah satuan kerja yang bertugas mengelola, mengintegrasikan, dan mendiseminasikan data serta informasi strategis dalam rangka penanggulangan terorisme di Indonesia.\n\nDibentuk berdasarkan Peraturan Presiden Nomor 46 Tahun 2010 tentang Badan Nasional Penanggulangan Terorisme dan diperkuat melalui Peraturan Kepala BNPT, Pusdatin hadir sebagai tulang punggung sistem informasi BNPT yang andal, aman, dan terintegrasi.\n\nPusdatin bertanggung jawab kepada Kepala BNPT dan berkoordinasi dengan kementerian/lembaga terkait dalam pengelolaan data dan informasi penanggulangan terorisme secara nasional.\n\nDalam era transformasi digital, Pusdatin terus mengembangkan kapasitas teknologi informasinya untuk mendukung kebijakan berbasis data (data-driven policy) yang cepat, tepat, dan akuntabel."))) !!}

            <div class="stats-profil-grid">
                <div class="kartu-stat-profil">
                    <b>{{ content('profil.tahun_berdiri', '2010') }}</b>
                    <small>Tahun Berdiri</small>
                </div>
                <div class="kartu-stat-profil">
                    <b>{{ content('profil.total_pegawai', '87 Orang') }}</b>
                    <small>Total Pegawai</small>
                </div>
            </div>
        </div>

        <div class="kolom-gambar-profil">
            <div class="bingkai-foto-gedung">
                <img src="{{ content('profil.foto_gedung') ? asset('storage/'.content('profil.foto_gedung')) : asset('images/gedung-pusdatin.jpg') }}" alt="Gedung Pusdatin BNPT" onerror="this.src='https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80'">
            </div>

            <div class="grid-lokasi-cabang">
                <div class="keterangan-alamat-profil">
                    <span class="sub-alamat-label">KANTOR PUSAT (JAKARTA)</span>
                    <p class="alamat-teks">{{ content('profil.alamat_pusat', 'Jl. IR. H. Juanda No. 1, Jakarta Pusat 10120') }}</p>
                </div>
                <div class="keterangan-alamat-profil">
                    <span class="sub-alamat-label">KANTOR OPERASIONAL (BOGOR)</span>
                    <p class="alamat-teks">{{ content('profil.alamat_bogor', 'Kompleks IPSC Sentul, Kab. Bogor 16810') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection