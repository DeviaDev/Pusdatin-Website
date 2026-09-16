@extends('layouts.public')
@section('title', 'Profil Pusdatin')
@section('content')
<section class="konten">
    <h2>Profil Pusdatin BNPT</h2>
    <div class="kartu" style="max-width:800px; margin-bottom:22px;">
        <h3>Tentang Pusdatin</h3>
        <p style="line-height:1.8;">{!! nl2br(e(content('profil.tentang', 'Pusat Data dan Teknologi Informasi (Pusdatin) BNPT adalah unit kerja yang bertanggung jawab atas pengelolaan pusat data dan infrastruktur teknologi informasi pada Badan Nasional Penanggulangan Terorisme Republik Indonesia.'))) !!}</p>
    </div>
    <div class="grid-3">
        <div class="kartu"><h3>Tugas dan Fungsi</h3><p>Perumusan kebijakan teknis di bidang pusat data, teknologi informasi... <a href="{{ route('profil', 'tugas-fungsi') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
        <div class="kartu"><h3>Visi dan Misi</h3><p>Mewujudkan pusat data dan teknologi informasi yang andal dan terintegrasi... <a href="{{ route('profil', 'visi-misi') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
        <div class="kartu"><h3>Struktur Organisasi</h3><p>Susunan organisasi Pusdatin BNPT beserta tupoksi... <a href="{{ route('profil', 'struktur') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
        <div class="kartu"><h3>Kontak Kami</h3><p>{!! nl2br(e(content('profil.kontak.alamat', 'Jl. H. Juanda No. 1, Jakarta Pusat 10120'))) !!}... <a href="{{ route('profil', 'kontak') }}" style="color:var(--merah)">Selengkapnya</a></p></div>
    </div>
</section>
@endsection
