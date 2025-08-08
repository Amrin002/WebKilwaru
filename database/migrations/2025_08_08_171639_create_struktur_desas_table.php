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
        Schema::create('struktur_desas', function (Blueprint $table) {
            $table->id();

            // Data Pribadi
            $table->string('nama');
            $table->string('posisi'); // Jabatan
            $table->string('image')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('nip')->nullable(); // untuk PNS

            // Kontak
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();

            // Social Media
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();

            // Informasi Jabatan
            $table->string('kategori')->nullable(); // kepala_desa, sekretaris, kaur, dll
            $table->integer('urutan')->default(0); // untuk sorting
            $table->boolean('aktif')->default(true);
            $table->date('mulai_menjabat')->nullable();
            $table->date('selesai_menjabat')->nullable();

            // Informasi Tambahan
            $table->text('deskripsi')->nullable(); // bio/tugas pokok
            $table->string('pendidikan_terakhir')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['aktif', 'urutan']);
            $table->index('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_desas');
    }
};
