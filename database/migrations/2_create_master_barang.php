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
        Schema::create('master_barang', function (Blueprint $table) {
            $table->string('kode_barang', 255)->primary();
            $table->string('nama_barang', 30);
            $table->string('satuan', 20);
            $table->double('qty', 8, 2);
            $table->double('harga', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_barang');
    }
};
