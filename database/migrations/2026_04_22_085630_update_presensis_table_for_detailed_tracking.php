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
            if (!Schema::hasColumn('presensis', 'jadwal_id')) {
                $table->foreignId('jadwal_id')->nullable()->after('id')->constrained();
            }
            if (!Schema::hasColumn('presensis', 'siswa_id')) {
                $table->foreignId('siswa_id')->nullable()->after('jadwal_id')->constrained();
            }
            if (Schema::hasColumn('presensis', 'nama_siswa')) {
                $table->string('nama_siswa')->nullable()->change();
            }
            if (Schema::hasColumn('presensis', 'kelas')) {
                $table->string('kelas')->nullable()->change();
            }
            if (!Schema::hasColumn('presensis', 'terlambat_menit')) {
                $table->integer('terlambat_menit')->default(0)->after('status');
            }
            if (!Schema::hasColumn('presensis', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('terlambat_menit');
            }
            if (!Schema::hasColumn('presensis', 'created_at')) {
                $table->timestamps();
            }
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
