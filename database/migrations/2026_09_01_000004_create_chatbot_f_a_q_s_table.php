<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chatbot_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('topik');
            $table->text('keywords');     // dipisah koma: "reset,password,lupa"
            $table->text('jawaban');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('chatbot_faqs'); }
};
