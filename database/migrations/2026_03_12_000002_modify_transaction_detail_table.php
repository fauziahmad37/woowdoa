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
        Schema::table('transaction_details', function (Blueprint $table) {
            // hapus kolom virtual_account_number
            $table->dropColumn('reference');
            $table->dropColumn('quantity');
            $table->dropColumn('sub_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            // tambah kolom virtual_account_number
            $table->string('reference')->nullable()->after('transaction_id');
            $table->integer('quantity')->nullable()->after('reference');
            $table->decimal('sub_total', 15, 2)->nullable()->after('quantity');
        });
    }
};
