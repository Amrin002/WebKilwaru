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
       Schema::table('users', function (Blueprint $table) {
        // Ganti foreignId jadi string biasa
        $table->string('penduduk_nik', 16) // sesuaikan dengan panjang NIK
              ->nullable()
              ->after('no_hp');

        // Foreign key manual
        $table->foreign('penduduk_nik')
              ->references('nik')
              ->on('penduduks')
              ->onDelete('set null');

        $table->enum('platform_register', ['web', 'mobile'])
              ->nullable()
              ->after('penduduk_nik');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['penduduk_nik']);
                $table->dropColumn(['penduduk_nik', 'platform_register']);
    });
    }
};
