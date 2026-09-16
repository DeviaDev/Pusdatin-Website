@extends('layouts.admin')
@section('title', 'Konten Website')
@section('page-title', 'Kelola Konten Website')
@section('content')
    <div class="panel">
        <h3>Konten Website</h3>
        <p style="font-size:.88rem; color:#777; margin-bottom:16px;">
            Kelola teks yang tampil di halaman publik. Perubahan disimpan ke database dan langsung tampil di situs publik maupun portal pegawai.
        </p>
        <table class="tabel">
            <thead><tr><th>Bagian</th><th>Konten yang Dikelola</th><th></th></tr></thead>
            <tbody>
                @foreach ($groups as $key => $group)
                    <tr>
                        <td><b>{{ $group['label'] }}</b></td>
                        <td>{{ implode(', ', $group['fields']) }}</td>
                        <td><a href="{{ route('admin.konten.edit', $key) }}" class="btn-outline" style="font-size:.82rem; padding:5px 14px;">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="panel">
        <h3>Informasi / Pengumuman</h3>
        <p style="font-size:.88rem; color:#777; margin-bottom:12px;">Halaman Informasi publik dikelola melalui menu <b>Informasi / Pengumuman</b> di sidebar.</p>
        <a href="{{ route('admin.pengumuman.index') }}" class="btn-merah" style="font-size:.88rem;">Kelola Pengumuman</a>
    </div>
@endsection
