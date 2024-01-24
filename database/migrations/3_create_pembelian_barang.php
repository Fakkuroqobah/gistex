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
        Schema::create('pembelian_barang', function (Blueprint $table) {
            $table->id('id');
            $table->string('nomor_pembelian', 255);
            $table->date('tanggal');
            $table->string('kode_barang', 255);
            $table->string('satuan', 20);
            $table->double('qty', 8, 2);
            $table->double('harga', 10, 2);
            $table->double('diskon', 10, 2)->nullable();
            $table->double('subtotal', 10, 2);
        });

        Schema::table('pembelian_barang', function (Blueprint $table) {
            $table->foreign('kode_barang')->references('kode_barang')->on('master_barang')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_barang');
    }
};
