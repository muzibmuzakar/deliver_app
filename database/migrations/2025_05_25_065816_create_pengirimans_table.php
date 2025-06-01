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
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surats')->onDelete('cascade');
            $table->foreignId('kurir_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('waktu_dikirim');
            $table->dateTime('waktu_diterima')->nullable();
            $table->string('bukti_pengiriman')->nullable(); // bisa simpan path gambar
            $table->integer('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};
