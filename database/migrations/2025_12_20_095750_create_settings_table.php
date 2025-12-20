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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Contoh: 'app_color', 'site_logo'
            $table->text('value')->nullable(); // Contoh: '#FF0000', 'uploads/logo.png'
            $table->string('type'); // Pilihan: 'text', 'color', 'image', 'textarea'
            $table->string('group')->default('general'); // Pilihan: 'general', 'appearance', 'contact'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
