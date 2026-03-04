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
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); // int8 (bigint) auto increment primary key

            $table->string('app_name')->nullable();
            $table->string('site_title')->nullable();
            $table->string('home_title')->nullable();
            $table->string('site_desk', 500)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->longText('description')->nullable();

            $table->text('about_footer')->nullable();
            $table->string('copyright', 500)->nullable();

            $table->text('logo_light')->nullable();
            $table->text('logo_dark')->nullable();
            $table->text('logo_mini')->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
