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
        Schema::create('arsip_surat', function (Blueprint $table) {
            $table->id();

            // Data Surat (sesuai buku agenda)
            $table->string('nomor_surat', 100)->unique();
            $table->date('tanggal_surat');
            $table->string('pengirim', 255)->nullable()->comment('Untuk surat masuk');
            $table->text('perihal')->nullable()->comment('Untuk surat masuk');
            $table->string('tujuan_surat', 255)->nullable()->comment('Untuk surat keluar');
            $table->text('tentang')->nullable()->comment('Untuk surat keluar');
            $table->text('keterangan')->nullable()->comment('Catatan tambahan');

            $table->timestamps();

            // Index
            $table->index(['nomor_surat']);
            $table->index(['tanggal_surat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_surats');
    }
};
