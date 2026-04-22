<?php
/**
 * Migration to refactor presensis table: dropping redundant columns and enforcing foreign keys.
 */

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
            // Drop redundant columns that should be accessed via relationships
            if (Schema::hasColumn('presensis', 'nama_siswa')) {
                $table->dropColumn('nama_siswa');
            }
            if (Schema::hasColumn('presensis', 'kelas')) {
                $table->dropColumn('kelas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->string('nama_siswa')->nullable();
            $table->string('kelas')->nullable();
        });
    }
};
