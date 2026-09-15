@extends('layouts.public')
@section('title', 'Masuk Portal Pegawai')
@section('content')
<section class="konten" style="max-width:460px; margin:0 auto;">
    <div class="kartu" style="padding:32px;">
        <h2 style="margin-bottom:4px;">Portal Pegawai</h2>
        <p style="color:#777; font-size:.88rem; margin-bottom:20px;">Pusdatin BNPT — masuk untuk mengelola tiket layanan Anda</p>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="stack">
            @csrf
            <label>Nomor Induk Pegawai (NIP) <span class="req">*</span></label>
            <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Contoh: 197501012000011001" required autofocus>
            <label>Password <span class="req">*</span></label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            <label style="display:flex; align-items:center; gap:8px; font-weight:400; margin-top:12px;">
                <input type="checkbox" name="remember" style="width:auto;"> Ingat saya
            </label>
            <button type="submit" class="btn-merah" style="width:100%; margin-top:18px;">Masuk ke Portal</button>
        </form>

        <p style="font-size:.85rem; margin-top:16px;">
            Lupa password? <a href="#" style="color:var(--merah);">Hubungi Helpdesk TI</a>
        </p>
        <p style="font-size:.78rem; color:#999; margin-top:10px; background:var(--abu); padding:10px; border-radius:6px;">
            Demo: NIP <b>197501012000011001</b> / <b>198003032005011002</b> &middot; password: <b>password</b>
        </p>
    </div>
</section>
@endsection
