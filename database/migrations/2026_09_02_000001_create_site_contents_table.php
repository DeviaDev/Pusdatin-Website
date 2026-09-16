<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
    Schema::create('content_groups', function (Blueprint $table) {
        $table->id();
        $table->string('slug')->unique();   // 'beranda', 'mitra', dst
        $table->string('label');
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });

    Schema::create('content_group_fields', function (Blueprint $table) {
        $table->id();
        $table->foreignId('content_group_id')->constrained()->cascadeOnDelete();
        $table->string('key');    // full key ke site_contents, mis. 'mitra.nama_1'
        $table->string('label');
        $table->enum('type', ['text', 'textarea', 'image'])->default('text');
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
    }
    public function down(): void { Schema::dropIfExists('site_contents'); }
};
