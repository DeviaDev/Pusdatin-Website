@extends('layouts.admin')
@section('title', $item->exists ? 'Edit SOP' : 'Tambah SOP')
@section('page-title', $item->exists ? 'Edit Dokumen SOP' : 'Tambah Dokumen SOP')
@section('content')
    <div class="panel" style="max-width:680px;">
        <form method="POST" action="{{ $item->exists ? route('admin.sop.update', $item) : route('admin.sop.store') }}" enctype="multipart/form-data" class="stack">
            @csrf
            @if ($item->exists) @method('PUT') @endif

            <label>Kode SOP <span class="req">*</span></label>
            <input type="text" name="kode" value="{{ old('kode', $item->kode) }}" placeholder="Contoh: SOP-007" required>
            @error('kode')<div class="error-field">{{ $message }}</div>@enderror

            <label>Nama Dokumen <span class="req">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" placeholder="Contoh: SOP Pengelolaan Media Sosial" required>
            @error('nama')<div class="error-field">{{ $message }}</div>@enderror

            <label>Klasifikasi <span class="req">*</span></label>
            <select name="klasifikasi">
                @foreach (['Keamanan Informasi', 'Teknologi Informasi', 'Infrastruktur', 'Sumber Daya Manusia', 'Lainnya'] as $k)
                    <option value="{{ $k }}" {{ old('klasifikasi', $item->klasifikasi) === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>

            <label>Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="4" placeholder="Deskripsi yang tampil di halaman publik...">{{ old('deskripsi', $item->deskripsi) }}</textarea>

            <label>File Dokumen (PDF / Office / Gambar)</label>
            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg">
            <small style="color:#999;">Maksimal 10 MB. @if ($item->file_name) File saat ini: <b>{{ $item->file_name }}</b>@endif</small>
            @error('file')<div class="error-field">{{ $message }}</div>@enderror

            <label style="display:flex; align-items:center; gap:8px; font-weight:400;">
                <input type="checkbox" name="is_active" value="1" style="width:auto;" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}> Tampilkan di situs publik
            </label>

            <button type="submit" class="btn-merah" style="margin-top:16px;">Simpan</button>
        </form>
    </div>
@endsection
