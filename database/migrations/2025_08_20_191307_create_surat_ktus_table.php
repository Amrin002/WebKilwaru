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
        Schema::create('surat_ktus', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable()->unique();
            $table->string('public_token')->nullable()->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('kewarganegaraan');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->string('nama_usaha');
            $table->string('jenis_usaha');
            $table->string('alamat_usaha');
            $table->string('pemilik_usaha');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['diproses', 'disetujui', 'ditolak'])->default('diproses');
            $table->string('qr_code_path')->nullable()->comment('Path to the QR code image');
            $table->string('nomor_telepon', 20)->nullable()->comment('Nomor telepon untuk kontak');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_ktus');
    }
};
