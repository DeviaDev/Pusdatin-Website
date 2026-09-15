@extends('layouts.public')
@section('title', 'Profil Pusdatin')
@section('content')
<section class="konten">
    <h2>Profil Pusdatin BNPT</h2>
    <div class="grid-3">
        <div class="kartu"><h3>Tugas dan Fungsi</h3><p>Perumusan kebijakan teknis di bidang pusat data, teknologi informasi... <a href="{{ route('profil', 'tugas-fungsi') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
        <div class="kartu"><h3>Visi dan Misi</h3><p>Mewujudkan pusat data dan teknologi informasi yang andal dan terintegrasi... <a href="{{ route('profil', 'visi-misi') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
        <div class="kartu"><h3>Struktur Organisasi</h3><p>Susunan organisasi Pusdatin BNPT beserta tupoksi... <a href="{{ route('profil', 'struktur') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
        <div class="kartu"><h3>Kontak Kami</h3><p>Jl. H. Juanda No. 1, Jakarta Pusat 10120 — (021) 384-5555 ext. 200... <a href="{{ route('profil', 'kontak') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
    </div>
</section>
@endsection
