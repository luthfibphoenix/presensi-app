<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom id serial ke tabel kelas jika belum ada
        if (!Schema::hasColumn('kelas', 'id')) {
            DB::statement('ALTER TABLE kelas ADD COLUMN id BIGSERIAL PRIMARY KEY');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kelas', 'id')) {
            DB::statement('ALTER TABLE kelas DROP COLUMN id');
        }
    }
};
