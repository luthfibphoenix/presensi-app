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
        Schema::create('catatan_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('siswa_id');
            $table->string('judul');
            $table->text('isi');
            $table->string('kategori'); // Perilaku, Akademik, Prestasi, Lainnya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_siswas');
    }
};
