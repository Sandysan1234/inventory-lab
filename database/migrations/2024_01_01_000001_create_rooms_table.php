<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique(); // e.g. LAB-01, LAB-02
            $table->string('name');
            $table->enum('type', ['lab_informatika', 'ruangan_lain']);
            $table->integer('capacity')->nullable(); // jumlah PC untuk lab
            $table->string('location')->nullable(); // gedung/lantai
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
