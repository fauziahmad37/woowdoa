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
        Schema::create('menu', function (Blueprint $table) {
            $table->smallIncrements('menu_id');
            $table->string('menu_name', 100);
            $table->string('menu_link', 100)->nullable();
            $table->smallInteger('menu_parent');
            $table->smallInteger('menu_group');
            $table->smallInteger('menu_sort')->nullable();
            $table->smallInteger('menu_status')->default(1);
            $table->string('menu_icon', 100)->nullable();
            $table->smallInteger('menu_type')->nullable();
            $table->string('link', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
