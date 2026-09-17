@extends('layouts.admin')
@section('title', 'Edit Konten')
@section('page-title', 'Edit Konten — ' . $group->label)
@section('content')
<div style="display:grid; grid-template-columns:260px 1fr; gap:24px;">

    <div class="panel">
        <h4 style="margin-bottom:12px;">Section</h4>
        <div style="display:flex; flex-direction:column; gap:4px;">
            @foreach ($groups as $g)
                <a href="{{ route('admin.konten.edit', $g) }}"
                   style="display:block; padding:8px 10px; border-radius:6px; text-decoration:none; font-size:.9rem;
                          color:{{ $g->id === $group->id ? '#fff' : '#333' }};
                          background:{{ $g->id === $group->id ? 'var(--merah)' : 'transparent' }};">
                    {{ $g->label }}
                </a>
            @endforeach
        </div>

        <hr style="margin:16px 0;">
        <h4 style="margin-bottom:8px;">Tambah Section</h4>
        <form method="POST" action="{{ route('admin.konten.section.store') }}" class="stack">
            @csrf
            <input type="text" name="slug" placeholder="slug, mis: sop" required>
            <input type="text" name="label" placeholder="Label, mis: SOP Pusdatin" required>
            <button type="submit" class="btn-outline" style="font-size:.85rem;">+ Tambah</button>
        </form>
    </div>

    <div class="panel">
        <form method="POST" action="{{ route('admin.konten.update', $group) }}" class="stack" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @forelse ($group->fields as $field)
                <div style="border:1px solid #eee; border-radius:8px; padding:12px; margin-bottom:10px;">
                    <label>{{ $field->label }}</label>

                    @if ($field->type === 'textarea')
                        <textarea name="fields[{{ $field->id }}]" rows="5">{{ old("fields.$field->id", $values[$field->id]) }}</textarea>
                    @elseif ($field->type === 'image')
                        @if ($values[$field->id])
                            <img src="{{ asset('storage/'.$values[$field->id]) }}" style="max-width:160px;border-radius:6px;display:block;margin-bottom:8px;">
                        @endif
                        <input type="file" name="fields[{{ $field->id }}]" accept="image/*">
                    @else
                        <input type="text" name="fields[{{ $field->id }}]" value="{{ old("fields.$field->id", $values[$field->id]) }}">
                    @endif

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:6px;">
                        <small style="color:#999;">Key: <code>{{ $field->key }}</code></small>
                        <button type="button" onclick="hapusField({{ $field->id }})" style="border:none;background:none;color:#c0392b;cursor:pointer;font-size:.8rem;">Hapus</button>
                    </div>
                </div>
            @empty
                <p style="color:#999;">Belum ada field. Tambahkan di bawah.</p>
            @endforelse

            <button type="submit" class="btn-merah" style="margin-top:12px;">Simpan Perubahan</button>
        </form>

        <form method="POST" id="form-hapus-field" style="display:none;">
            @csrf
            @method('DELETE')
        </form>

        @if ($group->slug === 'mitra')

    <hr style="margin:20px 0;">

    <h4 style="margin-bottom:8px;">Tambah Mitra Baru</h4>

    <p style="color:#777; font-size:.85rem; margin-bottom:14px;">
        Tambahkan nama dan logo mitra sekaligus.
    </p>

    <form method="POST"
          action="{{ route('admin.konten.mitra.store', $group) }}"
          class="stack"
          style="max-width:400px;"
          enctype="multipart/form-data">

        @csrf

        <label>Nama Mitra</label>
        <input type="text"
               name="nama"
               placeholder="Contoh: Kementerian Komunikasi dan Informatika"
               required>

        <label>Logo Mitra</label>
        <input type="file"
               name="logo"
               accept="image/*"
               required>

        <button type="submit" class="btn-merah">
            + Tambah Mitra
        </button>

    </form>

@else

    <hr style="margin:20px 0;">

    <h4 style="margin-bottom:8px;">Tambah Field Baru</h4>

    <form method="POST"
          action="{{ route('admin.konten.field.store', $group) }}"
          class="stack"
          style="max-width:400px;">

        @csrf

        <input type="text"
               name="key"
               placeholder="key, mis: judul">

        <input type="text"
               name="label"
               placeholder="Label">

        <select name="type">
            <option value="text">Teks pendek</option>
            <option value="textarea">Teks panjang</option>
            <option value="image">Gambar / Logo</option>
        </select>

        <button type="submit" class="btn-outline">
            + Tambah Field
        </button>

    </form>

@endif
    </div>
</div>

<script>
    function hapusField(fieldId) {
        if (!confirm('Hapus field ini?')) return;
        const form = document.getElementById('form-hapus-field');
        form.action = '/admin/konten/field/' + fieldId;
        form.submit();
    }
</script>
@endsection