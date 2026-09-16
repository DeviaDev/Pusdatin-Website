@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Administrator')
@section('content')
    <div class="ringkasan">
        <div class="kartu"><b>{{ $totalTiket }}</b> Total Tiket<br><small style="color:#777;">Seluruh pengaduan</small></div>
        <div class="kartu"><b style="color:#8a6d00;">{{ $counts['pending'] }}</b> Pending<br><small style="color:#777;">Menunggu tindakan</small></div>
        <div class="kartu"><b style="color:#1c4e9c;">{{ $counts['diproses'] }}</b> Diproses<br><small style="color:#777;">Sedang ditangani</small></div>
        <div class="kartu"><b style="color:#5a3b9e;">{{ $counts['izin_eselon'] }}</b> Menunggu Izin Eselon<br><small style="color:#777;">Perlu persetujuan</small></div>
        <div class="kartu"><b style="color:#146c43;">{{ $counts['selesai'] }}</b> Selesai<br><small style="color:#777;">Tuntas</small></div>
        <div class="kartu"><b style="color:#777;">{{ $totalPegawai }}</b> Pegawai<br><small style="color:#777;">Terdaftar</small></div>
        <div class="kartu"><b style="color:#777;">{{ $totalPengumuman }}</b> Pengumuman<br><small style="color:#777;">Terbit & draft</small></div>
        <div class="kartu"><b style="color:#777;">{{ $totalSop }}</b> Dokumen SOP<br><small style="color:#777;">Aktif</small></div>
    </div>

    <div class="panel">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
            <h3 style="margin:0;">Tiket Terbaru</h3>
            <a href="{{ route('admin.tiket.index') }}" class="btn-outline" style="font-size:.85rem;">Lihat Semua</a>
        </div>
        <table class="tabel">
            <thead><tr><th>Kode</th><th>Pelapor</th><th>Kategori</th><th>Subjek</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
            <tbody>
                @forelse ($tiketTerbaru as $t)
                    <tr>
                        <td>{{ $t->kode }}</td>
                        <td>{{ $t->user->nama }}</td>
                        <td>{{ $t->kategoriLabel() }}</td>
                        <td>{{ Str::limit($t->subjek, 40) }}</td>
                        <td><span class="badge {{ App\Models\Ticket::STATUS_BADGE[$t->status] }}">{{ $t->statusLabel() }}</span></td>
                        <td>{{ $t->created_at->format('d/m/Y') }}</td>
                        <td><a href="{{ route('admin.tiket.show', $t) }}" style="color:var(--merah); font-size:.85rem;">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; color:#888;">Belum ada tiket masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:22px;" class="dash-grid">
        <a href="{{ route('admin.konten.index') }}" style="text-decoration:none;color:inherit;">
            <div class="panel" style="border-left:4px solid var(--merah); cursor:pointer;">
                <h3>&#9998; Kelola Konten Website</h3>
                <p style="font-size:.88rem; color:#777;">Ubah teks Beranda (hero), Profil (Tentang, Tugas &amp; Fungsi, Visi Misi, Kontak). Perubahan langsung tampil di situs publik dan portal pegawai.</p>
            </div>
        </a>
        <a href="{{ route('admin.sop.index') }}" style="text-decoration:none;color:inherit;">
            <div class="panel" style="border-left:4px solid var(--merah); cursor:pointer;">
                <h3>&#128737; Kelola Dokumen SOP</h3>
                <p style="font-size:.88rem; color:#777;">Tambah, edit, atau hapus dokumen SOP Pusdatin beserta file unduhannya. Tampil otomatis di halaman SOP Pusdatin publik.</p>
            </div>
        </a>
    </div>
@endsection
