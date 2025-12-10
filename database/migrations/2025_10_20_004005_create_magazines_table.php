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
        Schema::create('magazines', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users & promos
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('promo_id')->nullable()->constrained('promos');
            // Informasi majalah
            $table->string('title');                     // Judul majalah
            $table->text('description');     // Deskripsi
            $table->string('category');                  // Kategori
            $table->integer('price');             // Harga (misal 25000.00)
            $table->year('publication_year');            // Tahun terbit
            $table->string('cover');         // Gambar sampul
            $table->boolean('actived');   // Status aktif / tidak

            $table->timestamps();
            $table->softDeletes(); // kalau model pakai use SoftDeletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazines');
    }
};
