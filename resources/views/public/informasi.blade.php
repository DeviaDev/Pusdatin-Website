@extends('layouts.public')
@section('title', 'Informasi Terkini')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/informasi.css') }}">
@endpush

@section('content')
<div class="header-profil">
    <div class="header-profil-body">
        <span class="sub-judul-profil">BERITA & INFORMASI</span>
        <h1>Informasi Terkini Pusdatin</h1>
    </div>
</div>

<div class="informasi-container">
    <div class="grid-informasi">
        @foreach ($berita as $item)
            <a href="{{ route('informasi.show', $item) }}" class="informasi-item-link">
                <div class="kartu-informasi">
                    <div class="informasi-thumb" 
                        @if ($item->foto) style="background-image:url('{{ asset('storage/'.$item->foto) }}');" @endif>
                    </div>
                    
                    <span class="badge badge-diproses informasi-badge">{{ $item->kategori }}</span>
                    
                    <h3 class="informasi-judul">{{ $item->judul }}</h3>
                    
                    <p class="informasi-ringkasan">{{ Str::limit($item->isi, 130) }}</p>
                    
                    <small class="informasi-tanggal">{{ $item->published_at->translatedFormat('d F Y') }}</small>
                </div>
            </a>
        @endforeach
    </div>

    <div class="informasi-pagination">
        {{ $berita->links() }}
    </div>
</div>
@endsection