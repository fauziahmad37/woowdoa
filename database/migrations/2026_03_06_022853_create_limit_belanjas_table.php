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
        Schema::create('limit_belanjas', function (Blueprint $table) {
            $table->id(); 
            $table->integer('school_id');  
            $table->integer('class_level');  
            $table->integer('daily_limit');  
            $table->integer('monthly_limit'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limit_belanjas');
    }
};
