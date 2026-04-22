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
        Schema::table('qr_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('qr_sessions', 'guru_id')) {
                $table->unsignedBigInteger('guru_id')->nullable()->after('jadwal_id');
                $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('qr_sessions', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qr_sessions', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropColumn(['guru_id', 'created_at', 'updated_at']);
        });
    }
};
