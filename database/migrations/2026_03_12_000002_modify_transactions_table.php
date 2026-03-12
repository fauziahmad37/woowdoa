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
        Schema::table('transactions', function (Blueprint $table) {
            // hapus kolom virtual_account_number
            $table->dropColumn('virtual_account_number');

            // tambah kolom card_number
            $table->string('card_number')->nullable()->after('transaction_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // tambah kolom virtual_account_number
            $table->string('virtual_account_number')->nullable()->after('transaction_code');

            // hapus kolom card_number
            $table->dropColumn('card_number');

        });
    }
};
