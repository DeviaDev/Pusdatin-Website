@extends('layouts.public')

@section('title', 'Masuk Portal Pegawai')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-container">
    <div class="login-card">
        <h2>Portal Pegawai</h2>
        <p class="sub-deskripsi">Pusdatin BNPT — masuk untuk mengelola tiket layanan Anda</p>

        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="login-form">
            @csrf
            
            <div class="form-group">
                <label for="nip">Nomor Induk Pegawai (NIP) <span class="req">*</span></label>
                <input type="text" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Contoh: 197501012000011001" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="req">*</span></label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <label class="login-remember">
                <input type="checkbox" name="remember"> Ingat saya
            </label>

            <button type="submit" class="btn-merah btn-login-submit">Masuk ke Portal</button>
        </form>

        <p class="login-footer-text">
            Lupa password? <a href="#">Hubungi Helpdesk TI</a>
        </p>
    </div>
</div>
@endsection