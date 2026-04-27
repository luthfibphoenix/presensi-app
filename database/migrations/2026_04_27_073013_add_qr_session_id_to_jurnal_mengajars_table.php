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
        Schema::table('jurnal_mengajars', function (Blueprint $table) {
            if (!Schema::hasColumn('jurnal_mengajars', 'qr_session_id')) {
                $table->bigInteger('qr_session_id')->nullable()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurnal_mengajars', function (Blueprint $table) {
            $table->dropColumn('qr_session_id');
        });
    }
};
