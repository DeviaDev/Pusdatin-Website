<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();           
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('kategori', ['hardware', 'software', 'jaringan', 'email', 'hak_akses']);
            $table->string('subjek');
            $table->json('detail');                         
            $table->enum('status', ['pending', 'diproses', 'izin_eselon', 'ditolak', 'selesai'])->default('pending');
            $table->string('drive_file_id')->nullable();     
            $table->string('drive_file_link')->nullable();
            $table->string('local_file_path')->nullable();  
            $table->integer('sheet_row')->nullable();       
            $table->text('catatan_admin')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tickets'); }
};
