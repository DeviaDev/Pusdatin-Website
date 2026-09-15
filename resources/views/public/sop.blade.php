@extends('layouts.public')
@section('title', 'SOP Pusdatin')
@section('content')
<section class="konten">
    <h2>Dokumen SOP Pusdatin</h2>
    <div style="display:grid; grid-template-columns: 320px 1fr; gap:24px;" class="sop-wrap">
        <div>
            @foreach ($sopList as $i => $sop)
                <div class="kartu" style="margin-bottom:10px; cursor:pointer;" onclick="document.querySelectorAll('.sop-prev').forEach(e=>e.style.display='none');document.getElementById('sop-{{ $i }}').style.display='block';">
                    <small style="color:#999;">{{ $sop['kode'] }} &middot; {{ $sop['klasifikasi'] }}</small>
                    <h3>{{ $sop['nama'] }}</h3>
                    <span style="color:var(--merah); font-size:.85rem; font-weight:600;">Unduh &#8681;</span>
                </div>
            @endforeach
        </div>
        <div class="kartu" style="min-height:420px;">
            @foreach ($sopList as $i => $sop)
                <div class="sop-prev" id="sop-{{ $i }}" style="display: {{ $i === 0 ? 'block' : 'none' }};">
                    <h3 style="text-align:center;">{{ $sop['nama'] }}</h3>
                    <p style="text-align:center;color:#999;">{{ $sop['kode'] }} &middot; Klasifikasi: {{ $sop['klasifikasi'] }}</p>
                    <p style="margin-top:24px; color:#666;">Pratinjau dokumen alur kerja SOP (flowchart dan matriks tanggung jawab) akan tampil di sini. Dokumen asli tersedia dalam format PDF untuk diunduh oleh pegawai melalui portal.</p>
                    <div style="border:1px dashed #ccc; border-radius:8px; height:260px; margin-top:16px; display:flex; align-items:center; justify-content:center; color:#bbb;">BISA SCROLL — pratinjau dokumen</div>
                </div>
            @endforeach
        </div>
    </div>
    <style>@media (max-width: 900px) { .sop-wrap { grid-template-columns: 1fr !important; } }</style>
</section>
@endsection
