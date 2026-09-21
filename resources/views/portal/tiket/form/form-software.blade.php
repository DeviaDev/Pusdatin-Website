@extends('layouts.portal')
@section('title', 'Buat Tiket — Gangguan Perangkat Lunak')

@section('content')
<div class="panel">
    <a href="{{ route('portal.tiket.create') }}" style="color:var(--merah); text-decoration:none; font-size:.9rem; display:inline-block; margin-bottom:16px;">← Kembali Pilih Kategori</a>

    <!-- Header Form dengan Ikon Software -->
    <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px;">
        <div class="ikon-wrap" style="width:56px; height:56px; background:#fdf2f4; color:var(--merah); border-radius:16px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
        </div>
        <div>
            <h2 style="font-size:1.4rem; font-weight:700; margin:0;">Gangguan Perangkat Lunak (Software)</h2>
            <p style="color:#666; font-size:.9rem; margin:2px 0 0;">Meliputi aduan terkait sistem operasi, aplikasi operasional, serta aplikasi-aplikasi pendukung lainnya.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('portal.tiket.store', 'software') }}" enctype="multipart/form-data" class="stack">
        @csrf
        <input type="hidden" name="subjek" value="Aduan Gangguan Perangkat Lunak">

        <!-- Baris 1: Informasi Pelapor -->
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
            <div>
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="detail[nama_pelapor]" value="{{ old('detail.nama_pelapor', auth()->user()->nama) }}" placeholder="Tuliskan Nama Lengkap" required>
            </div>
            <div>
                <label>Unit Kerja <span class="req">*</span></label>
                <input type="text" name="detail[unit_kerja]" value="{{ old('detail.unit_kerja') }}" placeholder="Tuliskan Unit Kerja" required>
            </div>
            <div>
                <label>Jabatan <span class="req">*</span></label>
                <input type="text" name="detail[jabatan]" value="{{ old('detail.jabatan') }}" placeholder="Tuliskan Jabatan" required>
            </div>
        </div>

        <!-- Baris 2: Lokasi & Kontak -->
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
            <div>
                <label>Gedung <span class="req">*</span></label>
                <select name="detail[gedung]" required>
                    <option value="">Pilih Gedung</option>
                    <option value="Gedung Utama">Gedung Utama</option>
                    <option value="Gedung B">Gedung B</option>
                    <option value="Gedung C">Gedung C</option>
                </select>
            </div>
            <div>
                <label>Lantai / Ruangan <span class="req">*</span></label>
                <input type="text" name="detail[ruangan]" value="{{ old('detail.ruangan') }}" placeholder="Tuliskan Lantai / Ruangan" required>
            </div>
            <div>
                <label>No Handphone (WhatsApp aktif) <span class="req">*</span></label>
                <input type="text" name="detail[no_hp]" value="{{ old('detail.no_hp') }}" placeholder="Tuliskan Handphone" required>
            </div>
        </div>

        <!-- Baris 3: BMN & Nodin -->
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
            <div>
                <label>Nomor BMN <span class="req">*</span></label>
                <input type="text" name="detail[no_bmn]" value="{{ old('detail.no_bmn') }}" placeholder="Tuliskan Nomor BMN" required>
            </div>
            <div>
                <label>File Nodin (PDF / PNG Only) <span class="req">*</span></label>
                <input type="file" name="lampiran_nodin" accept=".pdf,.png" style="width:auto; padding:6px;" required>
            </div>
        </div>

        <!-- Kartu Khusus Detail Software -->
        <div style="border:1px solid #e5e7eb; border-radius:16px; padding:20px; margin-top:20px; background:#fafafa;">
            <!-- Baris 1: Nama & Jabatan Pemilik Perangkat Lunak -->
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div>
                    <label>Nama Pemilik Perangkat Lunak <span class="req">*</span></label>
                    <input type="text" name="detail[nama_pemilik]" value="{{ old('detail.nama_pemilik') }}" placeholder="Tuliskan Nama Lengkap" required>
                </div>
                <div>
                    <label>Jabatan Pemilik Perangkat Lunak <span class="req">*</span></label>
                    <input type="text" name="detail[jabatan_pemilik]" value="{{ old('detail.jabatan_pemilik') }}" placeholder="Jabatan Pemilik Perangkat Lunak" required>
                </div>
            </div>

            <!-- Baris 2: Deskripsi Gangguan Perangkat Lunak (Memanjang) -->
            <div style="margin-top:16px;">
                <label>Deskripsi Gangguan Perangkat Lunak <span class="req">*</span></label>
                <textarea name="detail[deskripsi]" rows="4" placeholder="Jelaskan Gangguan yang terjadi" required style="width:100%; height:100px; resize:vertical; margin-top:4px;">{{ old('detail.deskripsi') }}</textarea>
            </div>

            <!-- Baris 3: Upload Screenshot / Foto -->
            <div >
                <label>Upload Screenshot / Foto (Opsional)</label>
                <div style="display:flex; align-items:center; gap:12px; margin-top:6px;">
                    <input type="file" name="lampiran" accept=".pdf,.png" style="width:auto; padding:6px; background:#fff; border:1px solid #ccc; border-radius:6px;">
                    <small style="color:#888;">Maksimal 5 MB (Hanya PDF, PNG)</small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-merah" style="margin-top:24px; padding:12px 32px; font-size:1rem;">Kirim Tiket Aduan</button>
    </form>
</div>
@endsection