@extends('layouts.portal')
@section('title', 'Buat Tiket — Gangguan Perangkat Keras')

@section('content')
<div class="panel">
    <a href="{{ route('portal.tiket.create') }}" style="color:var(--merah); text-decoration:none; font-size:.9rem; display:inline-block; margin-bottom:16px;">← Kembali Pilih Kategori</a>

    <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px;">
        <div class="ikon-wrap" style="width:56px; height:56px; background:#fdf2f4; color:var(--merah); border-radius:16px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <div>
            <h2 style="font-size:1.4rem; font-weight:700; margin:0;">Gangguan Perangkat Keras (Hardware)</h2>
            <p style="color:#666; font-size:.9rem; margin:2px 0 0;">Meliputi aduan terkait komputer, laptop, printer, scanner, serta perangkat pendukung operasional lainnya.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('portal.tiket.store', 'hardware') }}" enctype="multipart/form-data" class="stack">
        @csrf
        <input type="hidden" name="subjek" value="Aduan Gangguan Perangkat Keras">

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

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
            <div>
                <label>Gedung <span class="req">*</span></label>
                <select name="detail[gedung]" required class="select-placeholder" onchange="this.classList.toggle('has-value', !!this.value)">
                    <option value="" disabled selected hidden>Pilih Gedung</option>
                    <option value="Gedung Utama" style="color: #333;">Biwara</option>
                    <option value="Gedung B" style="color: #333;">Baladika</option>
                    <option value="Gedung C" style="color: #333;">Pasopati</option>
                    <option value="Gedung Utama" style="color: #333;">Nenggala</option>
                    <option value="Gedung B" style="color: #333;">Rumga</option>
                    <option value="Gedung C" style="color: #333;">Lapas</option>
                    <option value="Gedung Utama" style="color: #333;">BLK</option>
                    <option value="Gedung B" style="color: #333;">Asrama Lepas</option>
                    <option value="Gedung C" style="color: #333;">Museum</option>
                    <option value="Gedung Utama" style="color: #333;">Data Center</option>
                    <option value="Gedung B" style="color: #333;">Wisman</option>
                    <option value="Gedung C" style="color: #333;">Hayam Wuruk</option>
                    <option value="Gedung B" style="color: #333;">Royal</option>
                    <option value="Gedung C" style="color: #333;">Tomang</option>
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

        <div style="border:1px solid #e5e7eb; border-radius:16px; padding:20px; margin-top:20px; background:#fafafa;">
            <div style="margin-bottom:16px;">
                <label>Subjek Pengaduan / Permohonan <span class="req">*</span></label>
                <input type="text" name="subjek" value="{{ old('subjek') }}" placeholder="Tuliskan Subjek Pengaduan / Permohonan" required style="width:100%; box-sizing:border-box;">
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                <div>
                    <label>Nama Pemilik Perangkat Keras <span class="req">*</span></label>
                    <input type="text" name="detail[nama_pemilik]" value="{{ old('detail.nama_pemilik') }}" placeholder="Tuliskan Nama Lengkap" required>
                </div>
                <div>
                    <label>Jabatan Pemilik Perangkat Keras <span class="req">*</span></label>
                    <input type="text" name="detail[jabatan_pemilik]" value="{{ old('detail.jabatan_pemilik') }}" placeholder="Jabatan Pemilik Perangkat Keras" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-top:16px; align-items:start;">
                <div>
                    <label>Jenis Perangkat Keras <span class="req">*</span></label>
                    <div style="display:flex; flex-direction:column; gap:2px; margin-top:4px;">
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-size:.9rem; margin:0; padding:2px 0;">
                            <input type="radio" name="detail[jenis_perangkat]" value="Komputer / Laptop" style="width:auto; margin:0;" required>
                            Komputer / Laptop
                        </label>
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-size:.9rem; margin:0; padding:2px 0;">
                            <input type="radio" name="detail[jenis_perangkat]" value="Scanner" style="width:auto; margin:0;">
                            Scanner
                        </label>
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-size:.9rem; margin:0; padding:2px 0;">
                            <input type="radio" name="detail[jenis_perangkat]" value="Printer" style="width:auto; margin:0;">
                            Printer
                        </label>
                        <div style="display:inline-flex; align-items:center; gap:8px; margin-top:2px;">
                            <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:8px; white-space:nowrap; cursor:pointer; font-size:.9rem; margin:0;">
                                <input type="radio" name="detail[jenis_perangkat]" value="Lainnya" style="width:auto; margin:0;">
                                Lainnya
                            </label>
                            <input type="text" name="detail[jenis_perangkat_lain]" placeholder="Sebutkan..." style="padding:4px 8px; font-size:.85rem; width:100%; height:32px; margin:0;">
                        </div>
                    </div>
                </div>

                <div>
                    <label>Deskripsi Gangguan Perangkat Keras <span class="req">*</span></label>
                    <textarea name="detail[deskripsi]" rows="4" placeholder="Jelaskan Gangguan yang terjadi" required style="width:100%; height:120px; resize:none; margin-top:4px;">{{ old('detail.deskripsi') }}</textarea>
                </div>
            </div>

            <div style="margin-top:16px;">
                <label>Upload Screenshot / Foto <span class="req">*</span></label>
                <div style="display:flex; align-items:center; gap:12px; margin-top:6px;">
                    <input type="file" name="lampiran" accept=".pdf,.png" style="width:auto; padding:6px; background:#fff; border:1px solid #ccc; border-radius:6px;" required>
                    <small style="color:#888;">Maksimal 5 MB (Hanya PDF, PNG)</small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-merah" style="margin-top:24px; padding:12px 32px; font-size:1rem;">Kirim Tiket Aduan</button>
    </form>
</div>
@endsection