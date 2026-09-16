@extends('layouts.public')
@section('title', 'Tugas dan Fungsi')
@section('content')
<section class="konten">
    <h2>Tugas dan Fungsi Pusdatin</h2>
    <div class="kartu" style="max-width:800px;">
        <h3>Tugas</h3>
        <p style="line-height:1.8;">{!! nl2br(e(content('profil.tugas', 'Pusat Data dan Teknologi Informasi mempunyai tugas melaksanakan perumusan dan pelaksanaan kebijakan di bidang pengelolaan pusat data dan teknologi informasi pada Badan Nasional Penanggulangan Terorisme.'))) !!}</p>
        <h3 style="margin-top:18px;">Fungsi</h3>
        <ul style="padding-left:20px; line-height:1.9;">
            @foreach (array_filter(array_map('trim', explode("\n", content('profil.fungsi', "Perumusan kebijakan teknis pengelolaan pusat data;
Pelaksanaan pengelolaan infrastruktur teknologi informasi;
Pengembangan dan pemeliharaan sistem informasi;
Pelayanan teknologi informasi bagi unit kerja di lingkungan BNPT;
Pelaksanaan urusan administrasi Pusdatin.")))) as $fungsi)
                <li>{{ $fungsi }}</li>
            @endforeach
        </ul>
    </div>
</section>
@endsection
