<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code', 50)->unique(); // kode aset unik
            $table->string('name');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->year('year_purchased')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            // Spesifikasi teknis (khusus PC)
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('os')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            // Spesifikasi tambahan (JSON untuk fleksibilitas)
            $table->json('specs')->nullable(); // spek tambahan bebas
            // Kondisi & status
            $table->enum('condition', ['baik', 'rusak_ringan', 'rusak_berat', 'tidak_berfungsi'])
                  ->default('baik');
            $table->enum('status', ['aktif', 'perbaikan', 'penghapusan', 'dipinjam'])
                  ->default('aktif');
            $table->text('notes')->nullable();
            $table->date('last_checked')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
