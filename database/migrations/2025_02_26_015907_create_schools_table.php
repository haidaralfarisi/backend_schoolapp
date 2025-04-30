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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_id')->unique(); // Tetap unik jika ini ID khusus
            $table->string('school_name'); // Hapu  s unique agar bisa duplikat
            $table->string('region')->nullable();
            $table->string('address')->nullable();
            $table->string('email'); // Hapus unique agar bisa duplikat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
