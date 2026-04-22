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
        Schema::table('presensis', function (Blueprint $table) {
            $table->foreignId('jadwal_id')->nullable()->after('id')->constrained();
            $table->foreignId('siswa_id')->nullable()->after('jadwal_id')->constrained();
            $table->string('nama_siswa')->nullable()->change();
            $table->string('kelas')->nullable()->change();
            $table->integer('terlambat_menit')->default(0)->after('status');
            $table->text('keterangan')->nullable()->after('terlambat_menit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropForeign(['jadwal_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['jadwal_id', 'siswa_id', 'terlambat_menit', 'keterangan', 'created_at', 'updated_at']);
        });
    }
};
