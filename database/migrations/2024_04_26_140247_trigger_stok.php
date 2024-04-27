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
        DB::unprepared('
            CREATE TRIGGER kurangi_stok AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
            UPDATE `produk` SET stok = stok - NEW.jumlah_beli WHERE produk.id_produk = NEW.produk_id;
            END
        ');
        DB::unprepared('
            CREATE TRIGGER kembalikan_stok AFTER DELETE ON `detail_penjualan` FOR EACH ROW BEGIN
            UPDATE `produk` SET stok = stok + OLD.jumlah_beli WHERE produk.id_produk = OLD.produk_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `kurangi_stok`');
        DB::unprepared('DROP TRIGGER `kembalikan_stok`');
    }
};
