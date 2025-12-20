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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Section (misal: "Layanan Kami")
            $table->string('zone')->default('main_center'); 
            $table->enum('type', ['static', 'dynamic']); 
            $table->foreignId('module_id')->nullable()->constrained('modules')->onDelete('set null');
            $table->integer('limit_post')->default(3); // Mau nampilin berapa biji?
            $table->longText('static_content')->nullable(); 
            $table->integer('order')->default(0); // Urutan tampil (1, 2, 3...)
            $table->boolean('is_active')->default(true);
            $table->string('bg_color')->nullable(); // Custom background per section
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
