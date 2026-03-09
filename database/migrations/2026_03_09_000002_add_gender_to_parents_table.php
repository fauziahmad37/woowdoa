<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->string('dead_or_alive')->nullable();
            $table->string('latest_education')->nullable();
            $table->string('occupation')->nullable();
            $table->foreignId('income_range_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('province_id')->nullable()->constrained('provinces')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
            $table->string('postal_code')->nullable();
            $table->foreignId('student_id')->nullable()->constrained('students')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('parents', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('dead_or_alive');
            $table->dropColumn('latest_education');
            $table->dropColumn('occupation');
            $table->dropColumn('income_range_id');
            $table->dropColumn('province_id');
            $table->dropColumn('city_id');
            $table->dropColumn('district_id');
            $table->dropColumn('village_id');
            $table->dropColumn('postal_code');
            $table->dropColumn('student_id');
        });
    }
};
