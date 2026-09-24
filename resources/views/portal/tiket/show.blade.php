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

                    <div style="display:flex; align-items:center; gap:10px;">
                        <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$tiket->status] }}" style="font-size:.85rem;">{{ $tiket->statusLabel() }}</span>

                        @if ($tiket->status === 'pending' || auth()->user()->isAdmin())
                            <form action="{{ route('portal.tiket.destroy', $tiket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5; padding:6px 12px; border-radius:6px; font-size:.8rem; font-weight:600; cursor:pointer;">
                                    🗑 Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #f0f0f0; margin:18px 0;">
                <h4 style="margin-bottom:12px;">Detail Laporan</h4>
                
                @php
                    $detail = $tiket->detail ?? [];
                    $uploadedFiles = $detail['files_uploaded'] ?? [];
                    unset($detail['files_uploaded']);
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
                                            &#8681; {{ $fileName }}
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

            @if ($tiket->catatan_admin)
                <div class="panel" style="border-left:4px solid var(--merah);">
                    <h3 style="font-size:1rem; margin-bottom:6px;">Catatan Admin</h3>
                    <p style="font-size:.9rem; color:#444; margin:0;">{{ $tiket->catatan_admin }}</p>
                </div>
            @endif
        </div>

        <div class="panel" style="align-self:start;">
            <h3 style="font-size:1rem; margin-bottom:14px;">Riwayat Status</h3>
            <div class="timeline">
                @foreach ($tiket->histories as $h)
                    <div class="ti">
                        <span class="badge {{ App\Models\Ticket::STATUS_BADGE[$h->status] }}">{{ App\Models\Ticket::STATUS[$h->status] }}</span>
                        @if ($h->catatan)
                            <p style="font-size:.85rem; margin-top:4px; color:#555;">{{ $h->catatan }}</p>
                        @endif
                        <br><small style="color:#999;">{{ $h->created_at->format('d/m/Y H:i') }} &middot; {{ $h->changer?->nama ?? 'Sistem' }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 900px) { 
            .tiket-grid { grid-template-columns: 1fr !important; } 
        }
    </style>
@endsection