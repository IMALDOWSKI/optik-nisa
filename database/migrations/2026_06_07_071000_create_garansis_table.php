<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('garansis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('no_garansi')->unique();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'klaim', 'expired'])->default('aktif');
            $table->text('ketentuan')->nullable();
            $table->text('catatan_klaim')->nullable();
            $table->date('tanggal_klaim')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('garansis');
    }
};