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
        Schema::table('siswas', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas', 'username')) {
                $table->string('username')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'password')) {
                $table->string('password')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'nis')) {
                $table->string('nis')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'nisn')) {
                $table->string('nisn')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'jk')) {
                $table->string('jk')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'nik')) {
                $table->string('nik')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'agama')) {
                $table->string('agama')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable();
            }
            if (!Schema::hasColumn('siswas', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'password',
                'nis',
                'nisn',
                'jk',
                'tempat_lahir',
                'tgl_lahir',
                'nik',
                'agama',
                'alamat',
                'nama_ayah',
                'nama_ibu',
            ]);
        });
    }
};
