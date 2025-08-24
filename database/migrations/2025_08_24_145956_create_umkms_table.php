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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            // Data validasi (tidak ditampilkan publik)
            $table->string('nik', 16)->comment('NIK pemilik untuk validasi admin');

            // Data UMKM utama
            $table->string('nama_umkm', 255)->comment('Nama usaha/brand');
            $table->enum('kategori', [
                'makanan',
                'jasa',
                'kerajinan',
                'pertanian',
                'perdagangan',
                'lainnya'
            ])->comment('Kategori usaha');

            // Data produk
            $table->string('nama_produk', 255)->comment('Nama produk/layanan utama');
            $table->text('deskripsi_produk')->comment('Deskripsi detail produk');
            $table->string('foto_produk', 255)->nullable()->comment('Nama file foto produk');

            // Data kontak
            $table->string('nomor_telepon', 20)->comment('Nomor WhatsApp/telepon');
            $table->string('link_facebook', 500)->nullable()->comment('URL Facebook page/profile');
            $table->string('link_instagram', 500)->nullable()->comment('URL Instagram profile');
            $table->string('link_tiktok', 500)->nullable()->comment('URL TikTok profile');

            // Status approval
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->comment('Status verifikasi admin');
            $table->text('catatan_admin')->nullable()->comment('Catatan admin jika ditolak');

            // Metadata
            $table->timestamp('approved_at')->nullable()->comment('Waktu disetujui admin');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('Admin yang menyetujui');

            $table->timestamps();

            // Indexes untuk performa
            $table->index('nik', 'idx_umkm_nik');
            $table->index('status', 'idx_umkm_status');
            $table->index('kategori', 'idx_umkm_kategori');
            $table->index(['status', 'approved_at'], 'idx_umkm_status_approved');

            // Foreign key constraints
            $table->foreign('nik')
                ->references('nik')
                ->on('penduduks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
