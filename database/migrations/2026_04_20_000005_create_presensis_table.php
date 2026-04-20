<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('presensis')) {
            Schema::create('presensis', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nama_siswa');
                $table->string('kelas');
                $table->date('tanggal');
                $table->string('status')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Data sudah ada, tidak di-drop
    }
};
