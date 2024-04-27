<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStok extends Model
{
    use HasFactory;
    protected $table = 'log_stok';

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
