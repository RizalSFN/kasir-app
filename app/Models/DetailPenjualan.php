<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualan';
    protected $fillable = ['jumlah_beli'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }
}
