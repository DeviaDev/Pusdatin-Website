@extends('layouts.portal')
@section('title', 'Buat Tiket')
@section('page-title', 'Layanan Pengaduan — Buat Tiket')
@section('content')
    <div class="panel">
        <h3>Buat Tiket</h3>
        <p style="color:#666; font-size:.9rem; margin-bottom:6px;">Pelaporan Aduan dan Permintaan Layanan Teknologi Informasi BNPT</p>
        <p style="font-size:.85rem; color:#888;">Pilih jenis layanan atau perangkat TI yang sesuai agar penanganan oleh Subbagian Teknologi Informasi dapat dilakukan dengan tepat dan efektif.</p>

        <div class="pilih-kategori" style="margin-top:18px;">
            @foreach (App\Models\Ticket::KATEGORI as $key => $label)
                <a href="{{ route('portal.tiket.create', $key) }}">
                    <div class="kartu" style="height:100%;">
                        <h3>{{ $loop->iteration }}. {{ $label }}</h3>
                        <p>{{ [
                            'hardware' => 'Meliputi aduan terkait komputer, laptop, printer, scanner, serta perangkat pendukung operasional lainnya.',
                            'software' => 'Meliputi aduan terkait sistem operasi, aplikasi operasional, serta aplikasi-aplikasi pendukung lainnya.',
                            'jaringan' => 'Meliputi aduan gangguan ataupun permintaan layanan terkait kabel LAN, server, switch, router, firewall, serta koneksi internet.',
                            'email' => 'Meliputi aduan dan permintaan terkait akun surat elektronik (email) resmi.',
                            'hak_akses' => 'Meliputi aduan dan permintaan terkait Hak Akses Non Fisik maupun Hak Akses Fisik.',
                        ][$key] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <p style="font-size:.82rem; color:#888; margin-top:16px;">Catatan: Pemilihan kategori yang sesuai akan membantu mempercepat proses verifikasi dan penanganan laporan oleh Subbagian Teknologi Informasi.</p>
    </div>
@endsection
