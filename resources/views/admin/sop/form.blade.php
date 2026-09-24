@extends('layouts.admin')
@section('title', $item->exists ? 'Edit SOP' : 'Tambah SOP')
@section('page-title', $item->exists ? 'Edit Dokumen SOP' : 'Tambah Dokumen SOP')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sop-admin.css') }}">
@endpush

@section('content')
    <div class="panel" style="max-width:680px;">
        <form method="POST" action="{{ $item->exists ? route('admin.sop.update', $item) : route('admin.sop.store') }}" enctype="multipart/form-data" class="stack">
            @csrf
            @if ($item->exists) @method('PUT') @endif

            <label>Kode SOP <span class="req">*</span></label>
            <input type="text" name="kode" value="{{ old('kode', $item->kode) }}" placeholder="Contoh: SOP-007" required>
            @error('kode')<div class="error-field" style="color:var(--merah); font-size:0.85rem;">{{ $message }}</div>@enderror

            <label>Nama Dokumen <span class="req">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" placeholder="Contoh: SOP Pengelolaan Media Sosial" required>
            @error('nama')<div class="error-field" style="color:var(--merah); font-size:0.85rem;">{{ $message }}</div>@enderror

            <label>Klasifikasi <span class="req">*</span></label>
            <select name="klasifikasi">
                @foreach (['Keamanan Informasi', 'Teknologi Informasi', 'Infrastruktur', 'Sumber Daya Manusia', 'Lainnya'] as $k)
                    <option value="{{ $k }}" {{ old('klasifikasi', $item->klasifikasi) === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>

            <label>Tanggal SOP <span class="req">*</span></label>
            <input type="date" name="published_at" value="{{ old('published_at', $item->published_at ? $item->published_at->format('Y-m-d') : date('Y-m-d')) }}" required>
            <small style="color:#888;">Default hari ini. Anda bisa mengubahnya ke tanggal mendatang untuk penjadwalan terbit.</small>
            @error('published_at')<div class="error-field" style="color:var(--merah); font-size:0.85rem;">{{ $message }}</div>@enderror

            <label>Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="4" placeholder="Deskripsi yang tampil di halaman publik...">{{ old('deskripsi', $item->deskripsi) }}</textarea>

            <label>File Dokumen (PDF / PNG / JPEG) <span class="req">{{ $item->exists ? '' : '*' }}</span></label>

            <input type="file" 
                name="file" 
                accept=".pdf,.png,.jpg,.jpeg,application/pdf,image/png,image/jpeg" 
                {{ $item->exists ? '' : 'required' }}>

            <small style="color:#999; display:block; margin-top:4px;">
                Format yang diterima: <b>PDF, PNG, JPEG/JPG</b>. Maksimal 10 MB. 
            </small>

            @error('file')
                <div class="error-field" style="color:var(--merah); font-size:0.85rem; margin-top:4px;">{{ $message }}</div>
            @enderror
            @error('file')<div class="error-field" style="color:var(--merah); font-size:0.85rem;">{{ $message }}</div>@enderror

            <label style="display:flex; align-items:center; gap:8px; font-weight:400; margin-top:10px; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" style="width:auto;" {{ old('is_active', $item->exists ? $item->is_active : true) ? 'checked' : '' }}> Terbitkan Dokumen ini
            </label>

            <button type="submit" class="btn-merah" style="margin-top:16px;">Simpan Dokumen</button>
        </form>
    </div>
@endsection