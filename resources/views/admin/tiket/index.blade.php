@extends('layouts.portal')
@section('title', 'Admin — Tiket')
@section('page-title', 'Panel Admin — Layanan Pengaduan')
@section('content')
    <div class="ringkasan">
        @foreach ($counts as $key => $count)
            <a href="{{ route('admin.dashboard', ['status' => $key]) }}" style="text-decoration:none;color:inherit;">
                <div class="kartu" style="{{ $status === $key ? 'border-color:var(--merah); border-width:2px;' : '' }}">
                    <b style="color:{{ ['pending' => '#8a6d00', 'diproses' => '#1c4e9c', 'izin_eselon' => '#5a3b9e', 'ditolak' => '#9c1c28', 'selesai' => '#146c43'][$key] }};">{{ $count }}</b>
                    {{ App\Models\Ticket::STATUS[$key] }}
                </div>
            </a>
        @endforeach
    </div>

    <div class="panel">
        <h3>Semua Tiket {{ $status ? '— ' . App\Models\Ticket::STATUS[$status] : '' }}</h3>
        <table class="tabel">
            <thead><tr><th>Kode</th><th>Pelapor</th><th>Kategori</th><th>Subjek</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
            <tbody>
                @forelse ($tiket as $t)
                    <tr>
                        <td>{{ $t->kode }}</td>
                        <td>{{ $t->user->nama }}<br><small style="color:#999;">{{ $t->user->unit_kerja }}</small></td>
                        <td>{{ $t->kategoriLabel() }}</td>
                        <td>{{ Str::limit($t->subjek, 40) }}</td>
                        <td><span class="badge {{ App\Models\Ticket::STATUS_BADGE[$t->status] }}">{{ $t->statusLabel() }}</span></td>
                        <td>{{ $t->created_at->format('d/m/Y') }}</td>
                        <td><a href="{{ route('admin.tiket.show', $t) }}" style="color:var(--merah); font-size:.85rem;">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; color:#888;">Tidak ada tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $tiket->links() }}</div>
    </div>
@endsection
