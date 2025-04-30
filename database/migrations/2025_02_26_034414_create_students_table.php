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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // Identifier unik untuk siswa
            $table->string('nisn')->unique();
            $table->string('fullname');
            $table->string('username');
            $table->string('gender');
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->string('school_id'); // Relasi ke schools
            $table->string('class_id'); // Relasi ke classes
            $table->string('user_id')->nullable(); // Relasi ke users
            $table->year('entry_year'); // Tahun masuk siswa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
