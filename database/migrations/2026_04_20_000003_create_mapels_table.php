<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('mapels')) {
            Schema::create('mapels', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nama_mapel');
            });
        }
    }

    public function down(): void
    {
        // Data sudah ada, tidak di-drop
    }
};
