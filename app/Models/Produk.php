<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';

    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_produk', 'produk_id');
    }

    public function log_stok()
    {
        return $this->hasMany(LogStok::class, 'id_produk', 'produk_id');
    }
}
