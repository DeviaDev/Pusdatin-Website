<?php
namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\ChatbotFAQ;
use App\Models\SopDocument;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nip' => '197501012000011001',
            'nama' => 'Pegawai Demo',
            'email' => 'pegawai@bnpt.go.id',
            'unit_kerja' => 'Pusdatin BNPT',
            'jabatan' => 'Analis Teknologi Informasi',
            'no_hp' => '081234567890',
            'role' => 'pegawai',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'nip' => '198003032005011002',
            'nama' => 'Admin Pusdatin',
            'email' => 'helpdesk@bnpt.go.id',
            'unit_kerja' => 'Subbagian Teknologi Informasi',
            'jabatan' => 'Admin Helpdesk TI',
            'no_hp' => '081298765432',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        Announcement::insert([
            ['judul' => 'Pemeliharaan BNPT-SIS', 'isi' => 'Akan dilakukan pemeliharaan sistem BNPT-SIS pada Sabtu, 12 September 2026 pukul 22.00–02.00 WIB. Selama proses berlangsung akses sistem akan terganggu.', 'kategori' => 'Pengumuman', 'is_published' => true, 'published_at' => now()->subDays(2)],
            ['judul' => 'Update Password Policy', 'isi' => 'Mulai 1 Oktober 2026, seluruh pegawai wajib mengganti password portal minimal 12 karakter mengandung huruf besar, huruf kecil, angka, dan simbol.', 'kategori' => 'Kebijakan', 'is_published' => true, 'published_at' => now()->subDays(5)],
            ['judul' => 'Sertifikasi ISO 27001 diraih', 'isi' => 'Pusdatin BNPT berhasil meraih sertifikasi ISO/IEC 27001:2022 untuk Sistem Manajemen Keamanan Informasi.', 'kategori' => 'Informasi', 'is_published' => true, 'published_at' => now()->subDays(8)],
        ]);

        SopDocument::insert([
            ['kode' => 'SOP-001', 'nama' => 'SOP Pengajuan Akses Sistem Informasi', 'klasifikasi' => 'Keamanan Informasi', 'deskripsi' => 'Prosedur pengajuan, persetujuan, dan pencabutan akses sistem informasi bagi pegawai.', 'file_path' => null, 'file_name' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SOP-002', 'nama' => 'SOP Backup dan Recovery Data', 'klasifikasi' => 'Keamanan Informasi', 'deskripsi' => 'Prosedur pencadangan dan pemulihan data pada pusat data.', 'file_path' => null, 'file_name' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SOP-003', 'nama' => 'SOP Pemasangan Perangkat di Area Kantor', 'klasifikasi' => 'Sumber Daya Manusia', 'deskripsi' => 'Prosedur permintaan dan pemasangan perangkat keras di area kerja.', 'file_path' => null, 'file_name' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SOP-004', 'nama' => 'SOP Pengembangan dan Pemeliharaan Aplikasi', 'klasifikasi' => 'Teknologi Informasi', 'deskripsi' => 'Prosedur siklus hidup pengembangan aplikasi mulai dari analisis hingga deployment.', 'file_path' => null, 'file_name' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SOP-005', 'nama' => 'SOP Pengelolaan Jaringan Komputer', 'klasifikasi' => 'Teknologi Informasi', 'deskripsi' => 'Prosedur pengelolaan dan pemeliharaan infrastruktur jaringan.', 'file_path' => null, 'file_name' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'SOP-006', 'nama' => 'SOP Pengelolaan Data Center', 'klasifikasi' => 'Infrastruktur', 'deskripsi' => 'Prosedur operasional dan keamanan pusat data.', 'file_path' => null, 'file_name' => null, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $faqs = [
            ['topik' => 'Layanan Pengaduan', 'keywords' => 'aduan,pengaduan,tiket,lapor,laporan', 'jawaban' => 'Anda dapat membuat tiket pengaduan melalui menu Layanan Pengaduan setelah login. Tersedia 5 kategori: Gangguan Perangkat Keras, Gangguan Perangkat Lunak, Jaringan dan Infrastruktur Internet, Layanan Akun Email, dan Layanan Hak Akses. Tim kami akan menindaklanjuti sesuai antrean.'],
            ['topik' => 'Login Portal', 'keywords' => 'login,masuk,nip,password,lupa password', 'jawaban' => 'Login portal menggunakan NIP dan password. Jika lupa password, hubungi Helpdesk TI di (021) 384-5555 ext. 200 atau email pusdatin@bnpt.go.id pada jam kerja Senin–Jumat 08.00–16.00 WIB.'],
            ['topik' => 'Jam Layanan', 'keywords' => 'jam,buka,tutup,operasional,helpdesk', 'jawaban' => 'Layanan Helpdesk TI Pusdatin beroperasi Senin–Jumat pukul 08.00–16.00 WIB, kecuali hari libur nasional. Tiket yang dibuat di luar jam kerja akan diproses pada hari kerja berikutnya.'],
            ['topik' => 'Layanan Email', 'keywords' => 'email,reset,akun email,bnppt mail', 'jawaban' => 'Untuk reset password email, pembuatan akun email baru, atau kendala kirim-terima, gunakan kategori Layanan Akun Email di menu Layanan Pengaduan.'],
            ['topik' => 'Hak Akses', 'keywords' => 'akses,vpn,hak akses,aplikasi,izin', 'jawaban' => 'Permintaan hak akses (VPN, aplikasi internal, folder, ruang pusat data) diajukan melalui kategori Layanan Hak Akses. Beberapa permintaan memerlukan izin eselon sebelum diproses lebih lanjut.'],
            ['topik' => 'Kontak', 'keywords' => 'kontak,alamat,telepon,lokasi', 'jawaban' => 'Kantor kami berlokasi di Jl. H. Juanda No. 1, Jakarta Pusat 10120. Telepon (021) 384-5555 ext. 200, email pusdatin@bnpt.go.id.'],
            ['topik' => 'SOP', 'keywords' => 'sop,prosedur,dokumen', 'jawaban' => 'Dokumen SOP Pusdatin dapat diunduh melalui menu SOP Pusdatin pada navigasi utama website.'],
        ];
        foreach ($faqs as $f) {
            ChatbotFAQ::create($f + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
