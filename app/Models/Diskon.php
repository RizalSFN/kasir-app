<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;
    protected $table = 'diskon_member';

    protected $fillable = [
        'minimum_transaksi',
        'diskon'
    ];
}
