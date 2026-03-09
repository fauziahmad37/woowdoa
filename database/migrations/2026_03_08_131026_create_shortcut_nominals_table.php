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
        Schema::create('shortcut_nominals', function (Blueprint $table) {
            $table->id();
            $table->integer('school_id');  
						$table->integer('nominal1');   
						$table->integer('nominal2');   
						$table->integer('nominal3');   
						$table->integer('nominal4');   
						$table->integer('nominal5');   
						$table->integer('nominal6');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shortcut_nominals');
    }
};
