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
        Schema::table('settlements', function (Blueprint $table) {
            // hapus period start dan end
            $table->dropColumn('period_start');
            $table->dropColumn('period_end');
            $table->dropColumn('settlement_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            // tambah kolom period_start dan period_end
            $table->date('period_start')->nullable()->after('id');
            $table->date('period_end')->nullable()->after('period_start');
            $table->string('settlement_code')->nullable()->after('period_end');
        });
    }
};
