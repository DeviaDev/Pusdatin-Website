@extends('layouts.public')
@section('title', 'Informasi')
@section('content')
<section class="konten">
    <h2>Informasi Terkini</h2>
    <div class="grid-3">
        @foreach ($berita as $item)
            <a href="{{ route('informasi.show', $item) }}" style="text-decoration:none;color:inherit;">
                <div class="kartu">
                    <div class="berita-thumb" 
                    @if ($item->foto) style="background-image:url('{{ asset('storage/'.$item->foto) }}');background-size:cover;background-position:center;" @endif>
                    </div>
                    <span class="badge badge-diproses">{{ $item->kategori }}</span>
                    <h3 style="margin-top:10px;">{{ $item->judul }}</h3>
                    <p>{{ Str::limit($item->isi, 140) }}</p>
                    <small style="color:#999;">{{ $item->published_at->format('d F Y') }}</small>
                </div>
            </a>
        @endforeach
    </div>
    <div style="margin-top:28px;">{{ $berita->links() }}</div>
</section>
@endsection
