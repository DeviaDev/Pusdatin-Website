@extends('layouts.portal')
@section('title', 'Buat Tiket — ' . $kategoriLabel)
@section('page-title', 'Buat Tiket')
@section('content')
    <div class="panel" style="max-width:720px;">
        <h3>{{ $kategoriLabel }}</h3>
        <p style="color:#888; font-size:.85rem;">Isi formulir di bawah ini. Field bertanda <span style="color:var(--merah)">*</span> wajib diisi.</p>

        <form method="POST" action="{{ route('portal.tiket.store', $kategori) }}" enctype="multipart/form-data" class="stack">
            @csrf
            <label>Subjek / Ringkasan Masalah <span class="req">*</span></label>
            <input type="text" name="subjek" value="{{ old('subjek') }}" placeholder="Contoh: Printer tidak bisa scan dokumen" required>
            @error('subjek')<div class="error-field">{{ $message }}</div>@enderror

            @foreach ($fields as $name => $f)
                <label>{{ $f['label'] }} <span class="req">{{ $f['required'] ? '*' : '' }}</span></label>
                @if ($f['type'] === 'select')
                    <select name="detail[{{ $name }}]">
                        <option value="">-- Pilih {{ $f['label'] }} --</option>
                        @foreach ($f['options'] as $opt)
                            <option value="{{ $opt }}" {{ old('detail.' . $name) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                @elseif ($f['type'] === 'textarea')
                    <textarea name="detail[{{ $name }}]" rows="4" placeholder="Jelaskan secara detail...">{{ old('detail.' . $name) }}</textarea>
                @else
                    <input type="{{ $f['type'] }}" name="detail[{{ $name }}]" value="{{ old('detail.' . $name) }}">
                @endif
                @error('detail.' . $name)<div class="error-field">{{ $message }}</div>@enderror
            @endforeach

            <label>Lampiran (foto / dokumen pendukung)</label>
            <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">
            <small style="color:#999;">Maksimal 5 MB. File akan disimpan ke Google Drive Pusdatin.</small>
            @error('lampiran')<div class="error-field">{{ $message }}</div>@enderror

            <div style="margin-top:22px; display:flex; gap:12px;">
                <a href="{{ route('portal.tiket.create') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-merah">Kirim Tiket</button>
            </div>
        </form>
    </div>
@endsection
