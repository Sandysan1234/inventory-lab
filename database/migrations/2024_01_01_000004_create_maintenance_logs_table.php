<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('type', ['pemeliharaan', 'perbaikan', 'penggantian_komponen', 'pemeriksaan']);
            $table->text('description');
            $table->string('technician')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->enum('condition_before', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_berfungsi']);
            $table->enum('condition_after', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_berfungsi']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
