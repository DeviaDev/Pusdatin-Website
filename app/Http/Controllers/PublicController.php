<?php
namespace App\Http\Controllers;

use App\Models\Announcement;

class PublicController extends Controller
{
    public function beranda()
    {
        $pengumuman = Announcement::published()->take(3)->get();
        return view('public.beranda', compact('pengumuman'));
    }

    public function profil(string $section = 'tentang')
    {
        abort_unless(in_array($section, ['tentang', 'tugas-fungsi', 'visi-misi', 'struktur', 'kontak']), 404);
        return view('public.profil.' . $section);
    }

    public function informasi()
    {
        $berita = Announcement::published()->paginate(6);
        return view('public.informasi', compact('berita'));
    }

    public function informasiShow(Announcement $announcement)
    {
        abort_unless($announcement->is_published, 404);
        return view('public.informasi-show', compact('announcement'));
    }

    public function sop()
    {
        // Dokumen SOP statis — bisa diganti DB bila perlu
        $sopList = [
            ['kode' => 'SOP-001', 'nama' => 'SOP Pengajuan Akses Sistem Informasi', 'klasifikasi' => 'Keamanan Informasi'],
            ['kode' => 'SOP-002', 'nama' => 'SOP Backup dan Recovery Data', 'klasifikasi' => 'Keamanan Informasi'],
            ['kode' => 'SOP-003', 'nama' => 'SOP Pemasangan Perangkat di Area Kantor', 'klasifikasi' => 'Sumber Daya Manusia'],
            ['kode' => 'SOP-004', 'nama' => 'SOP Pengembangan dan Pemeliharaan Aplikasi', 'klasifikasi' => 'Teknologi Informasi'],
            ['kode' => 'SOP-005', 'nama' => 'SOP Pengelolaan Jaringan Komputer', 'klasifikasi' => 'Teknologi Informasi'],
            ['kode' => 'SOP-006', 'nama' => 'SOP Pengelolaan Data Center', 'klasifikasi' => 'Infrastruktur'],
        ];
        return view('public.sop', compact('sopList'));
    }
}
