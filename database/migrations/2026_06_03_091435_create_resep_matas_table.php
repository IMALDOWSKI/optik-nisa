<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_matas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');

            // Mata Kanan (OD - Oculus Dexter)
            $table->decimal('od_sph', 5, 2)->nullable()->comment('Spheris Kanan');
            $table->decimal('od_cyl', 5, 2)->nullable()->comment('Cylinder Kanan');
            $table->integer('od_axis')->nullable()->comment('Axis Kanan');
            $table->decimal('od_add', 5, 2)->nullable()->comment('Addition Kanan');

            // Mata Kiri (OS - Oculus Sinister)
            $table->decimal('os_sph', 5, 2)->nullable()->comment('Spheris Kiri');
            $table->decimal('os_cyl', 5, 2)->nullable()->comment('Cylinder Kiri');
            $table->integer('os_axis')->nullable()->comment('Axis Kiri');
            $table->decimal('os_add', 5, 2)->nullable()->comment('Addition Kiri');

            // PD (Pupillary Distance)
            $table->decimal('pd_kanan', 5, 2)->nullable();
            $table->decimal('pd_kiri', 5, 2)->nullable();

            $table->date('tanggal_periksa');
            $table->string('dokter')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_matas');
    }
};