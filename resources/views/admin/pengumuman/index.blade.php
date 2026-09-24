@extends('layouts.admin')
@section('title', 'Admin — Pengumuman')
@section('page-title', 'Kelola Pengumuman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-informasi.css') }}">
@endpush

@section('content')
    <div class="panel">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 style="margin:0; font-weight:700; color:var(--hitam);">Pengumuman</h3>
            <a href="{{ route('admin.pengumuman.create') }}" class="btn-merah">+ Buat Pengumuman</a>
        </div>

        <!-- Tabel Pengumuman -->
        <div class="table-responsive">
            <table class="tabel">
                <thead>
                    <tr>
                        <th style="width: 40%;">Judul</th>
                        <th style="width: 15%;">Kategori</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 13%;">Tanggal</th>
                        <th style="width: 20%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengumuman as $p)
                        <tr>
                            <td style="font-weight: 600; color: #222;">{{ $p->judul }}</td>
                            <td>{{ $p->kategori }}</td>
                            <td>
                                <span class="badge {{ $p->is_published ? 'badge-selesai' : 'badge-pending' }}">
                                    {{ $p->is_published ? 'Terbit' : 'Draft' }}
                                </span>
                            </td>
                            <td>{{ $p->published_at?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <div class="aksi-tabel">
                                    <!-- Tombol Detail -->
                                    <a href="{{ route('admin.pengumuman.show', $p) }}" 
                                       class="btn-aksi btn-detail" 
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.pengumuman.edit', $p) }}" 
                                       class="btn-aksi btn-edit" 
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form method="POST" 
                                          action="{{ route('admin.pengumuman.destroy', $p) }}" 
                                          style="display:inline;" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" 
                                                class="btn-aksi btn-hapus" 
                                                title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 24px;">
                                Belum ada data pengumuman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top:20px;">
            {{ $pengumuman->links() }}
        </div>
    </div>
@endsection