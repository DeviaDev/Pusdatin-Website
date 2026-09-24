@extends('layouts.public')
@section('title', $announcement->judul)
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/informasi-show.css') }}">
@endpush

@section('content')
@php
    // Menggunakan URL dinamis request()->fullUrl() untuk produksi live
    $shareUrl = request()->fullUrl();
@endphp

<div class="detail-informasi-wrap">
    <a href="{{ route('informasi') }}" class="btn-kembali-link">
        &#8592; Kembali ke Informasi
    </a>

    <div class="grid-detail-informasi">
        
        <article class="utama-informasi">
            <span class="badge-kategori-detail">{{ $announcement->kategori }}</span>
            <h1 class="judul-informasi-besar">{{ $announcement->judul }}</h1>
            
            <div class="meta-share-row">
                <div class="meta-informasi">
                    Dipublikasikan {{ $announcement->published_at->format('d F Y') }} oleh Tim Pusdatin BNPT
                </div>

                <div class="share-inline-box">
                    <span class="share-label">SHARE</span>
                    <div class="share-icons-list">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="btn-share-clean" title="Bagikan ke Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($announcement->judul) }}" target="_blank" rel="noopener noreferrer" class="btn-share-clean" title="Bagikan ke X / Twitter">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>

                        <div class="copy-link-wrapper">
                            <span class="copy-tooltip" id="copyTooltip">Link Copied!</span>
                            <button type="button" class="btn-share-clean" id="btnCopyLink" data-url="{{ $shareUrl }}" onclick="copyToClipboard(this)" title="Salin Tautan">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                                </svg>
                            </button>
                        </div>

                        <a href="https://api.whatsapp.com/send?text={{ urlencode($announcement->judul . ' - ' . $shareUrl) }}" target="_blank" rel="noopener noreferrer" class="btn-share-clean" title="Bagikan ke WhatsApp">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            @if ($announcement->foto)
                <div class="bingkai-foto-utama">
                    <img src="{{ asset('storage/'.$announcement->foto) }}" alt="{{ $announcement->judul }}">
                </div>
            @endif

            <div class="isi-konten-detail">
                {!! nl2br(e($announcement->isi)) !!}
            </div>
        </article>
        <aside class="sidebar-informasi">
            <h3 class="judul-sidebar">Informasi Lainnya</h3>
            
            @php
                $beritaLain = \App\Models\Announcement::where('id', '!=', $announcement->id)
                    ->latest('published_at')
                    ->take(4)
                    ->get();
            @endphp

            <div class="list-berita-sidebar">
                @foreach ($beritaLain as $item)
                    <a href="{{ route('informasi.show', $item) }}" class="kartu-berita-mini">
                        <div class="thumb-mini" style="background-image:url('{{ $item->foto ? asset('storage/'.$item->foto) : asset('images/default-news.jpg') }}');"></div>
                        <div class="info-mini">
                            <span class="badge-kategori-mini">{{ $item->kategori }}</span>
                            <h4 class="judul-mini">{{ $item->judul }}</h4>
                            <small class="tgl-mini">{{ $item->published_at->format('d M Y') }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </aside>

    </div>
</div>

<script>
    let tooltipTimeout;

    function copyToClipboard(buttonEl) {
        const targetUrl = buttonEl.getAttribute('data-url') || window.location.href;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(targetUrl)
                .then(() => showCopyTooltip())
                .catch(() => fallbackCopy(targetUrl));
        } else {
            fallbackCopy(targetUrl);
        }
    }

    function fallbackCopy(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
            showCopyTooltip();
        } catch (err) {
            console.error('Gagal menyalin tautan');
        }

        document.body.removeChild(textArea);
    }

    function showCopyTooltip() {
        const tooltip = document.getElementById('copyTooltip');
        if (!tooltip) return;

        clearTimeout(tooltipTimeout);

        tooltip.classList.add('show');

        tooltipTimeout = setTimeout(() => {
            tooltip.classList.remove('show');
        }, 2000);
    }
</script>
@endsection