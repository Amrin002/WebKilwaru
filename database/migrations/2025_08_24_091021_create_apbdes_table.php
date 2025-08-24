<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            // Tahun anggaran
            $table->year('tahun');

            // 5 Bidang Belanja Wajib (dalam rupiah)
            $table->decimal('pemerintahan_desa', 15, 2)->default(0)->comment('Penyelenggaraan Pemerintahan Desa');
            $table->decimal('pembangunan_desa', 15, 2)->default(0)->comment('Pelaksanaan Pembangunan Desa');
            $table->decimal('kemasyarakatan', 15, 2)->default(0)->comment('Pembinaan Kemasyarakatan');
            $table->decimal('pemberdayaan', 15, 2)->default(0)->comment('Pemberdayaan Masyarakat');
            $table->decimal('bencana_darurat', 15, 2)->default(0)->comment('Penanggulangan Bencana & Darurat');

            // Total anggaran (calculated field)
            $table->decimal('total_anggaran', 15, 2)->default(0)->comment('Total APBDes');

            // Upload files
            $table->string('pdf_dokumen')->nullable()->comment('Path file PDF dokumen lengkap');
            $table->string('baliho_image')->nullable()->comment('Path file gambar baliho');

            $table->timestamps();

            // Index untuk performance
            $table->index('tahun');
            $table->unique('tahun'); // Satu APBDes per tahun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};
