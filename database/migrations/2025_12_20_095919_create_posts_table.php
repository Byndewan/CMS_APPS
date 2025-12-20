<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('title'); // Judul standar (Wajib ada di semua modul)
            $table->string('slug')->unique(); // URL Friendly
            $table->string('thumbnail')->nullable(); // Gambar cover (opsional)
            $table->json('meta_data')->nullable(); 
            $table->boolean('is_published')->default(true);
            $table->integer('views')->default(0); // Hitung jumlah lihat (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
