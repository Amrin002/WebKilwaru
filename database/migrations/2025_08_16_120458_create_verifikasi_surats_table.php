<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('verifikasi_surats', function (Blueprint $table) {
            $table->id();
            // Document reference
            $table->string('nomor_surat', 100)->comment('Nomor surat yang diverifikasi');

            // Client information
            $table->string('ip_address', 45)->nullable()->comment('IP address pengakses (IPv4/IPv6)');
            $table->text('user_agent')->nullable()->comment('Browser/device information');

            // Location info (optional - for future enhancement)
            $table->string('lokasi_perkiraan', 100)->nullable()->comment('Lokasi berdasarkan IP geolocation');

            // Verification result
            $table->enum('status_hasil', ['found', 'not_found', 'error'])->default('found')->comment('Hasil verifikasi');

            // Additional tracking info
            $table->string('referrer', 255)->nullable()->comment('URL referrer jika ada');
            $table->json('device_info')->nullable()->comment('Additional device information');

            // Timestamps
            $table->timestamp('waktu_scan')->useCurrent()->comment('Waktu scan QR code');
            // No updated_at needed untuk log table

            // Indexes for performance
            $table->index(['nomor_surat'], 'idx_nomor_surat');
            $table->index(['waktu_scan'], 'idx_waktu_scan');
            $table->index(['ip_address'], 'idx_ip_address');
            $table->index(['nomor_surat', 'waktu_scan'], 'idx_nomor_waktu');
            $table->index(['status_hasil'], 'idx_status');

            // Composite index for latest verification per document
            $table->index(['nomor_surat', 'waktu_scan'], 'idx_latest_verification');
        });
        DB::statement("ALTER TABLE `verifikasi_surats` COMMENT = 'Log aktivitas verifikasi dokumen surat desa'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_surats');
    }
};
