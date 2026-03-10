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
        Schema::table('cards', function (Blueprint $table) {
						$table->id();
						$table->varchar('nis',20);
						$table->string('card_number')->unique(); 
						$table->enum('status',['active','lost','blocked','replaced'])->default('active');
						$table->integer('print_count')->default(0);
						$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
