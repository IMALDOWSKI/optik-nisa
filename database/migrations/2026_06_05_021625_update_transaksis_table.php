<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kolom lama yang sudah pindah ke detail
            $table->dropForeign(['produk_id']);
            $table->dropColumn(['produk_id', 'jumlah']);

            // Tambah kolom baru
            $table->string('kode_transaksi')->unique()->after('id');
            $table->enum('metode_bayar', ['tunai', 'transfer', 'qris'])->default('tunai')->after('total_harga');
            $table->decimal('bayar', 10, 2)->nullable()->after('metode_bayar');
            $table->decimal('kembalian', 10, 2)->nullable()->after('bayar');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['kode_transaksi', 'metode_bayar', 'bayar', 'kembalian']);
        });
    }
};