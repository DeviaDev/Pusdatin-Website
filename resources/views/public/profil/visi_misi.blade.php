@extends('layouts.public')
@section('title', 'Visi & Misi')

@section('content')

<div class="header-profil">
    <div class="header-profil-body">
        <span class="sub-judul-profil">TENTANG KAMI</span>
        <h1>Profile Pusdatin BNPT</h1>
    </div>
</div>

<div class="tab-profil-wrapper">
    <div class="tab-profil-container">
        <a href="{{ route('profil', 'tentang') }}"
           class="tab-item {{ request('section') == 'tentang' ? 'aktif' : '' }}">
            Tentang Pusdatin
        </a>

        <a href="{{ route('profil', 'tugas-fungsi') }}"
           class="tab-item {{ request('section') == 'tugas-fungsi' ? 'aktif' : '' }}">
            Tugas & Fungsi
        </a>

        <a href="{{ route('profil', 'visi-misi') }}"
           class="tab-item {{ request('section', 'visi-misi') == 'visi-misi' ? 'aktif' : '' }}">
            Visi & Misi
        </a>

        <a href="{{ route('profil', 'struktur') }}"
           class="tab-item {{ request('section') == 'struktur' ? 'aktif' : '' }}">
            Struktur Organisasi
        </a>

        <a href="{{ route('profil', 'kontak') }}"
           class="tab-item {{ request('section') == 'kontak' ? 'aktif' : '' }}">
            Kontak
        </a>
    </div>
</div>

@php
    $visi = content(
        'profil.visi',
        'Terwujudnya pusat data dan teknologi informasi yang andal, aman, dan terintegrasi untuk mendukung penanggulangan terorisme.'
    );

    $misiList = array_filter(
        array_map(
            'trim',
            explode(
                "\n",
                content(
                    'profil.misi',
                    "Mengelola infrastruktur TI yang andal
Menyediakan layanan TI yang prima
Mengembangkan SDM TI yang kompeten
Menerapkan tata kelola keamanan informasi"
                )
            )
        )
    );
@endphp
```


<section class="konten-profil-wrap reveal-tab">
    <div class="container-profil layout-human">

        {{-- VISI --}}
        <div class="section-visi-editorial">
            <span class="sub-judul-merah">VISI PUSDATIN</span>

            <blockquote class="teks-visi-besar">
                "{{ $visi }}"
            </blockquote>
        </div>

        <hr class="pembatas-tipis">

        {{-- MISI --}}
        <div class="section-misi-modern">

            <div class="header-tengah">
                <span class="sub-judul-merah">MISI PUSDATIN</span>
                <h2>Komitmen Utama Kami</h2>
            </div>

            <div class="grid-misi-vertikal">

                @foreach ($misiList as $index => $misi)
                    <div class="card-misi-vertikal">

                        <div class="badge-nomor-misi">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <p>{{ $misi }}</p>

                    </div>
                @endforeach

            </div>

        </div>

        <hr class="pembatas-tipis">

        {{-- CORE VALUES --}}
        <div class="section-values-modern">

            <div class="header-tengah">
                <span class="sub-judul-merah">NILAI-NILAI ORGANISASI</span>
                <h2>Core Values Pusdatin</h2>
            </div>

            <div class="grid-values-clean">

                <div class="card-val">
                    <h3>Integritas</h3>
                    <p>Menjalankan tugas dengan jujur, konsisten, dan bertanggung jawab.</p>
                </div>

                <div class="card-val">
                    <h3>Profesionalisme</h3>
                    <p>Bekerja dengan keahlian tinggi, standar mutu, dan komitmen penuh.</p>
                </div>

                <div class="card-val">
                    <h3>Inovasi</h3>
                    <p>Terus berinovasi dalam pengembangan teknologi dan layanan data.</p>
                </div>

                <div class="card-val">
                    <h3>Kolaborasi</h3>
                    <p>Membangun sinergi dan kerja sama lintas sektor yang efektif.</p>
                </div>

            </div>

        </div>

    </div>
</section>

@endsection