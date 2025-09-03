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
        Schema::create('surat_k_p_t_s', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100)->unique()->nullable()->comment('Nomor surat keterangan');
            $table->string('public_token')->nullable()->unique()->comment('Token unik untuk verifikasi publik');

            // Data penanda tangan
            $table->string('nama', 100)->comment('Nama penanda tangan surat');
            $table->string('jabatan')->comment('Jabatan penanda tangan surat');
            $table->string('alamat')->comment('Alamat penanda tangan surat');

            // Data yang diterangkan
            $table->string('nama_yang_bersangkutan')->comment('Nama orang yang diterangkan');
            $table->string('nik')->nullable()->comment('NIK orang yang diterangkan');
            $table->string('tempat_lahir')->nullable()->comment('Tempat lahir orang yang diterangkan');
            $table->date('tanggal_lahir')->nullable()->comment('Tanggal lahir orang yang diterangkan');
            $table->string('jenis_kelamin')->nullable()->comment('Jenis kelamin orang yang diterangkan');
            $table->string('agama')->nullable()->comment('Agama orang yang diterangkan');
            $table->string('pekerjaan')->nullable()->comment('Pekerjaan orang yang diterangkan');
            $table->text('alamat_yang_bersangkutan')->nullable()->comment('Alamat orang yang diterangkan');

            // Data penghasilan dan keperluan
            $table->string('nama_ayah')->nullable()->comment('Nama Ayah dari yang bersangkutan');
            $table->string('nama_ibu')->nullable()->comment('Nama Ibu dari yang bersangkutan');
            $table->string('pekerjaan_orang_tua')->nullable()->comment('Pekerjaan orang tua dari yang bersangkutan');
            $table->unsignedBigInteger('penghasilan_per_bulan')->nullable()->comment('Jumlah penghasilan per bulan');
            $table->text('keperluan')->nullable()->comment('Keperluan pembuatan surat');

            $table->enum('status', ['diproses', 'disetujui', 'ditolak'])->default('diproses');
            $table->string('qr_code_path')->nullable()->comment('Path QR code untuk verifikasi surat');
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
        Schema::dropIfExists('surat_k_p_t_s');
    }
};
