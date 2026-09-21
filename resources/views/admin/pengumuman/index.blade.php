@extends('layouts.admin')
@section('title', 'Admin — Pengumuman')
@section('page-title', 'Kelola Pengumuman')
@section('content')
    <div class="panel">
        <div style="display:flex; justify-content:space-between; margin-bottom:14px;">
            <h3 style="margin:0;">Pengumuman</h3>
            <a href="{{ route('admin.pengumuman.create') }}" class="btn-merah">+ Buat Pengumuman</a>
        </div>
        <table class="tabel">
            <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
            <tbody>
                @foreach ($pengumuman as $p)
                    <tr>
                        <td>{{ $p->judul }}</td>
                        <td>{{ $p->kategori }}</td>
                        <td><span class="badge {{ $p->is_published ? 'badge-selesai' : 'badge-pending' }}">{{ $p->is_published ? 'Terbit' : 'Draft' }}</span></td>
                        <td>{{ $p->published_at?->format('d/m/Y') ?? '-' }}</td>
                        <td>
    <div class="aksi-tabel">

        <a href="{{ route('admin.pengumuman.edit', $p) }}"
           class="btn-aksi btn-edit"
           title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>

        <form method="POST"
              action="{{ route('admin.pengumuman.destroy', $p) }}"
              style="display:inline;"
              onsubmit="return confirm('Hapus pengumuman ini?')">
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
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $pengumuman->links() }}</div>
    </div>
@endsection
