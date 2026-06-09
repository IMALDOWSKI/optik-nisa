<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->unique()->constrained('pelanggans')->onDelete('cascade');
            $table->string('no_member')->unique();
            $table->enum('level', ['silver', 'gold', 'platinum'])->default('silver');
            $table->integer('total_poin')->default(0);
            $table->integer('total_poin_digunakan')->default(0);
            $table->date('tanggal_bergabung');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};