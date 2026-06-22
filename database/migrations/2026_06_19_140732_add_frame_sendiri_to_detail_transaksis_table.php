<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            // produk_id jadi boleh kosong (untuk kasus bawa frame sendiri)
            $table->foreignId('produk_id')->nullable()->change();

            // Tandai apakah baris ini adalah "frame bawa sendiri"
            $table->boolean('is_frame_sendiri')->default(false)->after('produk_id');

            // Catatan opsional, misalnya "Frame Rayban hitam milik pelanggan"
            $table->string('keterangan_frame_sendiri')->nullable()->after('is_frame_sendiri');
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropColumn(['is_frame_sendiri', 'keterangan_frame_sendiri']);
            $table->foreignId('produk_id')->nullable(false)->change();
        });
    }
};