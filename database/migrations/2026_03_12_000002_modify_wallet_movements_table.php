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
        Schema::table('wallet_movements', function (Blueprint $table) {
            // add kolom settlement_id
            $table->integer('settlement_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_movements', function (Blueprint $table) {
            // hapus kolom settlement_id
            $table->dropColumn('settlement_id');
        });
    }
};
