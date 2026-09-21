@extends('layouts.admin')
@section('title', 'Dokumen SOP')
@section('page-title', 'Kelola Dokumen SOP')
@section('content')
    <div class="panel">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 style="margin:0;">Daftar Dokumen SOP</h3>
            <a href="{{ route('admin.sop.create') }}" class="btn-merah">+ Tambah SOP</a>
        </div>
        <table class="tabel">
            <thead><tr><th>Kode</th><th>Nama Dokumen</th><th>Klasifikasi</th><th>File</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse ($sop as $s)
                    <tr>
                        <td>{{ $s->kode }}</td>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->klasifikasi }}</td>
                        <td>
                            @if ($s->file_path)
                                <a href="{{ route('admin.sop.unduh', $s) }}" style="color:var(--merah); font-size:.85rem;">&#8681; {{ Str::limit($s->file_name, 20) }}</a>
                            @else
                                <span style="color:#999; font-size:.85rem;">—</span>
                            @endif
                        </td>
                        <td><span class="badge {{ $s->is_active ? 'badge-selesai' : 'badge-pending' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
    <div class="aksi-tabel">

        <a href="{{ route('admin.sop.edit', $s) }}"
           class="btn-aksi btn-edit"
           title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>

        <form method="POST"
              action="{{ route('admin.sop.destroy', $s) }}"
              style="display:inline;"
              onsubmit="return confirm('Hapus dokumen SOP ini?')">

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
                    <tr><td colspan="6" style="text-align:center; color:#888;">Belum ada dokumen SOP. <a href="{{ route('admin.sop.create') }}" style="color:var(--merah)">Tambah sekarang</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:16px;">{{ $sop->links() }}</div>
    </div>
@endsection
