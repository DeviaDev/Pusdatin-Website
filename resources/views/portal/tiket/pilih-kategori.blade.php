@extends('layouts.portal')
@section('title', 'Buat Tiket')
@section('page-title', 'Layanan Pengaduan — Buat Tiket')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pilih-kategori.css') }}">
@endpush

@section('content')
    <div class="panel">
        <!-- Header Panel Rata Tengah & Judul Merah -->
        <div class="panel-header">
            <h3>Buat Tiket</h3>
            <p class="sub-title">Pelaporan Aduan dan Permintaan Layanan Teknologi Informasi BNPT</p>
            <p class="desc">Pilih jenis layanan atau perangkat TI yang sesuai agar penanganan oleh Subbagian Teknologi Informasi dapat dilakukan dengan tepat dan efektif.</p>
        </div>

        <!-- Grid Layanan -->
        <div class="grid-layanan">
            @foreach (App\Models\Ticket::KATEGORI as $key => $label)
                <a href="{{ route('portal.tiket.create', $key) }}">
                    <div class="kartu-layanan">
                        <!-- Ikon SVG -->
                        <div class="ikon-wrap">
                            @if ($key === 'hardware')
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                            @elseif ($key === 'software')
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                            @elseif ($key === 'jaringan')
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                            @elseif ($key === 'email')
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            @elseif ($key === 'hak_akses')
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            @else
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            @endif
                        </div>

                        <!-- Judul Layanan -->
                        <h3>{{ $label }}</h3>

                        <!-- Deskripsi Layanan -->
                        <p>{{ [
                            'hardware' => 'Meliputi aduan terkait komputer, laptop, printer, scanner, serta perangkat pendukung operasional lainnya.',
                            'software' => 'Meliputi aduan terkait sistem operasi, aplikasi operasional, serta aplikasi-aplikasi pendukung lainnya.',
                            'jaringan' => 'Meliputi aduan gangguan ataupun permintaan layanan terkait kabel LAN, server, switch, router, firewall, serta koneksi internet.',
                            'email' => 'Meliputi aduan dan permintaan terkait akun surat elektronik (email) resmi instansi.',
                            'hak_akses' => 'Meliputi aduan dan permintaan terkait Hak Akses Non-Fisik (VPN, LAN, DB) dan Hak Akses Fisik (Ruang Server).',
                        ][$key] ?? 'Pelaporan dan permintaan layanan TIK.' }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Catatan Bawah Rata Tengah -->
        <p class="catatan-kategori">Catatan: Pemilihan kategori yang sesuai akan membantu mempercepat proses verifikasi dan penanganan laporan oleh Subbagian Teknologi Informasi.</p>
    </div>
@endsection