@extends('layouts.admin')
@section('title', 'Dokumen SOP')
@section('page-title', 'Kelola Dokumen SOP')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sop-admin.css') }}">
@endpush

@section('content')
    <div class="panel">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 style="margin:0; font-weight:700;">Daftar Dokumen SOP</h3>
            <a href="{{ route('admin.sop.create') }}" class="btn-merah">+ Tambah SOP</a>
        </div>
        
        <div class="table-responsive">
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 15%;">Kode</th>
                        <th style="width: 25%;">Nama Dokumen</th>
                        <th style="width: 18%;">Klasifikasi</th>
                        <th style="width: 14%;">Tanggal</th>
                        <th style="width: 13%;">Status</th>
                        <th style="width: 15%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sop as $s)
                        <tr>
                            <td style="font-weight:600; color:#222;">{{ $s->kode }}</td>
                            <td>
                                {{ $s->nama }}
                                @if ($s->file_path)
                                    <br>
                                    <a href="{{ route('admin.sop.unduh', $s) }}" class="sop-file-link">
                                        &#8681; {{ Str::limit($s->file_name, 22) }}
                                    </a>
                                @endif
                            </td>
                            <td>{{ $s->klasifikasi }}</td>
                            <td>{{ $s->published_at ? $s->published_at->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if (!$s->is_active)
                                    <span class="badge badge-pending">Draft</span>
                                @elseif ($s->published_at && $s->published_at->isFuture())
                                    <span class="badge badge-diproses">Terjadwal</span>
                                @else
                                    <span class="badge badge-selesai">Terbit</span>
                                @endif
                            </td>
                            <td>
                                <div class="aksi-tabel">
                                    <a href="{{ route('admin.sop.edit', $s) }}" class="btn-aksi btn-edit" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.sop.destroy', $s) }}" style="display:inline;" onsubmit="return confirm('Hapus dokumen SOP ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-aksi btn-hapus" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#888; padding:24px;">
                                Belum ada dokumen SOP. <a href="{{ route('admin.sop.create') }}" style="color:var(--merah)">Tambah sekarang</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top:16px;">
            {{ $sop->links() }}
        </div>
    </div>
@endsection