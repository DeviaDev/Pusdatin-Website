@extends('layouts.portal')
@section('title', 'Admin — Tiket ' . $tiket->kode)
@section('page-title', 'Admin — Detail Tiket ' . $tiket->kode)
@section('content')
    <div style="display:grid; grid-template-columns: 1fr 380px; gap:22px;" class="tiket-grid">
        <div>
            <div class="panel">
                <small style="color:#999;">{{ $tiket->kode }} &middot; {{ $tiket->created_at->format('d/m/Y H:i') }}</small>
                <h3 style="margin-top:4px;">{{ $tiket->subjek }}</h3>
                <p style="font-size:.88rem; color:#666;">
                    Pelapor: <b>{{ $tiket->user->nama }}</b> (NIP {{ $tiket->user->nip }}) &middot; {{ $tiket->user->unit_kerja }}<br>
                    Kontak: {{ $tiket->user->no_hp ?? '-' }} / {{ $tiket->user->email ?? '-' }}
                </p>
                <span class="badge badge-diproses">{{ $tiket->kategoriLabel() }}</span>

                <hr style="border:none; border-top:1px solid #f0f0f0; margin:16px 0;">
                <table style="width:100%; font-size:.9rem;">
                    @foreach ($tiket->detail as $key => $val)
                        <tr>
                            <td style="padding:6px 0; color:#777; width:220px; text-transform:capitalize;">{{ str_replace('_', ' ', $key) }}</td>
                            <td style="padding:6px 0;">{{ $val }}</td>
                        </tr>
                    @endforeach
                </table>

                @if ($tiket->drive_file_link)
                    <p style="margin-top:14px;"><a href="{{ $tiket->drive_file_link }}" target="_blank" class="btn-outline" style="font-size:.85rem;">&#8681; Buka Lampiran di Drive</a></p>
                @endif
            </div>

            <div class="panel">
                <h3>Riwayat Status</h3>
                <div class="timeline">
                    @foreach ($tiket->histories as $h)
                        <div class="ti">
                            <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$h->status] }}">{{ App\Models\Ticket::STATUS[$h->status] }}</span>
                            @if ($h->catatan)<p style="font-size:.85rem; margin-top:4px;">{{ $h->catatan }}</p>@endif
                            <br><small>{{ $h->created_at->format('d/m/Y H:i') }} &middot; {{ $h->changer?->nama ?? 'Sistem' }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="panel" style="align-self:start;">
            <h3>Ubah Status</h3>
            <p style="font-size:.85rem; color:#888; margin-bottom:12px;">Perubahan status tersinkron ke Google Sheets dan pemilik tiket menerima notifikasi.</p>
            <form method="POST" action="{{ route('admin.tiket.status', $tiket) }}" class="stack">
                @csrf
                <label>Status Baru <span class="req">*</span></label>
                <select name="status" required>
                    @foreach (App\Models\Ticket::STATUS as $key => $label)
                        <option value="{{ $key }}" {{ $tiket->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <label>Catatan (opsional)</label>
                <textarea name="catatan" rows="4" placeholder="Contoh: Menunggu izin eselon II untuk pemasangan perangkat...">{{ old('catatan') }}</textarea>
                <button type="submit" class="btn-merah" style="margin-top:16px; width:100%;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <style>@media (max-width: 900px) { .tiket-grid { grid-template-columns: 1fr !important; } }</style>
@endsection
