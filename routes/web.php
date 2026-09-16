<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Portal\DashboardController;
use App\Http\Controllers\Portal\TicketController as PortalTicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\AnnouncementController;

// ===================== PUBLIK =====================
Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/profil/{section?}', [PublicController::class, 'profil'])->name('profil')->whereIn('section', ['tentang', 'tugas-fungsi', 'visi-misi', 'struktur', 'kontak']);
Route::get('/informasi', [PublicController::class, 'informasi'])->name('informasi');
Route::get('/informasi/{announcement}', [PublicController::class, 'informasiShow'])->name('informasi.show');
Route::get('/sop-pusdatin', [PublicController::class, 'sop'])->name('sop');
Route::post('/chatbot', [ChatbotController::class, 'ask'])->name('chatbot.ask');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/search', function () {return 'Search berhasil!';})->name('search');
// ===================== PORTAL PEGAWAI =====================
Route::middleware(['auth'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifikasi/baca-semua', [DashboardController::class, 'readAllNotifications'])->name('notifikasi.baca');

    Route::get('/tiket', [PortalTicketController::class, 'index'])->name('tiket.index');
    Route::get('/tiket/buat/{kategori?}', [PortalTicketController::class, 'create'])->name('tiket.create');
    Route::post('/tiket/buat/{kategori}', [PortalTicketController::class, 'store'])->name('tiket.store');
    Route::get('/tiket/{tiket}', [PortalTicketController::class, 'show'])->name('tiket.show');
});

// ===================== ADMIN =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminTicketController::class, 'index'])->name('dashboard');
    Route::get('/tiket/{tiket}', [AdminTicketController::class, 'show'])->name('tiket.show');
    Route::post('/tiket/{tiket}/status', [AdminTicketController::class, 'updateStatus'])->name('tiket.status');
    Route::resource('pengumuman', AnnouncementController::class)->except(['show']);
});
