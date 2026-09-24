@extends('layouts.admin')
@section('title', $item->exists ? 'Edit Pengumuman' : 'Buat Pengumuman')
@section('page-title', $item->exists ? 'Edit Pengumuman' : 'Buat Pengumuman')
@section('content')
    <div class="panel" style="max-width:680px;">
        <form method="POST" action="{{ $item->exists ? route('admin.pengumuman.update', $item) : route('admin.pengumuman.store') }}" class="stack" enctype="multipart/form-data">
            @csrf
            @if ($item->exists) @method('PUT') @endif

            <label>Judul <span class="req">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $item->judul) }}" required>

            <label>Kategori <span class="req">*</span></label>
            <select name="kategori">
                @foreach (['Pengumuman', 'Informasi', 'Kebijakan'] as $k)
                    <option value="{{ $k }}" {{ old('kategori', $item->kategori) === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>

            <label>Isi <span class="req">*</span></label>
            <textarea name="isi" rows="8" required>{{ old('isi', $item->isi) }}</textarea>

            <label>Foto <span class="req">*</span></label>
            @if ($item->exists && $item->foto)
                <img src="{{ asset('storage/'.$item->foto) }}" style="max-width:200px;border-radius:8px;margin-bottom:8px;display:block;">
            @endif

            <input type="file" 
                name="foto" 
                accept="image/png, image/jpeg, image/jpg" 
                {{ $item->exists ? '' : 'required' }}>

            <small style="color:#999; display:block; margin-top:4px;">
                {{ $item->exists ? 'Kosongkan jika tidak ingin mengganti foto.' : 'Wajib diunggah.' }} Format: JPG, JPEG, PNG. Maksimal 2MB.
            </small>

            @error('foto')
                <span style="color: var(--merah); font-size: 0.85rem; display: block; margin-top: 4px;">{{ $message }}</span>
            @enderror

            <label style="display:flex; align-items:center; gap:8px; font-weight:400;">
                <input type="checkbox" name="is_published" value="1" style="width:auto;" {{ old('is_published', $item->is_published) ? 'checked' : '' }}> Terbitkan sekarang
            </label>
            <button type="submit" class="btn-merah" style="margin-top:16px;">Simpan</button>
        </form>
    </div>
@endsection
