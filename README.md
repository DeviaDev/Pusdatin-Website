# Website Pusdatin BNPT

Website informasi publik + portal internal Pusat Data dan Informasi (Pusdatin) BNPT. Dibangun dengan **Laravel**.

Dokumen ini ditujukan untuk developer yang akan melanjutkan pengembangan/maintenance project ini.

---

## 1. Gambaran Umum

Project ini terdiri dari 3 bagian utama:

1. **Halaman Publik** — beranda, profil (tentang/tugas-fungsi/visi-misi/struktur/kontak), informasi/pengumuman, SOP Pusdatin (dengan preview & unduh dokumen), dan chatbot FAQ.
2. **Portal Pegawai** — login pegawai, dashboard, pengajuan & riwayat tiket pengaduan IT.
3. **Admin Panel** — kelola tiket, pengumuman, konten dinamis halaman publik, dan dokumen SOP.

> ⚠️ **Catatan penting**: project ini sudah memiliki sistem *content editing* yang berjalan (`ContentController` + model `SiteContent` + helper `app/Helpers/content.php`) untuk mengelola konten dinamis di halaman publik. Jangan bikin skema baru (mis. `ContentSection`/`ContentField`) tanpa cek dulu apakah sudah tercakup oleh sistem yang ada.

---

## 2. Tech Stack

- **Framework**: Laravel (PHP)
- **Auth**: middleware `auth` bawaan Laravel + middleware custom `admin` untuk membedakan akses admin vs pegawai
- *(Lengkapi: versi Laravel/PHP, frontend — Blade/Livewire/Vue/dsb, database — MySQL/PostgreSQL, styling — Tailwind/Bootstrap, dsb.)*

---

## 3. Struktur Data (Models)

| Model | Fungsi |
|---|---|
| `Announcement` | Pengumuman/informasi publik |
| `ChatbotFAQ` | Data FAQ untuk chatbot publik |
| `SiteContent` | Konten dinamis halaman publik (dipakai sistem content editing) |
| `SopDocument` | Dokumen SOP Pusdatin (preview & unduh) |
| `Ticket` | Tiket pengaduan IT dari portal pegawai |
| `TicketStatusHistory` | Riwayat perubahan status tiket |

*(Lengkapi field masing-masing model, relasi antar model, dan lokasi migration jika diperlukan detail lebih lanjut.)*

---

## 4. Controllers

**Publik & Auth** (`app/Http/Controllers/`)
- `PublicController` — beranda, profil, informasi, SOP publik
- `AuthController` — login/logout
- `ChatbotController` — endpoint chatbot FAQ (`POST /chatbot`)

**Portal Pegawai** (`app/Http/Controllers/Portal/`)
- `DashboardController` — dashboard pegawai + notifikasi
- `TicketController` — buat, lihat, unduh, hapus tiket pengaduan

**Admin** (`app/Http/Controllers/Admin/`)
- `DashboardController` — dashboard admin
- `TicketController` — kelola & ubah status tiket
- `AnnouncementController` — CRUD pengumuman (resource controller)
- `ContentController` — kelola konten dinamis (section, field, mitra)
- `SopController` — CRUD dokumen SOP

Ada juga helper `app/Helpers/content.php` yang dipakai bersama sistem content editing di atas.

---

## 5. Routing

### Publik (tanpa login)
| Method | URL | Controller@method | Nama Route |
|---|---|---|---|
| GET | `/` | `PublicController@beranda` | `beranda` |
| GET | `/profil/{section?}` | `PublicController@profil` | `profil` |
| POST | `/profil/kontak` | `PublicController@kirimKontak` | `profil.kontak.kirim` |
| GET | `/informasi` | `PublicController@informasi` | `informasi` |
| GET | `/informasi/{announcement}` | `PublicController@informasiShow` | `informasi.show` |
| GET | `/sop-pusdatin` | `PublicController@sop` | `sop` |
| GET | `/sop-pusdatin/{sop}/unduh` | `PublicController@sopDownload` | `sop.unduh` |
| POST | `/chatbot` | `ChatbotController@ask` | `chatbot.ask` |
| GET/POST | `/login`, `/logout` | `AuthController` | `login`, `login.post`, `logout` |

`{section}` pada route profil dibatasi ke: `tentang`, `tugas-fungsi`, `visi-misi`, `struktur`, `kontak`.

### Portal Pegawai — prefix `/portal`, middleware `auth`
| Method | URL | Controller@method | Nama Route |
|---|---|---|---|
| GET | `/dashboard` | `Portal\DashboardController@index` | `portal.dashboard` |
| POST | `/notifikasi/baca-semua` | `Portal\DashboardController@readAllNotifications` | `portal.notifikasi.baca` |
| GET | `/tiket` | `Portal\TicketController@index` | `portal.tiket.index` |
| GET | `/tiket/buat/{kategori?}` | `Portal\TicketController@create` | `portal.tiket.create` |
| POST | `/tiket/buat/{kategori}` | `Portal\TicketController@store` | `portal.tiket.store` |
| GET | `/tiket/{tiket}` | `Portal\TicketController@show` | `portal.tiket.show` |
| GET | `/tiket/{tiket}/download-local` | `Portal\TicketController@downloadLocal` | `portal.tiket.download-local` |
| DELETE | `/tiket/{tiket}` | `Portal\TicketController@destroy` | `portal.tiket.destroy` |

### Admin — prefix `/admin`, middleware `auth`, `admin`
| Method | URL | Controller@method | Nama Route |
|---|---|---|---|
| GET | `/` | `Admin\DashboardController@index` | `admin.dashboard` |
| GET | `/tiket` | `Admin\TicketController@index` | `admin.tiket.index` |
| GET | `/tiket/{tiket}` | `Admin\TicketController@show` | `admin.tiket.show` |
| POST | `/tiket/{tiket}/status` | `Admin\TicketController@updateStatus` | `admin.tiket.status` |
| resource | `/pengumuman` | `Admin\AnnouncementController` | `admin.pengumuman.*` |
| GET | `/konten` | `Admin\ContentController@index` | `admin.konten.index` |
| GET | `/konten/{group:slug}` | `Admin\ContentController@edit` | `admin.konten.edit` |
| PUT | `/konten/{group:slug}` | `Admin\ContentController@update` | `admin.konten.update` |
| POST | `/konten/section` | `Admin\ContentController@storeGroup` | `admin.konten.section.store` |
| POST | `/konten/{group:slug}/field` | `Admin\ContentController@storeField` | `admin.konten.field.store` |
| DELETE | `/konten/field/{field}` | `Admin\ContentController@destroyField` | `admin.konten.field.destroy` |
| POST | `/konten/{group:slug}/mitra` | `Admin\ContentController@storeMitra` | `admin.konten.mitra.store` |
| resource (kecuali show) | `/sop` | `Admin\SopController` | `admin.sop.*` |
| GET | `/sop/{sop}/unduh` | `Admin\SopController@download` | `admin.sop.unduh` |

> Catatan: di file `routes/web.php` saat ini ada dua blok komentar `// ===== PUBLIK =====` dan route `beranda`/`profil` yang terdefinisi dua kali. Ini tidak error (route kedua akan menimpa yang pertama), tapi sebaiknya dirapikan supaya tidak membingungkan developer berikutnya.

---

## 6. Instalasi & Setup (TODO — lengkapi oleh developer)

```bash
git clone <url-repo>
cd <folder-project>
composer install
cp .env.example .env
php artisan key:generate
# Lengkapi konfigurasi database & lainnya di .env
php artisan migrate --seed
php artisan serve
```

*(Bagian ini perlu dicek ulang & dilengkapi — Environment variable apa saja yang wajib diisi, seeder apa yang tersedia, storage link (`php artisan storage:link`) untuk file SOP/gambar pengumuman, dsb.)*

## 7. Deployment (TODO — lengkapi oleh developer)

*(Hosting yang dipakai, proses build asset, cara update ke server produksi, cron job jika ada, dsb.)*

---

## 8. Hal yang Perlu Diperhatikan Developer Pengganti

- Cek ulang duplikasi route publik di `routes/web.php` (lihat catatan di bagian 5).
- Sistem konten dinamis (`ContentController`/`SiteContent`/`content.php` helper) sudah berfungsi — pelajari alurnya dulu sebelum menambah fitur konten baru.
- Fitur unduh SOP ada dua jalur: publik (`sop.unduh`) dan admin (`admin.sop.unduh`) — pastikan keduanya konsisten soal permission dan lokasi file.
- Tiket punya riwayat status (`TicketStatusHistory`) — kalau menambah status baru, pastikan konsisten dengan nilai status yang dipakai bot WhatsApp pengaduan (lihat repo `bnpt-whatsapp-ticketing-bot`), karena kedua sistem berbagi konsep tiket yang sama.
