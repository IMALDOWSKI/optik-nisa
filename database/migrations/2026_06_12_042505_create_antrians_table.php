<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_antrian');
            $table->date('tanggal');
            $table->string('nama_pelanggan')->nullable();
            $table->enum('keperluan', ['kontrol_mata', 'beli_produk', 'ambil_pesanan', 'konsultasi', 'lainnya'])->default('lainnya');
            $table->enum('status', ['menunggu', 'dipanggil', 'selesai', 'batal'])->default('menunggu');
            $table->timestamp('dipanggil_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};