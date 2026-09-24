@extends('layouts.admin')
@section('title', 'Detail Pengumuman')
@section('page-title', 'Detail Pengumuman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-informasi.css') }}">
@endpush

@section('content')
<div class="panel">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.pengumuman.index') }}" class="btn-kembali-admin">&#8592; Kembali</a>
        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn-merah" style="margin-left: 10px;">Edit</a>
    </div>

    <article class="detail-admin-wrap">
        <span class="badge {{ $pengumuman->is_published ? 'badge-selesai' : 'badge-pending' }}">
            {{ $pengumuman->is_published ? 'Terbit' : 'Draft' }}
        </span>
        <span class="badge badge-diproses">{{ $pengumuman->kategori }}</span>

        <h1 style="margin: 16px 0 8px; color: var(--hitam);">{{ $pengumuman->judul }}</h1>
        <small style="color: #777; display: block; margin-bottom: 20px;">
            Dipublikasikan: {{ $pengumuman->published_at?->format('d F Y H:i') ?? 'Belum diterbitkan' }}
        </small>

        @if ($pengumuman->foto)
            <div style="max-width: 500px; margin-bottom: 20px;">
                <img src="{{ asset('storage/'.$pengumuman->foto) }}" alt="{{ $pengumuman->judul }}" style="width: 100%; border-radius: 8px;">
            </div>
        @endif

        <div style="line-height: 1.8; color: #333; font-size: 1rem;">
            {!! nl2br(e($pengumuman->isi)) !!}
        </div>
    </article>
</div>
@endsection