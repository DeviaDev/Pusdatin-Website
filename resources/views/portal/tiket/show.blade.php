@extends('layouts.portal')
@section('title', 'Tiket ' . $tiket->kode)
@section('page-title', 'Detail Tiket ' . $tiket->kode)
@section('content')
    <div style="display:grid; grid-template-columns: 1fr 340px; gap:22px;" class="tiket-grid">
        <div>
            <div class="panel">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <small style="color:#999;">{{ $tiket->kode }} &middot; {{ $tiket->created_at->format('d/m/Y H:i') }}</small>
                        <h3 style="margin-top:4px;">{{ $tiket->subjek }}</h3>
                        <span class="badge badge-diproses">{{ $tiket->kategoriLabel() }}</span>
                    </div>
                    <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$tiket->status] }}" style="font-size:.85rem;">{{ $tiket->statusLabel() }}</span>
                </div>

                <hr style="border:none; border-top:1px solid #f0f0f0; margin:18px 0;">
                <h4 style="margin-bottom:10px;">Detail Laporan</h4>
                <table style="width:100%; font-size:.9rem;">
                    @foreach ($tiket->detail as $key => $val)
                        <tr>
                            <td style="padding:6px 0; color:#777; width:220px; text-transform:capitalize;">{{ str_replace('_', ' ', $key) }}</td>
                            <td style="padding:6px 0;">{{ $val }}</td>
                        </tr>
                    @endforeach
                </table>

                @if ($tiket->drive_file_link)
                    <p style="margin-top:14px;"><a href="{{ $tiket->drive_file_link }}" target="_blank" class="btn-outline" style="font-size:.85rem;">&#8681; Lihat Lampiran (Google Drive)</a></p>
                @elseif ($tiket->local_file_path)
                    <p style="margin-top:14px; font-size:.85rem; color:#666;">Lampiran tersimpan: {{ $tiket->local_file_path }}</p>
                @endif
            </div>

            @if ($tiket->catatan_admin)
                <div class="panel" style="border-left:4px solid var(--merah);">
                    <h3>Catatan Admin</h3>
                    <p>{{ $tiket->catatan_admin }}</p>
                </div>
            @endif
        </div>

        <div class="panel" style="align-self:start;">
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
    <style>@media (max-width: 900px) { .tiket-grid { grid-template-columns: 1fr !important; } }</style>
@endsection
