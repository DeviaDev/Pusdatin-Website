@extends('layouts.portal')
@section('title', 'Buat Tiket — Layanan Hak Akses')

@section('content')
<div class="panel">
    <a href="{{ route('portal.tiket.create') }}" style="color:var(--merah); text-decoration:none; font-size:.9rem; display:inline-block; margin-bottom:16px;">← Kembali Pilih Kategori</a>

    <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px;">
        <div class="ikon-wrap" style="width:56px; height:56px; background:#fdf2f4; color:var(--merah); border-radius:16px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div>
            <h2 style="font-size:1.4rem; font-weight:700; margin:0;">Layanan Hak Akses</h2>
            <p style="color:#666; font-size:.9rem; margin:2px 0 0;">Meliputi aduan dan permintaan terkait Hak Akses Non Fisik (network, database, VPN dan aplikasi, serta Hak Akses Fisik (akses kantor dan ruang pusat data).</p>
        </div>
    </div>

    <form method="POST" action="{{ route('portal.tiket.store', 'hak_akses') }}" enctype="multipart/form-data" class="stack">
        @csrf
        <input type="hidden" name="subjek" value="Permohonan Layanan Hak Akses">
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
                <select name="detail[gedung]" required class="select-placeholder" onchange="this.classList.toggle('has-value', !!this.value)">v
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
        </div>

        <div style="border:1px solid #e5e7eb; border-radius:16px; padding:20px; margin-top:20px; background:#fafafa;">
            <div style="margin-bottom:16px;">
                <label>Subjek Pengaduan / Permohonan <span class="req">*</span></label>
                <input type="text" name="subjek" value="{{ old('subjek') }}" placeholder="Tuliskan Subjek Pengaduan / Permohonan" required style="width:100%; box-sizing:border-box;">
            </div>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:14px 24px; align-items:start;">
                <div>
                    <label style="margin:0 0 2px;">Kategori Akses <span class="req">*</span></label>
                    <small style="display:block; color:#666; margin-bottom:4px;">info lengkap : <a href="https://drive.google.com/file/d/1E4ijEDI25E-oW2KT6PDUoEHr5Q1HtYqG/view" target="_blank" rel="noopener noreferrer" style="color:var(--merah); text-decoration:underline; font-weight:600;">SOP HAK AKSES</a></small>
                    <div style="display:flex; gap:20px; height:40px; align-items:center;">
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[kategori_akses]" value="Normal" style="width:auto; margin:0;" required> Normal
                        </label>
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[kategori_akses]" value="Privilege" style="width:auto; margin:0;"> Privilege
                        </label>
                    </div>
                </div>

                <div>
                    <label style="margin:0 0 2px;">Waktu Akses <span class="req">*</span></label>
                    <small style="display:block; color:#666; margin-bottom:4px;">Untuk waktu tertentu tuliskan di kolom lainnya</small>
                    <div style="display:flex; gap:16px; align-items:center; height:40px;">
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[waktu_akses]" value="7 x 24 jam" style="width:auto; margin:0;" required> 7 × 24 jam
                        </label>
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[waktu_akses]" value="Waktu Kerja" style="width:auto; margin:0;"> Waktu Kerja
                        </label>
                        <div style="display:inline-flex; align-items:center; gap:8px; flex:1;">
                            <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; cursor:pointer; font-size:.9rem;">
                                <input type="radio" name="detail[waktu_akses]" value="Lainnya" style="width:auto; margin:0;"> Lainnya
                            </label>
                            <input type="text" name="detail[waktu_akses_lain]" placeholder="Sebutkan..." style="padding:8px 12px; font-size:.85rem; width:100%; height:40px; margin:0; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                <div>
                    <label style="margin:0 0 4px;">Kategori Pemohon <span class="req">*</span></label>
                    <div style="display:flex; gap:20px; height:40px; align-items:center;">
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[kategori_pemohon]" value="Pegawai BNPT" style="width:auto; margin:0;" required> Pegawai BNPT
                        </label>
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[kategori_pemohon]" value="Pihak Ketiga" style="width:auto; margin:0;"> Pihak Ketiga
                        </label>
                    </div>
                </div>

                <div>
                    <label style="margin:0 0 4px;">Durasi Akses <span class="req">*</span></label>
                    <div style="display:flex; gap:16px; align-items:center; height:40px;">
                        <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:.9rem;">
                            <input type="radio" name="detail[durasi_akses]" value="Permanen" style="width:auto; margin:0;" required> Permanen
                        </label>
                        <div style="display:inline-flex; align-items:center; gap:8px; flex:1;">
                            <label class="opt-radio" style="font-weight:normal; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; cursor:pointer; font-size:.9rem;">
                                <input type="radio" name="detail[durasi_akses]" value="Lainnya" style="width:auto; margin:0;"> Lainnya
                            </label>
                            <input type="text" name="detail[durasi_akses_lain]" placeholder="Sebutkan durasi..." style="padding:8px 12px; font-size:.85rem; width:100%; height:40px; margin:0; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                <div style="grid-column: span 2;">
                    <label style="margin:0 0 2px;">Tipe Akses <span class="req">*</span></label>
                    <small style="display:block; color:#666; margin-bottom:4px;">Untuk Akses Aplikasi tuliskan spesifik Nama Aplikasi di kolom lainnya</small>
                    
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; align-items:start;">
                        <div>
                            <select name="detail[tipe_akses]" id="tipe_akses_select" required class="select-placeholder" onchange="this.classList.toggle('has-value', !!this.value)" style="width:100%; height:40px; box-sizing:border-box;">
                                <option value="" disabled selected hidden>Pilih Tipe Akses</option>
                                <option value="Network">Network</option>
                                <option value="Database">Database</option>
                                <option value="Internet">Internet</option>
                                <option value="VPN">VPN</option>
                                <option value="Kantor">Kantor</option>
                                <option value="Pusat Data">Pusat Data</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div id="tipe_akses_keterangan_wrapper" style="display:none;">
                            <input type="text" name="detail[tipe_akses_keterangan]" id="tipe_akses_keterangan" placeholder="Isi keterangan jika memilih lainnya" style="padding:8px 12px; font-size:.85rem; width:100%; height:40px; margin:0; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                <div style="display:flex; flex-direction:column; justify-content:space-between; height:100%;">
                    <div>
                        <label style="margin:0 0 2px;">Form Permohonan Akses <span class="req">*</span></label>
                        <small style="display:block; color:#666; margin-bottom:6px; line-height:1.4;">
                            Nama File: FPA-Nama Pemohon-Tipe Akses<br>
                            Format Permohonan Akses : <a href="https://tinyurl.com/FormMohonAkses" target="_blank" rel="noopener noreferrer" style="color:var(--merah); text-decoration:underline; font-weight:600;">Form Permohonan Akses</a>
                        </small>
                    </div>
                    <input type="file" name="lampiran_fpa" accept=".pdf,.png" style="width:100%; padding:6px; background:#fff; border:1px solid #ccc; border-radius:6px; font-size:.85rem; box-sizing:border-box;" required>
                </div>

                <div style="display:flex; flex-direction:column; justify-content:space-between; height:100%;">
                    <div>
                        <label style="margin:0 0 2px;">Surat Pernyataan Menjaga Kerahasian <span class="req">*</span></label>
                        <small style="display:block; color:#666; margin-bottom:6px; line-height:1.4;">
                            Nama File: SPMK-Nama Pemohon<br>
                            Format Untuk Pegawai BNPT : <a href="https://drive.google.com/file/d/1hGSj2dznwl380VhKxnLTNKQdvX7IIS4a/view" target="_blank" rel="noopener noreferrer" style="color:var(--merah); text-decoration:underline; font-weight:600;">Surat Pernyataan Internal</a><br>
                            Format Untuk Pihak Eksternal : <a href="https://drive.google.com/file/d/187LupNB3Z-ZFJtBz1QBYQfve6cyR4Jzf/view" target="_blank" rel="noopener noreferrer" style="color:var(--merah); text-decoration:underline; font-weight:600;">Surat Pernyataan Eksternal</a>
                        </small>
                    </div>
                    <input type="file" name="lampiran_spmk" accept=".pdf,.png" style="width:100%; padding:6px; background:#fff; border:1px solid #ccc; border-radius:6px; font-size:.85rem; box-sizing:border-box;" required>
                </div>
            </div>
        </div>

        <style>
            form.stack label.opt-radio {
                margin: 0 !important;
                display: inline-flex !important;
            }
        </style>

        <button type="submit" class="btn-merah" style="margin-top:20px; padding:12px 32px; font-size:1rem;">Kirim Tiket Permohonan</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectTipeAkses = document.getElementById('tipe_akses_select');
        const wrapperKeterangan = document.getElementById('tipe_akses_keterangan_wrapper');
        const inputKeterangan = document.getElementById('tipe_akses_keterangan');

        function toggleTipeAksesLainnya() {
            if (selectTipeAkses.value === 'Lainnya') {
                wrapperKeterangan.style.display = 'block';
                inputKeterangan.setAttribute('required', 'required');
            } else {
                wrapperKeterangan.style.display = 'none';
                inputKeterangan.removeAttribute('required');
                inputKeterangan.value = '';
            }
        }

        selectTipeAkses.addEventListener('change', toggleTipeAksesLainnya);
        toggleTipeAksesLainnya();
    });
</script>
@endsection