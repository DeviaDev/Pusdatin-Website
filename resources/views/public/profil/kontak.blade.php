@extends('layouts.public')
@section('title', 'Kontak')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kontak-public.css') }}">
@endpush
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
        <a href="{{ route('profil', 'tugas-fungsi') }}" class="tab-item {{ request('section') == 'tugas-fungsi' ? 'aktif' : '' }}">Tugas & Fungsi</a>
        <a href="{{ route('profil', 'visi-misi') }}" class="tab-item {{ request('section') == 'visi-misi' ? 'aktif' : '' }}">Visi & Misi</a>
        <a href="{{ route('profil', 'struktur') }}" class="tab-item {{ request('section') == 'struktur' ? 'aktif' : '' }}">Struktur Organisasi</a>
        <a href="{{ route('profil', 'kontak') }}" class="tab-item {{ request('section', 'kontak') == 'kontak' ? 'aktif' : '' }}">Kontak</a>
    </div>
</div>

<section class="konten-profil-wrap reveal-tab">

    <div class="kontak-layout">

        {{-- KOLOM KIRI: INFORMASI KONTAK --}}
        <div class="kolom-teks-profil">

                    <span class="sub-judul-merah">HUBUNGI KAMI</span>
                    <h2>Informasi Kontak</h2>

                    <div class="list-item-kontak">
            <div class="box-icon-kontak">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div>
                <small>KANTOR PUSAT (JAKARTA)</small>
                <p>Jl. IR. H. Juanda No. 1, Jakarta Pusat 10120, DKI Jakarta</p>
            </div>
        </div>

        <div class="list-item-kontak">
            <div class="box-icon-kontak">
                <i class="bi bi-building"></i>
            </div>
            <div>
                <small>KANTOR OPERASIONAL PUSDATIN (BOGOR)</small>
                <p>Kompleks IPSC Sentul, Kec. Citeureup, Kab. Bogor 16810</p>
            </div>
        </div>

        <div class="list-item-kontak">
            <div class="box-icon-kontak">
                <i class="bi bi-telephone"></i>
            </div>
            <div>
                <small>TELEPON</small>
                <p>(021) 345-6789</p>
            </div>
        </div>

        <div class="list-item-kontak">
            <div class="box-icon-kontak">
                <i class="bi bi-envelope"></i>
            </div>
            <div>
                <small>EMAIL</small>
                <p>pusdatin@bnpt.go.id</p>
            </div>
        </div>

            <div class="kontak-map">
                <iframe
                    src="https://www.google.com/maps?q=BNPT+Sentul+Bogor&output=embed"
                    width="100%"
                    height="220"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>


        {{-- KOLOM KANAN: FORM --}}
        <div class="kolom-form-kontak">

            <h3>Kirim Pesan</h3>

            <form action="{{ route('profil.kontak.kirim') }}" method="POST" class="stack">
    @csrf

    <div class="baris-form-dual">
        <div>
            <label>Nama Lengkap <span class="req">*</span></label>
            <input type="text"
                   name="nama"
                   placeholder="Nama Anda"
                   value="{{ old('nama') }}"
                   required>
        </div>

        <div>
            <label>Instansi</label>
            <input type="text"
                   name="instansi"
                   placeholder="Nama Instansi"
                   value="{{ old('instansi') }}">
        </div>
    </div>

    <label>Email <span class="req">*</span></label>
    <input type="email"
           name="email"
           placeholder="email@contoh.com"
           value="{{ old('email') }}"
           required>

    <label>Subjek <span class="req">*</span></label>
    <input type="text"
           name="subjek"
           placeholder="Subjek pesan"
           value="{{ old('subjek') }}"
           required>

    <label>Pesan <span class="req">*</span></label>
    <textarea name="pesan"
              rows="5"
              placeholder="Tulis pesan Anda di sini..."
              required>{{ old('pesan') }}</textarea>

    <button type="submit"
            class="btn-merah"
            style="width:100%; margin-top:18px; padding:12px;">
        Kirim Pesan
    </button>
</form>

        </div>

    </div>

</section>

@endsection
