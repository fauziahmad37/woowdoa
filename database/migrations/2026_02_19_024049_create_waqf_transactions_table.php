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
        Schema::create('waqf_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('transaction_type')->default('wakaf'); // wakaf, sadaqah, infaq
            $table->text('purpose')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending'); // pending, completed, failed
            $table->string('transaction_code')->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waqf_transactions');
    }
};
