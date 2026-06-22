<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->foreignId('resep_mata_id')->nullable()
                  ->after('pelanggan_id')
                  ->constrained('resep_matas')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['resep_mata_id']);
            $table->dropColumn('resep_mata_id');
        });
    }
};