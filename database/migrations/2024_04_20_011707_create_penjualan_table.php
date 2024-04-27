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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->string('id_penjualan', 20)->primary();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->decimal('total_harga', 10)->nullable();
            $table->string('member_id', 10)->nullable();
            $table->decimal('potongan_member', 10)->nullable();
            $table->decimal('tunai', 10)->nullable();
            $table->decimal('kembalian', 10)->nullable();
            $table->enum('status', ['proses', 'selesai']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('member_id')->references('id_member')->on('member');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
