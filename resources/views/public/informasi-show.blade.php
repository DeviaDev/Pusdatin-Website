@extends('layouts.public')
@section('title', $announcement->judul)
@section('content')
<section class="konten" style="max-width:800px; margin:0 auto;">
    <nav>
        <a href="{{ route('informasi') }}" style="display:inline-block; margin-bottom:16px; color:var(--merah); text-decoration:none; font-weight:600;">
        &#8592; Kembali ke Informasi
    </a>
    </nav>

    <span class="badge badge-diproses">{{ $announcement->kategori }}</span>
    <h2 style="margin-top:12px;">{{ $announcement->judul }}</h2>
    <small style="color:#999;">Dipublikasikan {{ $announcement->published_at->format('d F Y') }} oleh Tim Pusdatin BNPT</small>

    <div class="kartu" style="margin-top:20px; padding:0; overflow:hidden;">
        @if ($announcement->foto)
            <img src="{{ asset('storage/'.$announcement->foto) }}" style="width:100%; height:260px; object-fit:cover; display:block;">
        @endif
        <div style="padding:20px; line-height:1.8;">
            {{ $announcement->isi }}
        </div>
    </div>

    <div style="margin-top:20px;">
        <a href="#" class="btn-outline">Bagikan: Facebook</a>
        <a href="#" class="btn-outline">WhatsApp</a>
        <a href="#" class="btn-outline">Twitter</a>
    </div>
</section>
@endsection