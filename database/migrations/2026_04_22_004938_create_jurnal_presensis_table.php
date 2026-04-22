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
        if (!Schema::hasTable('jurnal_presensis')) {
            Schema::create('jurnal_presensis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('jurnal_id')->constrained('jurnal_mengajars')->cascadeOnDelete();
                $table->string('nama_siswa');
                $table->string('status'); // 'Hadir', 'Sakit', 'Izin', 'Alfa'
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_presensis');
    }
};
