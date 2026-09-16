@extends('layouts.public')
@section('title', 'Tugas & Fungsi')

@section('content')
<div class="header-profil">
    <div class="header-profil-body">
        <span class="sub-judul-profil">TENTANG KAMI</span>
        <h1>Profile Pusdatin BNPT</h1>
    </div>
</div>

<div class="tab-profil-wrapper">
    <div class="tab-profil-container">
        <a href="{{ route('profil', 'tentang') }}" class="tab-item {{ request('section') == 'tentang' ? 'aktif' : '' }}">Tentang Pusdatin</a>
        <a href="{{ route('profil', 'tugas-fungsi') }}" class="tab-item {{ request('section', 'tugas-fungsi') == 'tugas-fungsi' ? 'aktif' : '' }}">Tugas & Fungsi</a>
        <a href="{{ route('profil', 'visi-misi') }}" class="tab-item {{ request('section') == 'visi-misi' ? 'aktif' : '' }}">Visi & Misi</a>
        <a href="{{ route('profil', 'struktur') }}" class="tab-item {{ request('section') == 'struktur' ? 'aktif' : '' }}">Struktur Organisasi</a>
        <a href="{{ route('profil', 'kontak') }}" class="tab-item {{ request('section') == 'kontak' ? 'aktif' : '' }}">Kontak</a>
    </div>
</div>

<section class="konten-profil-wrap reveal-tab">
        <div class="container-profil">
            <span class="sub-judul-merah">DASAR HUKUM & KEWENANGAN</span>
            <h2>Tugas & Fungsi Utama</h2>
            <p>Berdasarkan Peraturan Kepala BNPT tentang Organisasi dan Tata Kerja, Pusdatin mengemban tugas dan fungsi sebagai berikut:</p>
            
            <div class="grid-tugas-modern">
                <div class="kartu-tugas-item">
                    <span class="nomor-tugas">01</span>
                    <h3>Pengelolaan Data</h3>
                    <p>Mengumpulkan, mengolah, dan mengelola data serta informasi terkait penanggulangan terorisme dan radikalisme di seluruh wilayah Indonesia.</p>
                </div>
                <div class="kartu-tugas-item">
                    <span class="nomor-tugas">02</span>
                    <h3>Pengembangan Sistem Informasi</h3>
                    <p>Membangun, mengembangkan, dan memelihara sistem informasi terintegrasi untuk mendukung operasional BNPT dan stakeholder terkait.</p>
                </div>
                <div class="kartu-tugas-item">
                    <span class="nomor-tugas">03</span>
                    <h3>Diseminasi Informasi</h3>
                    <p>Menyebarluaskan data dan informasi kepada instansi pemerintah, lembaga terkait, dan masyarakat umum sesuai ketentuan yang berlaku.</p>
                </div>
                <div class="kartu-tugas-item">
                    <span class="nomor-tugas">04</span>
                    <h3>Analisis & Statistik</h3>
                    <p>Melakukan analisis statistik dan penyusunan laporan periodik mengenai perkembangan situasi keamanan dan penanggulangan terorisme.</p>
                </div>
                <div class="kartu-tugas-item">
                    <span class="nomor-tugas">05</span>
                    <h3>Koordinasi Data</h3>
                    <p>Mengordinasikan pertukaran data dan informasi antar kementerian/lembaga, pemerintah daerah, dan mitra strategis internasional.</p>
                </div>
                <div class="kartu-tugas-item">
                    <span class="nomor-tugas">06</span>
                    <h3>Keamanan Data</h3>
                    <p>Memastikan keamanan, integritas, dan kerahasiaan data sesuai standar keamanan informasi yang berlaku (SNI ISO/IEC 27001).</p>
                </div>
            </div>
        </div>
</section>
@endsection