@extends('layouts.public')
@section('title', 'Struktur Organisasi')

@section('content')
<div class="header-profil">
    <div class="header-profil-body">
        <span class="sub-judul-profil">TENTANG KAMI</span>
        <h1>Profile Pusdatin BNPT</h1>
    </div>
</div>

<div class="tab-profil-wrapper">
    <div class="tab-profil-container">
        <a href="{{ route('profil', 'tentang') }}" class="tab-item {{ request('section') == 'tentang' ? 'aktif' : '' }}">Tentang Pusdatin</a>
        <a href="{{ route('profil', 'tugas-fungsi') }}" class="tab-item {{ request('section') == 'tugas-fungsi' ? 'aktif' : '' }}">Tugas & Fungsi</a>
        <a href="{{ route('profil', 'visi-misi') }}" class="tab-item {{ request('section') == 'visi-misi' ? 'aktif' : '' }}">Visi & Misi</a>
        <a href="{{ route('profil', 'struktur') }}" class="tab-item {{ request('section', 'struktur') == 'struktur' ? 'aktif' : '' }}">Struktur Organisasi</a>
        <a href="{{ route('profil', 'kontak') }}" class="tab-item {{ request('section') == 'kontak' ? 'aktif' : '' }}">Kontak</a>
    </div>
</div>

<section class="konten-profil-wrap reveal-tab">
    <div class="container-profil layout-pusat">
        <div class="header-tengah">
            <span class="sub-judul-merah">KEPEMIMPINAN & ORGANISASI</span>
            <h2>Struktur Organisasi Pusdatin</h2>
        </div>

        <div class="tree-bagan-wrapper">
            
            <div class="level-pimpinan">
                <div class="node-box pimpinan">
                    <span class="tag-jabatan-gelap">PIMPINAN</span>
                    <h3>Kepala Pusdatin BNPT</h3>
                    <p>Dr. Ahmad Fauzi, S.T., M.T.</p>
                </div>
            </div>

            <div class="garis-v-utama"></div>

            <div class="tree-cabang-tiga">
                
                <div class="kolom-cabang">
                    <div class="node-box kabid">
                        <span class="tag-jabatan-merah">Kepala Bidang</span>
                        <h4>Bidang Pengelolaan Data</h4>
                        <p class="nama-pejabat">Sari Wulandari, S.Kom., M.M.</p>
                    </div>
                    
                    <div class="garis-v-sub"></div>

                    <div class="node-box sub-tim">
                        <span class="tag-sub">TIM KERJA</span>
                        <h5>Subbid Tata Kelola & Integrasi Data</h5>
                    </div>

                    <div class="garis-v-sub"></div>

                    <div class="node-box staf-pelaksana">
                        <span class="tag-staf">PELAKSANA / FUNGSIONAL</span>
                        <p>Analis Data & Informasi</p>
                    </div>
                </div>

                <div class="kolom-cabang">
                    <div class="node-box kabid">
                        <span class="tag-jabatan-merah">Kepala Bidang</span>
                        <h4>Bidang Sistem Informasi</h4>
                        <p class="nama-pejabat">Eko Prasetyo, S.T., M.Eng.</p>
                    </div>

                    <div class="garis-v-sub"></div>

                    <div class="node-box sub-tim">
                        <span class="tag-sub">TIM KERJA</span>
                        <h5>Subbid Infrastruktur & Jaringan</h5>
                    </div>

                    <div class="garis-v-sub"></div>

                    <div class="node-box staf-pelaksana">
                        <span class="tag-staf">PELAKSANA / FUNGSIONAL</span>
                        <p>Pranata Komputer & Siber</p>
                    </div>
                </div>

                <div class="kolom-cabang">
                    <div class="node-box kabid">
                        <span class="tag-jabatan-merah">Kepala Bidang</span>
                        <h4>Bidang Statistik & Analisis</h4>
                        <p class="nama-pejabat">Budi Santoso, M.Sc.</p>
                    </div>

                    <div class="garis-v-sub"></div>

                    <div class="node-box sub-tim">
                        <span class="tag-sub">TIM KERJA</span>
                        <h5>Subbid Diseminasi & Pelaporan</h5>
                    </div>

                    <div class="garis-v-sub"></div>

                    <div class="node-box staf-pelaksana">
                        <span class="tag-staf">PELAKSANA / FUNGSIONAL</span>
                        <p>Statistisi & Analisis Kebijakan</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid-personel-pejabat">
            <div class="card-personel">
                <div class="avatar-dummy">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="info-personel">
                    <small class="label-jabatan-personel">Kepala Pusdatin</small>
                    <b class="nama-personel">Dr. Ahmad Fauzi, S.T., M.T.</b>
                </div>
            </div>

            <div class="card-personel">
                <div class="avatar-dummy">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="info-personel">
                    <small class="label-jabatan-personel">Kabid Pengelolaan Data</small>
                    <b class="nama-personel">Sari Wulandari, S.Kom., M.M.</b>
                </div>
            </div>

            <div class="card-personel">
                <div class="avatar-dummy">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="info-personel">
                    <small class="label-jabatan-personel">Kabid Sistem Informasi</small>
                    <b class="nama-personel">Eko Prasetyo, S.T., M.Eng.</b>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection