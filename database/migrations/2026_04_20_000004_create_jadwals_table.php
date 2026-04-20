<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jadwals')) {
            Schema::create('jadwals', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('user_id')->constrained('users');
                $table->string('hari');
                $table->integer('jam_mulai');
                $table->integer('jam_selesai');
                $table->string('mata_pelajaran');
                $table->string('kelas');
                $table->string('semester')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Data sudah ada, tidak di-drop
    }
};
