@extends('layouts.portal')
@section('title', 'Tiket Saya')
@section('page-title', 'Layanan Pengaduan — Tiket Saya')
@section('content')
    <div class="panel">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 style="margin:0;">Daftar Tiket Saya</h3>
            <a href="{{ route('portal.tiket.create') }}" class="btn-merah">+ Buat Tiket</a>
        </div>
        <table class="tabel">
            <thead><tr><th>Kode</th><th>Kategori</th><th>Subjek</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
            <tbody>
                @forelse ($tiket as $t)
                    <tr>
                        <td>{{ $t->kode }}</td>
                        <td>{{ $t->kategoriLabel() }}</td>
                        <td>{{ $t->subjek }}</td>
                        <td><span class="badge {{ App\Models\Ticket::STATUS_BADGE[$t->status] }}">{{ $t->statusLabel() }}</span></td>
                        <td>{{ $t->created_at->format('d/m/Y') }}</td>
                        <td><a href="{{ route('portal.tiket.show', $t) }}" style="color:var(--merah); font-size:.85rem;">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center; color:#888;">Belum ada tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $tiket->links() }}</div>
    </div>
@endsection
