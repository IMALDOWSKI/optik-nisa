<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('jumlah_tambah');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->decimal('harga_beli', 10, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->string('no_faktur')->nullable();
            $table->date('tanggal_restok');
            $table->text('catatan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restoks');
    }
};