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
        Schema::create('surat_ktms', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100)->unique()->nullable();
            $table->string('public_token')->nullable()->unique();
            $table->string('nama', 100);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('status_kawin', 50);
            $table->string('kewarganegaraan');
            $table->string('alamat');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['diproses', 'disetujui', 'ditolak'])->default('diproses');
            $table->string('qr_code_path')->nullable()->comment('Path to the QR code image');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nomor_telepon', 20)->nullable()->comment('Nomor telepon untuk kontak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_ktms');
    }
};
