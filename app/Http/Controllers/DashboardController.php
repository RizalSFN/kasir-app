<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page = 'main';
        $title = 'dashboard';

        $produk = count(Produk::all());
        $member = count(Member::all());
        $ex = explode(' ', now());
        if (auth()->user()->role == 'administrator') {
            $penjualan = Penjualan::where('tanggal', '=', $ex[0])->get();
            $petugas = count(User::where('role', '=', 'petugas')->get());
            return view('admin.dashboard.index', compact('page', 'title', 'produk', 'member', 'penjualan', 'petugas'));
        } else {
            $penjualan = count(Penjualan::where('user_id', '=', auth()->user()->id)->where('tanggal', '=', $ex[0])->get());
            return view('petugas.dashboard.index', compact('page', 'title', 'produk', 'member', 'penjualan'));
        }
    }
}
