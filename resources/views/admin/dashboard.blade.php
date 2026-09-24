@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('page-title', 'Dashboard Administrator')

@section('content')

    <div class="ringkasan">

        <div class="kartu">
            <b>{{ $totalTiket }}</b>
            Total Tiket
            <br>
            <small>Seluruh pengaduan</small>
        </div>

        <div class="kartu">
            <b style="color:#8a6d00;">
                {{ $counts['pending'] }}
            </b>
            Pending
            <br>
            <small>Menunggu tindakan</small>
        </div>

        <div class="kartu">
            <b style="color:#1c4e9c;">
                {{ $counts['diproses'] }}
            </b>
            Diproses
            <br>
            <small>Sedang ditangani</small>
        </div>

        <div class="kartu">
            <b style="color:#5a3b9e;">
                {{ $counts['izin_eselon'] }}
            </b>
            Menunggu Izin Eselon
            <br>
            <small>Perlu persetujuan</small>
        </div>

        <div class="kartu">
            <b style="color:#146c43;">
                {{ $counts['selesai'] }}
            </b>
            Selesai
            <br>
            <small>Tuntas</small>
        </div>

        <div class="kartu">
            <b style="color:#777;">
                {{ $totalPegawai }}
            </b>
            Pegawai
            <br>
            <small>Terdaftar</small>
        </div>

        <div class="kartu">
            <b style="color:#777;">
                {{ $totalPengumuman }}
            </b>
            Pengumuman
            <br>
            <small>Terbit & draft</small>
        </div>

        <div class="kartu">
            <b style="color:#777;">
                {{ $totalSop }}
            </b>
            Dokumen SOP
            <br>
            <small>Aktif</small>
        </div>

    </div>

    <div class="panel">

        <div class="dashboard-panel-header">
            <h3>Tiket Terbaru</h3>

            <a
                href="{{ route('admin.tiket.index') }}"
                class="btn-outline"
            >
                Lihat Semua
            </a>
        </div>

        <div class="dashboard-table-wrapper">

            <table class="tabel">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($tiketTerbaru as $t)

                        <tr>

                            <td>
                                {{ $t->kode }}
                            </td>

                            <td>
                                {{ $t->user->nama }}
                            </td>

                            <td>
                                {{ $t->kategoriLabel() }}
                            </td>

                            <td>
                                {{ Str::limit($t->subjek, 40) }}
                            </td>

                            <td>
                                <span
                                    class="badge {{ App\Models\Ticket::STATUS_BADGE[$t->status] }}"
                                >
                                    {{ $t->statusLabel() }}
                                </span>
                            </td>

                            <td>
                                {{ $t->created_at->format('d/m/Y') }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('admin.tiket.show', $t) }}"
                                    style="color:var(--merah); font-size:.85rem;"
                                >
                                    Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="7"
                                style="text-align:center; color:#888;"
                            >
                                Belum ada tiket masuk.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="dash-grid">

        {{-- Kelola Konten --}}
        <a
            href="{{ route('admin.konten.index') }}"
            class="dash-grid-link"
        >

            <div class="panel dash-action-card">

                <h3>
                    &#9998; Kelola Konten Website
                </h3>

                <p>
                    Ubah teks Beranda (hero), Profil
                    (Tentang, Tugas &amp; Fungsi, Visi Misi,
                    Kontak). Perubahan langsung tampil di situs
                    publik dan portal pegawai.
                </p>

            </div>

        </a>


        {{-- Kelola SOP --}}
        <a
            href="{{ route('admin.sop.index') }}"
            class="dash-grid-link"
        >

            <div class="panel dash-action-card">

                <h3>
                    &#128737; Kelola Dokumen SOP
                </h3>

                <p>
                    Tambah, edit, atau hapus dokumen SOP Pusdatin
                    beserta file unduhannya. Tampil otomatis di
                    halaman SOP Pusdatin publik.
                </p>

            </div>

        </a>

    </div>

@endsection