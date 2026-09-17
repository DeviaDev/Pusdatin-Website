@extends('layouts.public')
@section('title', 'SOP Pusdatin')
@section('content')
<section class="konten">
    <h2>Dokumen SOP Pusdatin</h2>
    @if ($sopList->isEmpty())
        <div class="kartu"><p>Belum ada dokumen SOP yang dipublikasikan.</p></div>
    @else
    <input type="text" id="sop-search" placeholder="Cari SOP berdasarkan judul atau nomor..."
           style="width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:8px; margin-bottom:12px;"
           oninput="filterSop()">

    <div id="sop-filter" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
        <button type="button" class="btn-outline sop-filter-btn aktif" data-klas="semua" onclick="setFilter('semua', this)">Semua</button>
        @foreach ($sopList->pluck('klasifikasi')->unique() as $klas)
            <button type="button" class="btn-outline sop-filter-btn" data-klas="{{ $klas }}" onclick="setFilter('{{ $klas }}', this)">{{ $klas }}</button>
        @endforeach
    </div>

    <div style="display:grid; grid-template-columns: 320px 1fr; gap:24px; height:calc(100vh - 260px); min-height:500px;" class="sop-wrap">
        <div id="sop-list" style="overflow-y:auto; padding-right:4px;">
            @foreach ($sopList as $i => $sop)
                <div class="sop-item"
                    data-klas="{{ $sop->klasifikasi }}"
                    data-cari="{{ strtolower($sop->kode.' '.$sop->nama) }}"
                    style="margin-bottom:10px; cursor:pointer;"
                    onclick="document.querySelectorAll('.sop-prev').forEach(e=>e.style.display='none');document.getElementById('sop-{{ $sop->id }}').style.display='block';">

                    <small style="color:#999;">
                        {{ $sop->kode }} &middot; {{ $sop->klasifikasi }}
                    </small>

                    <h3>{{ $sop->nama }}</h3>

                    @if ($sop->file_path)
                        <a href="{{ route('sop.unduh', $sop) }}"
                            onclick="event.stopPropagation();"
                            class="sop-download">
                                <span>&#8681;</span> Unduh Dokumen
                            </a>
                    @endif

                </div>
            @endforeach
        </div>

        <div class="sop-preview-card">
            @foreach ($sopList as $i => $sop)
                <div class="sop-prev" id="sop-{{ $sop->id }}" style="display: {{ $i === 0 ? 'block' : 'none' }};">
                    <h3 style="text-align:center;">{{ $sop->nama }}</h3>
                    <p style="text-align:center;color:#999;">{{ $sop->kode }} &middot; Klasifikasi: {{ $sop->klasifikasi }}</p>
                    <p style="margin-top:16px; color:#666; line-height:1.8;">{{ $sop->deskripsi ?? 'Dokumen SOP ini diunggah oleh administrator Pusdatin BNPT.' }}</p>

                    @if ($sop->file_path)
                        @php $ext = strtolower(pathinfo($sop->file_path, PATHINFO_EXTENSION)); @endphp
                        <div style="margin-top:20px;">
                            @if (in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                <img src="{{ asset('storage/'.$sop->file_path) }}" style="width:100%; border:1px solid #eee; border-radius:8px;">
                            @elseif ($ext === 'pdf')
                                <iframe src="{{ asset('storage/'.$sop->file_path) }}" style="width:100%; height:600px; border:1px solid #eee; border-radius:8px;" loading="lazy"></iframe>
                            @elseif (in_array($ext, ['doc','docx']))
                                <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('storage/'.$sop->file_path)) }}&embedded=true" style="width:100%; height:600px; border:1px solid #eee; border-radius:8px;" loading="lazy"></iframe>
                                <p style="font-size:.8rem;color:#999;margin-top:6px;">Preview Word butuh server publik (bukan localhost). Kalau kosong, pakai tombol unduh.</p>
                            @else
                                <p style="color:#999;">Preview tidak tersedia untuk format ini.</p>
                            @endif
                        </div>
                        <div style="text-align:center; margin:16px 0;">
                            <a href="{{ route('sop.unduh', $sop) }}" class="btn-merah">&#8681; Unduh Dokumen</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <style>
        @media (max-width: 900px) {
            .sop-wrap { grid-template-columns: 1fr !important; height:auto !important; }
            #sop-list, .sop-wrap .kartu { max-height:70vh; }
        }
        .sop-filter-btn.aktif { background:var(--merah); color:#fff; border-color:var(--merah); }
    </style>

    <script>
        let currentKlas = 'semua';
        function setFilter(klas, btn) {
            currentKlas = klas;
            document.querySelectorAll('.sop-filter-btn').forEach(b => b.classList.remove('aktif'));
            btn.classList.add('aktif');
            filterSop();
        }
        function filterSop() {
            const q = document.getElementById('sop-search').value.toLowerCase().trim();
            document.querySelectorAll('.sop-item').forEach(item => {
                const matchKlas = currentKlas === 'semua' || item.dataset.klas === currentKlas;
                const matchCari = q === '' || item.dataset.cari.includes(q);
                item.style.display = (matchKlas && matchCari) ? 'block' : 'none';
            });
        }
    </script>
    @endif
</section>
@endsection