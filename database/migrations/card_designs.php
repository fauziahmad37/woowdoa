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
			Schema::create('card_designs', function (Blueprint $table) {
					$table->id();
					$table->string('name');
					$table->string('background_image');
					$table->integer('width');
					$table->integer('height');
					$table->json('elements');
					$table->timestamps();
			});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
