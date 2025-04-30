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
        Schema::create('userschools', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('school_id'); // Harus sesuai dengan school_id di tabel schools
            // $table->foreign('school_id')->references('school_id')->on('schools')->onDelete('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userschools');
    }
};
