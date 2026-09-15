@extends('layouts.portal')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')
    <p style="margin-bottom:20px; color:#666;">
        Selamat datang kembali, <b>{{ auth()->user()->nama }}</b><br>
        <small>NIP {{ auth()->user()->nip }} &middot; {{ auth()->user()->unit_kerja }} &middot; {{ now()->translatedFormat('l, d F Y') }}</small>
    </p>

    <div class="ringkasan">
        <div class="kartu"><b>{{ $tiketCount }}</b> Tiket Saya<br><small style="color:#777;">Akun</small></div>
        <div class="kartu"><b style="color:#1c4e9c;">{{ auth()->user()->tickets()->where('status', 'diproses')->count() }}</b> Diproses<br><small style="color:#777;">Sedang ditangani</small></div>
        <div class="kartu"><b style="color:#146c43;">{{ auth()->user()->tickets()->where('status', 'selesai')->count() }}</b> Selesai<br><small style="color:#777;">Tuntas</small></div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:22px;" class="dash-grid">
        <div class="panel">
            <h3>Pengumuman Terbaru</h3>
            @foreach ($pengumuman as $item)
                <div style="padding:10px 0; border-bottom:1px solid #f0f0f0;">
                    <span style="color:var(--merah);">&#8226;</span> <b>{{ $item->judul }}</b><br>
                    <small style="color:#999;">{{ $item->published_at->format('d M Y') }}</small>
                </div>
            @endforeach
        </div>
        <div class="panel">
            <h3>Tiket Layanan Saya</h3>
            @forelse ($tiketSaya as $t)
                <div style="padding:10px 0; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center; gap:8px;">
                    <div>
                        <small style="color:#999;">{{ $t->kode }}</small><br>
                        <b>{{ $t->subjek }}</b>
                    </div>
                    <div style="text-align:right;">
                        <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$t->status] }}">{{ $t->statusLabel() }}</span><br>
                        <a href="{{ route('portal.tiket.show', $t) }}" style="font-size:.8rem; color:var(--merah);">Detail</a>
                    </div>
                </div>
            @empty
                <p style="color:#888;">Belum ada tiket. <a href="{{ route('portal.tiket.create') }}" style="color:var(--merah)">Buat tiket pertama Anda</a>.</p>
            @endforelse
            <div style="margin-top:12px;"><a href="{{ route('portal.tiket.index') }}" style="color:var(--merah); font-size:.88rem;">Lihat semua tiket &rarr;</a></div>
        </div>
    </div>
    <style>@media (max-width: 900px) { .dash-grid { grid-template-columns: 1fr !important; } }</style>
@endsection
