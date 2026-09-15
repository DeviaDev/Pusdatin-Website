<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();           // TKT-2026-001
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('kategori', ['hardware', 'software', 'jaringan', 'email', 'hak_akses']);
            $table->string('subjek');
            $table->json('detail');                          // jawaban form spesifik kategori
            $table->enum('status', ['pending', 'diproses', 'izin_eselon', 'ditolak', 'selesai'])->default('pending');
            $table->string('drive_file_id')->nullable();     // file di Google Drive
            $table->string('drive_file_link')->nullable();
            $table->string('local_file_path')->nullable();   // fallback jika Drive tidak dikonfigurasi
            $table->integer('sheet_row')->nullable();        // baris di Google Sheets
            $table->text('catatan_admin')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tickets'); }
};
