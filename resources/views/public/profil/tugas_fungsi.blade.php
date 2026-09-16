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
        <a href="{{ route('profil', 'tentang') }}"
           class="tab-item {{ request('section') == 'tentang' ? 'aktif' : '' }}">
            Tentang Pusdatin
        </a>

        <a href="{{ route('profil', 'tugas-fungsi') }}"
           class="tab-item {{ request('section', 'tugas-fungsi') == 'tugas-fungsi' ? 'aktif' : '' }}">
            Tugas & Fungsi
        </a>

        <a href="{{ route('profil', 'visi-misi') }}"
           class="tab-item {{ request('section') == 'visi-misi' ? 'aktif' : '' }}">
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
    $tugas = content(
        'profil.tugas',
        'Pusat Data dan Teknologi Informasi mempunyai tugas melaksanakan perumusan dan pelaksanaan kebijakan di bidang pengelolaan pusat data dan teknologi informasi pada Badan Nasional Penanggulangan Terorisme.'
    );

    $fungsiList = array_filter(
        array_map(
            'trim',
            explode(
                "\n",
                content(
                    'profil.fungsi',
                    "Perumusan kebijakan teknis pengelolaan pusat data;
Pelaksanaan pengelolaan infrastruktur teknologi informasi;
Pengembangan dan pemeliharaan sistem informasi;
Pelayanan teknologi informasi bagi unit kerja di lingkungan BNPT;
Pelaksanaan urusan administrasi Pusdatin."
                )
            )
        )
    );
@endphp

<section class="konten-profil-wrap reveal-tab">
    <div class="container-profil">

        <span class="sub-judul-merah">DASAR HUKUM & KEWENANGAN</span>

        <h2>Tugas & Fungsi Utama</h2>

        <p>
            {{ $tugas }}
        </p>

        <div class="grid-tugas-modern">

            @foreach ($fungsiList as $index => $fungsi)
                <div class="kartu-tugas-item">

                    <span class="nomor-tugas">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <h3>Fungsi {{ $index + 1 }}</h3>

                    <p>
                        {{ $fungsi }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
</section>

@endsection