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
        Schema::create('log_stok', function (Blueprint $table) {
            $table->id();
            $table->string('produk_id', 10);
            $table->string('penjualan_id', 20)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->mediumInteger('stok_masuk')->nullable();
            $table->mediumInteger('stok_keluar')->nullable();
            $table->date('tanggal');
            $table->timestamps();
            $table->foreign('penjualan_id')->references('id_penjualan')->on('penjualan');
            $table->foreign('produk_id')->references('id_produk')->on('produk');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_stok');
    }
};
