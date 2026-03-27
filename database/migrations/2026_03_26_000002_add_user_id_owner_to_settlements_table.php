<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            // tambah kolom user_id_owner
            $table->foreignId('user_id_owner')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('settlements', function (Blueprint $table) {
            // hapus kolom user_id_owner
            $table->dropColumn('user_id_owner');
        });
    }
};
