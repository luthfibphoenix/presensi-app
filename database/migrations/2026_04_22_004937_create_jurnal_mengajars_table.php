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
        if (!Schema::hasTable('jurnal_mengajars')) {
            Schema::create('jurnal_mengajars', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->nullable();
                $table->date('tanggal');
                $table->string('mata_pelajaran');
                $table->string('kelas');
                $table->integer('jam_mulai');
                $table->integer('jam_selesai');
                $table->text('ringkasan_materi');
                $table->string('semester');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_mengajars');
    }
};
