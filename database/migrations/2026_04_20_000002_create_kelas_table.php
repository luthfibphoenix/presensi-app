<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('kelas')) {
            Schema::create('kelas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nama_kelas');
                $table->string('kode_kelas')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Data sudah ada, tidak di-drop
    }
};
