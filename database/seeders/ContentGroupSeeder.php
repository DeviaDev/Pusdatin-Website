<?php
namespace Database\Seeders;

use App\Models\ContentGroup;
use Illuminate\Database\Seeder;

class ContentGroupSeeder extends Seeder
{
    public function run(): void
    {
        $legacy = [
            'beranda' => ['label' => 'Halaman Beranda (Hero)', 'fields' => [
                'beranda.judul' => ['Judul Utama (Hero)', 'text'],
                'beranda.subjudul' => ['Deskripsi / Subjudul Hero', 'textarea'],
            ]],
            'tentang' => ['label' => 'Profil — Tentang Pusdatin', 'fields' => [
                'profil.tentang' => ['Isi Tentang Pusdatin', 'textarea'],
            ]],
            'tugas-fungsi' => ['label' => 'Profil — Tugas dan Fungsi', 'fields' => [
                'profil.tugas' => ['Tugas', 'textarea'],
                'profil.fungsi' => ['Fungsi (satu per baris)', 'textarea'],
            ]],
            'visi-misi' => ['label' => 'Profil — Visi dan Misi', 'fields' => [
                'profil.visi' => ['Visi', 'textarea'],
                'profil.misi' => ['Misi', 'textarea'],
            ]],
            'kontak' => ['label' => 'Profil — Kontak', 'fields' => [
                'profil.kontak.alamat' => ['Alamat', 'textarea'],
                'profil.kontak.telepon' => ['Telepon', 'text'],
                'profil.kontak.email' => ['Email', 'text'],
                'profil.kontak.jam' => ['Jam Layanan', 'text'],
            ]],
            // section baru contoh, boleh dihapus kalau mau nambah manual lewat UI
            'mitra' => ['label' => 'Mitra Pusdatin', 'fields' => [
                'mitra.nama_1' => ['Nama Mitra 1', 'text'],
                'mitra.logo_1' => ['Logo Mitra 1', 'image'],
            ]],
        ];

        $urutan = 0;
        foreach ($legacy as $slug => $g) {
            $group = ContentGroup::updateOrCreate(['slug' => $slug], ['label' => $g['label'], 'urutan' => $urutan++]);
            $f = 0;
            foreach ($g['fields'] as $key => [$label, $type]) {
                $group->fields()->updateOrCreate(['key' => $key], ['label' => $label, 'type' => $type, 'urutan' => $f++]);
            }
        }
    }
}