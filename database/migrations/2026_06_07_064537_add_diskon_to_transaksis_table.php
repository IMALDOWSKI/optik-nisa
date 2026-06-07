<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('diskon', 10, 2)->default(0)->after('total_harga');
            $table->decimal('grand_total', 10, 2)->default(0)->after('diskon');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['diskon', 'grand_total']);
        });
    }
};