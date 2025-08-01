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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->string('nik')->primary()->unique()->index();
            $table->string('no_kk');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('status');
            $table->string('status_keluarga');
            $table->string('golongan_darah')->nullable();
            $table->string('kewarganegaraan');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->foreign('no_kk')->references('no_kk')->on('k_k_s')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
