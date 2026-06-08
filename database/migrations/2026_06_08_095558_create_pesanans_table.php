<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai_dibuat',
                'siap_diambil',
                'sudah_diambil'
            ])->default('menunggu');
            $table->date('tanggal_estimasi')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->text('catatan_internal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};