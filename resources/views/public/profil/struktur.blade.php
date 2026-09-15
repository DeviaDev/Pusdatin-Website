@extends('layouts.public')
@section('title', 'Struktur Organisasi')
@section('content')
<section class="konten">
    <h2>Struktur Organisasi</h2>
    <div class="kartu" style="max-width:900px; text-align:center;">
        <div style="display:inline-block; background:var(--merah); color:#fff; padding:10px 30px; border-radius:8px; font-weight:700;">Kepala Pusdatin</div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-top:20px;">
            <div style="border:1px solid #eee; border-radius:8px; padding:12px;">Subbagian Tata Usaha</div>
            <div style="border:1px solid #eee; border-radius:8px; padding:12px;">Kelompok Jabatan Pusat Data</div>
            <div style="border:1px solid #eee; border-radius:8px; padding:12px;">Kelompok Jabatan Teknologi Informasi</div>
            <div style="border:1px solid #eee; border-radius:8px; padding:12px;">Subbagian Teknologi Informasi</div>
        </div>
    </div>
</section>
@endsection
