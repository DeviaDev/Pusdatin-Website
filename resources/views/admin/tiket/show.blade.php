@extends('layouts.admin')
@section('title', 'Admin — Tiket ' . $tiket->kode)
@section('page-title', 'Admin — Detail Tiket ' . $tiket->kode)

@section('content')
    <div style="display:grid; grid-template-columns: 1fr 380px; gap:22px;" class="tiket-grid">
        <div>
            <!-- Panel Utama Detail Tiket & Pelapor -->
            <div class="panel">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <small style="color:#999;">{{ $tiket->kode }} &middot; {{ $tiket->created_at->format('d/m/Y H:i') }}</small>
                        <h3 style="margin-top:4px;">{{ $tiket->subjek }}</h3>
                        <p style="font-size:.88rem; color:#666; margin-top:4px;">
                            Pelapor: <b>{{ $tiket->user->nama }}</b> (NIP {{ $tiket->user->nip }}) &middot; {{ $tiket->user->unit_kerja }}<br>
                            Kontak: {{ $tiket->user->no_hp ?? '-' }} / {{ $tiket->user->email ?? '-' }}
                        </p>
                        <span class="badge badge-diproses">{{ $tiket->kategoriLabel() }}</span>
                    </div>

                    <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$tiket->status] }}" style="font-size:.85rem;">{{ $tiket->statusLabel() }}</span>
                </div>

                <hr style="border:none; border-top:1px solid #f0f0f0; margin:16px 0;">
                <h4 style="margin-bottom:12px;">Detail Laporan</h4>

                @php
                    $detail = $tiket->detail ?? [];
                    $uploadedFiles = $detail['files_uploaded'] ?? [];
                    unset($detail['files_uploaded']); // Pisahkan berkas dari tabel teks biasa
                @endphp

                <table style="width:100%; font-size:.9rem; border-collapse:collapse;">
                    @foreach ($detail as $key => $val)
                        @continue(is_array($val) && isset($val['drive_link']))
                        <tr>
                            <td style="padding:8px 0; color:#777; width:220px; text-transform:capitalize; border-bottom:1px solid #f9f9f9;">
                                {{ str_replace('_', ' ', $key) }}
                            </td>
                            <td style="padding:8px 0; border-bottom:1px solid #f9f9f9;">
                                @if (is_array($val))
                                    {{ implode(', ', array_filter($val, fn($item) => !is_array($item))) }}
                                @else
                                    {{ $val ?: '-' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if (!empty($uploadedFiles))
                        @foreach ($uploadedFiles as $labelTitle => $fileData)
                            @php
                                $fileName = $fileData['file_name'] ?? 'Unduh File';
                                $localPath = $fileData['local_path'] ?? null;
                            @endphp
                            <tr>
                                <td style="padding:8px 0; color:#777; width:220px; border-bottom:1px solid #f9f9f9;">
                                    {{ $labelTitle }}
                                </td>
                                <td style="padding:8px 0; border-bottom:1px solid #f9f9f9;">
                                    @if (!empty($fileData['drive_link']))
                                        <a href="{{ $fileData['drive_link'] }}" target="_blank" rel="noopener noreferrer"
                                           style="display:inline-flex; align-items:center; gap:6px; color:#c8102e; font-weight:600; text-decoration:underline;">
                                            &#8681; {{ $fileName }} (Drive)
                                        </a>
                                    @elseif ($localPath)
                                        <a href="{{ route('portal.tiket.download-local', ['tiket' => $tiket->id, 'path' => $localPath]) }}" target="_blank"
                                           style="display:inline-flex; align-items:center; gap:6px; color:#1e293b; font-weight:600; text-decoration:underline;">
                                            &#8681; {{ $fileName }}
                                        </a>
                                    @else
                                        <span style="color:#999;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @elseif ($tiket->local_file_path || $tiket->drive_file_link)
                        <tr>
                            <td style="padding:8px 0; color:#777; width:220px; border-bottom:1px solid #f9f9f9;">
                                File Lampiran
                            </td>
                            <td style="padding:8px 0; border-bottom:1px solid #f9f9f9;">
                                <a href="{{ route('portal.tiket.download-local', $tiket->id) }}" target="_blank"
                                   style="display:inline-flex; align-items:center; gap:6px; color:#1e293b; font-weight:600; text-decoration:underline;">
                                    &#8681; Unduh File
                                </a>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            <!-- Panel Riwayat Status -->
            <div class="panel" style="margin-top:20px;">
                <h3>Riwayat Status</h3>
                <div class="timeline" style="margin-top:12px;">
                    @foreach ($tiket->histories as $h)
                        <div class="ti">
                            <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$h->status] }}">{{ App\Models\Ticket::STATUS[$h->status] }}</span>
                            @if ($h->catatan)<p style="font-size:.85rem; margin-top:4px;">{{ $h->catatan }}</p>@endif
                            <br><small style="color:#999;">{{ $h->created_at->format('d/m/Y H:i') }} &middot; {{ $h->changer?->nama ?? 'Sistem' }}</small>
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
                <select name="status" required style="width:100%; padding:8px; margin-bottom:12px;">
                    @foreach (App\Models\Ticket::STATUS as $key => $label)
                        <option value="{{ $key }}" {{ $tiket->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <label>Catatan (opsional)</label>
                <textarea name="catatan" rows="4" placeholder="Contoh: Menunggu izin eselon II untuk pemasangan perangkat..." style="width:100%; resize:vertical;">{{ old('catatan') }}</textarea>

                <button type="submit" class="btn-merah" style="margin-top:16px; width:100%; padding:10px;">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <style>
        @media (max-width: 900px) {
            .tiket-grid { grid-template-columns: 1fr !important; } 
        }
    </style>
@endsection