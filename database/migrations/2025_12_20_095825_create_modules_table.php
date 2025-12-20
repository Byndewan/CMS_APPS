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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: 'Services', 'Portfolio', 'Tim Kami'
            $table->string('slug')->unique(); // Contoh: 'services' (buat URL admin)
            $table->string('icon')->nullable(); // Class FontAwesome, misal 'fa-briefcase'
            $table->json('form_schema')->nullable(); // [{"name":"jabatan", "type":"text", "label":"Jabatan Team"}]
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
