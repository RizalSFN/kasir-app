<?php

namespace App\Http\Controllers;

use App\Models\LogStok;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogStokController extends Controller
{
    public function index(Request $request)
    {
        $page = 'main';
        $title = 'laporan';

        $time = explode(' ', now());
        $dari = $request->query('dari', $time[0]);
        $sampai = $request->query('sampai', $time[0]);
        $kategori = $request->query('kategori', 'stok_masuk');

        if ($kategori == 'stok_masuk') {
            $data = LogStok::where('tanggal', '>=', $dari)->where('tanggal', '<=', $sampai)->where('user_id', '=', auth()->user()->id)->where('stok_masuk', '!=', NULL)->get();
        } else {
            $data = LogStok::where('tanggal', '>=', $dari)->where('tanggal', '<=', $sampai)->where('user_id', '=', auth()->user()->id)->where('stok_keluar', '!=', NULL)->get();
        }

        if ($data->isEmpty()) {
            $message = 'Data tidak ada';
        } else {
            $message = '';
        }

        $ex_dari = explode('-', $dari);
        $periode_dari = Carbon::parse(implode('-', array_reverse($ex_dari)))->format('d M Y');
        $ex_sampai = explode('-', $sampai);
        $periode_sampai = Carbon::parse(implode('-', array_reverse($ex_sampai)))->format('d M Y');

        if (auth()->user()->role == 'administrator') {
            return view('admin.laporan.index', compact('page', 'title', 'dari', 'sampai', 'kategori', 'data', 'message', 'periode_sampai', 'periode_dari'));
        } else {
            return view('petugas.laporan.index', compact('page', 'title', 'dari', 'sampai', 'kategori', 'data', 'message', 'periode_sampai', 'periode_dari'));
        }
    }
}
