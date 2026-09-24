@extends('layouts.public')
@section('title', 'SOP Pusdatin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sop-public.css') }}">
@endpush

@section('content')
<div class="header-profil">
    <div class="header-profil-body">
        <span class="sub-judul-profil">STANDAR OPERASIONAL PROSEDUR</span>
        <h1>Dokumen SOP Pusdatin</h1>
    </div>
</div>

<section class="konten">
    @if ($sopList->isEmpty())
        <div class="kartu"><p>Belum ada dokumen SOP yang dipublikasikan.</p></div>
    @else

    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px; align-items:center;">
        <input type="text" id="sop-search" placeholder="Cari SOP berdasarkan judul atau nomor..."
               style="flex:1; min-width:240px; padding:10px 14px; border:1px solid #ddd; border-radius:8px;"
               oninput="filterSop()">

        <select id="sop-tahun" onchange="filterSop()" style="padding:10px 14px; border:1px solid #ddd; border-radius:8px; background:#fff; cursor:pointer;">
            <option value="semua">Semua Tahun</option>
            @php
                $tahunList = $sopList->map(fn($item) => $item->published_at ? $item->published_at->format('Y') : null)->filter()->unique()->sortDesc();
            @endphp
            @foreach ($tahunList as $thn)
                <option value="{{ $thn }}">{{ $thn }}</option>
            @endforeach
        </select>

        <select id="sop-bulan" onchange="filterSop()" style="padding:10px 14px; border:1px solid #ddd; border-radius:8px; background:#fff; cursor:pointer;">
            <option value="semua">Semua Bulan</option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
        <select id="sop-tanggal" onchange="filterSop()" style="padding:10px 14px; border:1px solid #ddd; border-radius:8px; background:#fff; cursor:pointer;">
            <option value="semua">Semua Tgl</option>
            @for ($d = 1; $d <= 31; $d++)
                @php $valD = str_pad($d, 2, '0', STR_PAD_LEFT); @endphp
                <option value="{{ $valD }}">Tgl {{ $d }}</option>
            @endfor
        </select>

        <button type="button" onclick="resetFilterTanggal()" style="padding:10px 16px; background:#e2e8f0; border:none; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.85rem;">Reset Filter</button>
    </div>

    <div id="sop-filter" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
        <button type="button" class="sop-filter-btn aktif" data-klas="semua" onclick="setFilter('semua', this)">Semua</button>
        @foreach ($sopList->pluck('klasifikasi')->unique() as $klas)
            <button type="button" class="sop-filter-btn" data-klas="{{ $klas }}" onclick="setFilter('{{ $klas }}', this)">{{ $klas }}</button>
        @endforeach
    </div>

    <div style="display:grid; grid-template-columns: 320px 1fr; gap:24px; height:calc(100vh - 260px); min-height:500px;" class="sop-wrap">
        
        <div id="sop-list" style="overflow-y:auto; padding-right:4px;">
            @foreach ($sopList as $i => $sop)
                @php 
                    $thnSop = $sop->published_at ? $sop->published_at->format('Y') : '';
                    $blnSop = $sop->published_at ? $sop->published_at->format('m') : '';
                    $tglSop = $sop->published_at ? $sop->published_at->format('d') : '';
                    $tglTampil = $sop->published_at ? $sop->published_at->format('d M Y') : '-';
                @endphp
                <div class="sop-item"
                    data-klas="{{ $sop->klasifikasi }}"
                    data-cari="{{ strtolower($sop->kode.' '.$sop->nama) }}"
                    data-tahun="{{ $thnSop }}"
                    data-bulan="{{ $blnSop }}"
                    data-tanggal="{{ $tglSop }}"
                    style="margin-bottom:10px; cursor:pointer;"
                    onclick="document.querySelectorAll('.sop-prev').forEach(e=>e.style.display='none');document.getElementById('sop-{{ $sop->id }}').style.display='block';">

                    <small style="color:#999; display:block; margin-bottom:4px;">
                        {{ $sop->kode }} &middot; {{ $sop->klasifikasi }}
                    </small>

                    <h3>{{ $sop->nama }}</h3>

                    <div style="margin-top:6px; font-size:0.8rem; color:#666;">
                        <span>Terbit: <b>{{ $tglTampil }}</b></span>
                    </div>

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
                <div class="sop-prev" id="sop-{{ $sop->id }}" style="display: {{ $i === 0 ? 'block' : 'none' }}; position: relative; padding-top: 10px;">
                    
                    @if ($sop->file_path)
                        <a href="{{ route('sop.unduh', $sop) }}" class="btn-unduh-icon-line" title="Unduh Dokumen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </a>
                    @endif

                    <h3 style="text-align:center; padding-right: 40px; padding-left: 40px;">{{ $sop->nama }}</h3>
                    
                    <p style="text-align:center; color:#888; font-size:0.88rem; margin-top:4px;">
                        Kode: <b>{{ $sop->kode }}</b> &middot; Klasifikasi: <b>{{ $sop->klasifikasi }}</b> &middot; Terbit: <b>{{ $sop->published_at ? $sop->published_at->format('d F Y') : '-' }}</b>
                    </p>

                    <p style="margin-top:16px; color:#666; line-height:1.8;">{{ $sop->deskripsi ?? 'Dokumen SOP ini diunggah oleh administrator Pusdatin BNPT.' }}</p>

                    @if ($sop->file_path)
                        @php $ext = strtolower(pathinfo($sop->file_path, PATHINFO_EXTENSION)); @endphp
                        <div style="margin-top:20px;">
                            @if (in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                <img src="{{ asset('storage/'.$sop->file_path) }}" style="width:100%; border:1px solid #eee; border-radius:8px;">
                            @elseif ($ext === 'pdf')
                                <iframe src="{{ asset('storage/'.$sop->file_path) }}" style="width:100%; height:600px; border:1px solid #eee; border-radius:8px;" loading="lazy"></iframe>
                            @else
                                <p style="color:#999;">Preview tidak tersedia untuk format ini.</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        let currentKlas = 'semua';

        function setFilter(klas, btn) {
            currentKlas = klas;
            document.querySelectorAll('.sop-filter-btn').forEach(b => b.classList.remove('aktif'));
            btn.classList.add('aktif');
            filterSop();
        }

        function resetFilterTanggal() {
            document.getElementById('sop-tahun').value = 'semua';
            document.getElementById('sop-bulan').value = 'semua';
            document.getElementById('sop-tanggal').value = 'semua';
            filterSop();
        }

        function filterSop() {
            const q = document.getElementById('sop-search').value.toLowerCase().trim();
            const valTahun = document.getElementById('sop-tahun').value;
            const valBulan = document.getElementById('sop-bulan').value;
            const valTanggal = document.getElementById('sop-tanggal').value;

            document.querySelectorAll('.sop-item').forEach(item => {
                const matchKlas = currentKlas === 'semua' || item.dataset.klas === currentKlas;
                const matchCari = q === '' || item.dataset.cari.includes(q);
                
                const matchTahun = valTahun === 'semua' || item.dataset.tahun === valTahun;
                const matchBulan = valBulan === 'semua' || item.dataset.bulan === valBulan;
                const matchTanggal = valTanggal === 'semua' || item.dataset.tanggal === valTanggal;

                item.style.display = (matchKlas && matchCari && matchTahun && matchBulan && matchTanggal) ? 'block' : 'none';
            });
        }
    </script>
    @endif
</section>
@endsection