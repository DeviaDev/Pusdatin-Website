@extends('layouts.public')
@section('title', 'Kontak')

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
    <div class="grid-profil-main">
        <div class="kolom-teks-profil">
            <span class="sub-judul-merah">HUBUNGI KAMI</span>
            <h2>Informasi Kontak</h2>

            <div class="list-item-kontak">
                <div class="box-icon-kontak">📍</div>
                <div>
                    <small>KANTOR PUSAT (JAKARTA)</small>
                    <p>Jl. IR. H. Juanda No. 1, Jakarta Pusat 10120, DKI Jakarta</p>
                </div>
            </div>

            <div class="list-item-kontak">
                <div class="box-icon-kontak">🏢</div>
                <div>
                    <small>KANTOR OPERASIONAL PUSDATIN (BOGOR)</small>
                    <p>Kompleks IPSC Sentul, Kec. Citeureup, Kab. Bogor 16810</p>
                </div>
            </div>

            <div class="list-item-kontak">
                <div class="box-icon-kontak">📞</div>
                <div>
                    <small>TELEPON</small>
                    <p>(021) 345-6789</p>
                </div>
            </div>

            <div class="list-item-kontak">
                <div class="box-icon-kontak">✉️</div>
                <div>
                    <small>EMAIL</small>
                    <p>pusdatin@bnpt.go.id</p>
                </div>
            </div>

            <div class="kolom-form-kontak" style="margin-top: 32px;">
                <h3>Kirim Pesan</h3>
                <form action="#" method="POST" class="stack">
                    @csrf
                    <div class="baris-form-dual">
                        <div>
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" placeholder="Nama Anda" required>
                        </div>
                        <div>
                            <label>Instansi</label>
                            <input type="text" placeholder="Nama Instansi">
                        </div>
                    </div>

                    <label>Email <span class="req">*</span></label>
                    <input type="email" placeholder="email@contoh.com" required>

                    <label>Subjek <span class="req">*</span></label>
                    <input type="text" placeholder="Subjek pesan" required>

                    <label>Pesan <span class="req">*</span></label>
                    <textarea rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>

                    <button type="submit" class="btn-merah" style="width: 100%; margin-top: 18px; padding: 12px;">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection