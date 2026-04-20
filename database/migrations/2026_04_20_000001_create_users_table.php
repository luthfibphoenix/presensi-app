<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username')->unique();
                $table->string('password');
                $table->string('fullname');
                $table->string('position')->nullable();
                $table->string('photo_url')->nullable();
                $table->string('nip')->nullable();
                $table->string('pangkat')->nullable();
                $table->string('jabatan')->nullable();
                $table->boolean('is_wali')->default(false);
            });
        }
    }

    public function down(): void
    {
        // Data sudah ada, tidak di-drop
    }
};
