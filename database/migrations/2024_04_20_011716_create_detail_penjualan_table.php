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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('penjualan_id', 20);
            $table->string('produk_id', 10);
            $table->mediumInteger('jumlah_beli');
            $table->tinyInteger('diskon')->nullable();
            $table->decimal('sub_total_normal', 10);
            $table->decimal('sub_total_diskon', 10);
            $table->timestamps();
            $table->foreign('penjualan_id')->references('id_penjualan')->on('penjualan');
            $table->foreign('produk_id')->references('id_produk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
