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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_id')->unique(); // Identifier unik kelas
            $table->string('school_id'); // Relasi ke schools
            $table->string('class_name'); // Nama kelas (misal: "X IPA 1")
            $table->string('grade'); // Tingkat kelas (misal: "10", "11", "12")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
