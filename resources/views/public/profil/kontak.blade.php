@extends('layouts.public')
@section('title', 'Kontak')
@section('content')
<section class="konten">
    <h2>Kontak Kami</h2>
    <div class="grid-3">
        <div class="kartu"><h3>Alamat</h3><p style="line-height:1.8;">{!! nl2br(e(content('profil.kontak.alamat', 'Jl. H. Juanda No. 1, Jakarta Pusat 10120'))) !!}</p></div>
        <div class="kartu"><h3>Email & Telepon</h3><p style="line-height:1.8;">{!! nl2br(e(content('profil.kontak.email', 'pusdatin@bnpt.go.id'))) !!}<br>{!! nl2br(e(content('profil.kontak.telepon', '(021) 384-5555 ext. 200'))) !!}</p></div>
        <div class="kartu"><h3>Jam Layanan</h3><p>{!! nl2br(e(content('profil.kontak.jam', 'Senin – Jumat: 08.00 – 16.00 WIB'))) !!}</p></div>
    </div>
</section>
@endsection
