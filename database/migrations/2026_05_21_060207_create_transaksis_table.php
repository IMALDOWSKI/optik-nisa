<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel pelanggans
            $table->foreignId('pelanggan_id')
                  ->constrained('pelanggans')
                  ->onDelete('cascade');
            // Foreign key ke tabel produks
            $table->foreignId('produk_id')
                  ->constrained('produks')
                  ->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('total_harga', 10, 2);
            $table->date('tanggal_transaksi');
            $table->enum('status', ['pending', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};