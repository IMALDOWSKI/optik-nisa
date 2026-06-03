<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Kolom tambahan untuk Frame
            $table->string('material')->nullable()->after('merk');
            $table->string('ukuran')->nullable()->after('material');
            $table->string('warna')->nullable()->after('ukuran');
            $table->enum('gender', ['pria', 'wanita', 'unisex'])->nullable()->after('warna');

            // Kolom tambahan untuk Lensa
            $table->string('jenis_lensa')->nullable()->after('gender');
            $table->string('indeks_lensa')->nullable()->after('jenis_lensa');
            $table->string('coating')->nullable()->after('indeks_lensa');

            // Kolom umum
            $table->string('kode_produk')->nullable()->unique()->after('id');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('stok');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn([
                'material', 'ukuran', 'warna', 'gender',
                'jenis_lensa', 'indeks_lensa', 'coating',
                'kode_produk', 'status'
            ]);
        });
    }
};