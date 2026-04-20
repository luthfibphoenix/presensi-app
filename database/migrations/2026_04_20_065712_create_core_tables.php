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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username');
                $table->string('password');
                $table->string('fullname');
                $table->string('position')->nullable();
                $table->string('photo_url')->nullable();
                $table->string('nip')->nullable();
                $table->string('pangkat')->nullable();
                $table->string('jabatan')->nullable();
                $table->boolean('is_wali')->nullable();
            });
        }

        if (!Schema::hasTable('kelas')) {
            Schema::create('kelas', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kelas');
                $table->string('kode_kelas');
            });
        }

        if (!Schema::hasTable('mapels')) {
            Schema::create('mapels', function (Blueprint $table) {
                $table->id();
                $table->string('nama_mapel');
            });
        }

        if (!Schema::hasTable('jadwals')) {
            Schema::create('jadwals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users');
                $table->string('hari');
                $table->integer('jam_mulai');
                $table->integer('jam_selesai');
                $table->string('mata_pelajaran');
                $table->string('kelas');
                $table->string('semester');
            });
        }

        if (!Schema::hasTable('presensis')) {
            Schema::create('presensis', function (Blueprint $table) {
                $table->id();
                $table->string('nama_siswa');
                $table->string('kelas');
                $table->date('tanggal');
                $table->string('status')->nullable();
            });
        }

        if (!Schema::hasTable('siswas')) {
            Schema::create('siswas', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->foreignId('kelas_id')->constrained('kelas');
                $table->foreignId('user_id')->nullable()->constrained('users');
                $table->string('username');
                $table->string('password');
            });
        }

        if (!Schema::hasTable('qr_sessions')) {
            Schema::create('qr_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('jadwal_id')->constrained('jadwals');
                $table->date('tanggal');
                $table->string('token');
                $table->timestamp('expired_at');
            });
        }

        if (!Schema::hasTable('izins')) {
            Schema::create('izins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id')->constrained('siswas');
                $table->date('tanggal');
                $table->text('alasan');
                $table->string('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
        Schema::dropIfExists('qr_sessions');
        Schema::dropIfExists('siswas');
        Schema::dropIfExists('presensis');
        Schema::dropIfExists('jadwals');
        Schema::dropIfExists('mapels');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('users');
    }
};
