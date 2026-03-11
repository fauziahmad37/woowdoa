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
            $table->integer('product_type')->nullable()->after('id');
            $table->string('product_name')->nullable()->after('product_type');
            $table->integer('quantity')->nullable()->after('product_name');
            $table->decimal('price', 10, 2)->nullable()->after('quantity');
            $table->decimal('sub_total', 10, 2)->nullable()->after('price');

            $table->dropColumn('type');
            $table->dropColumn('amount');
            $table->dropColumn('saldo_before');
            $table->dropColumn('saldo_after');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn(['product_type', 'product_name', 'quantity', 'price', 'sub_total']);
        });
    }
};
