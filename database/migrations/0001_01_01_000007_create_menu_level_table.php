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
        Schema::create('menu_level', function (Blueprint $table) {
            $table->increments('menu_level_id'); // serial4 PK
            $table->smallInteger('menu_level_user_level')->nullable();
            $table->smallInteger('menu_level_menu')->nullable();

            // Foreign Key
            $table->foreign('menu_level_user_level')
                ->references('user_level_id')
                ->on('user_levels')
                ->cascadeOnDelete();

            $table->foreign('menu_level_menu')
                ->references('menu_id')
                ->on('menu')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_level');
    }
};
