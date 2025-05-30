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
        Schema::create('ereports', function (Blueprint $table) {
            $table->id();
            $table->string('school_id');
            $table->string('class_id');
            $table->string('report_file');
            $table->string('student_id');
            $table->string('user_id');
            $table->string('tahun_ajaran_id'); // foreign key to tahun_ajarans table

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ereports');
    }
};
