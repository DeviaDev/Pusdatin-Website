@extends('layouts.portal')
@section('title', 'Buat Tiket')
@section('page-title', 'Layanan Pengaduan — Buat Tiket')

@section('content')
    <div class="panel">
        <h3>Buat Tiket</h3>
        <p style="color:#666; font-size:.9rem; margin-bottom:6px;">Pelaporan Aduan dan Permintaan Layanan Teknologi Informasi BNPT</p>
        <p style="font-size:.85rem; color:#888;">Pilih jenis layanan atau perangkat TI yang sesuai agar penanganan oleh Subbagian Teknologi Informasi dapat dilakukan dengan tepat dan efektif.</p>

        <div class="grid-layanan" style="margin-top:24px; justify-content: flex-start;">
            @foreach (App\Models\Ticket::KATEGORI as $key => $label)
                <a href="{{ route('portal.tiket.create', $key) }}" style="text-decoration: none; color: inherit; flex: 0 0 calc(33.333% - 16px); min-width: 260px;">
                    <div class="kartu-layanan" style="height: 100%;">
                        <div class="ikon-wrap">
                            @if ($key === 'hardware')
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            @elseif ($key === 'software')
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                            @elseif ($key === 'jaringan')
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                            @elseif ($key === 'email')
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            @elseif ($key === 'hak_akses')
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            @else
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            @endif
                        </div>

                        <h3>{{ $label }}</h3>

                        <p>{{ [
                            'hardware' => 'Meliputi aduan terkait komputer, laptop, printer, scanner, serta perangkat pendukung operasional lainnya.',
                            'software' => 'Meliputi aduan terkait sistem operasi, aplikasi operasional, serta aplikasi-aplikasi pendukung lainnya.',
                            'jaringan' => 'Meliputi aduan gangguan ataupun permintaan layanan terkait kabel LAN, server, switch, router, firewall, serta koneksi internet.',
                            'email' => 'Meliputi aduan dan permintaan terkait akun surat elektronik (email) resmi.',
                            'hak_akses' => 'Meliputi aduan dan permintaan terkait Hak Akses Non Fisik maupun Hak Akses Fisik.',
                        ][$key] ?? 'Pelaporan dan permintaan layanan TIK.' }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <p style="font-size:.82rem; color:#888; margin-top:24px;">Catatan: Pemilihan kategori yang sesuai akan membantu mempercepat proses verifikasi dan penanganan laporan oleh Subbagian Teknologi Informasi.</p>
    </div>
@endsection