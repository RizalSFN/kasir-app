<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\LogStok;
use App\Models\Member;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $page = 'main';
        $title = 'transaksi';

        if (auth()->user()->role == 'petugas' && session('id')) {
            $request->session()->forget('id');
        }

        $time = explode(' ', now());
        $dari = $request->query('dari', $time[0]);
        $sampai = $request->query('sampai', $time[0]);

        if (auth()->user()->role == 'administrator') {
            $data = Penjualan::orderBy('created_at', 'DESC')->where('tanggal', '>=', $dari)->where('tanggal', '<=', $sampai)->get();
        } else {
            $data = Penjualan::orderBy('created_at', 'DESC')->where('tanggal', '>=', $dari)->where('tanggal', '<=', $sampai)->where('user_id', '=', auth()->user()->id)->get();
        }

        $new_data = $data->map(function ($d) {
            $d->total_harga_new = number_format($d->total_harga, 2, ',', '.');
            $d->potongan_member = number_format($d->potongan_member, 2, ',', '.');
            return $d;
        });

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
            return view('admin.transaksi.index', compact('page', 'title', 'dari', 'sampai', 'new_data', 'data', 'message', 'periode_sampai', 'periode_dari'));
        } else {
            return view('petugas.transaksi.index', compact('page', 'title', 'dari', 'sampai', 'new_data', 'data', 'message', 'periode_sampai', 'periode_dari'));
        }
    }

    public function transaksi()
    {
        $page = 'main';

        $produk = Produk::where('status', '=', 'ready')->get();
        $member = Member::where('status', '=', 'aktif')->get();

        // kode transaksi
        $time = explode(' ', now());
        $tanggal = explode('-', $time[0]);
        $waktu = explode(':', $time[1]);
        $kode_transaksi = 'TR' . implode('', array_reverse($tanggal)) . $waktu[0] . $waktu[1] . auth()->user()->id;

        $penjualan = Penjualan::orderBy('created_at', 'DESC')->where('tanggal', '=', $time[0])->where('user_id', '=', auth()->user()->id)->get()->first();
        if ($penjualan == null) {
            $transaksi_ke = 1;
            $kode_transaksi .= '0001';
            $new_keranjang = [];
            $member_id = '';
        } else if ($penjualan->status == 'proses') {
            $transaksi_ke = substr($penjualan->id_penjualan, 18);
            $kode_transaksi = $penjualan->id_penjualan;
            $member_id = $penjualan->member_id;
            $keranjang = DetailPenjualan::where('penjualan_id', '=', $penjualan->id_penjualan)->get();
            $new_keranjang = $keranjang->map(function ($k) {
                $k->sub_total_normal_new = number_format($k->sub_total_normal, 2, ',', '.');
                $k->sub_total_diskon_new = number_format($k->sub_total_diskon, 2, ',', '.');
                return $k;
            });
        } else {
            $transaksi_ke = substr($penjualan->id_penjualan, 18) + 1;
            $no = substr($penjualan->id_penjualan, 15) + 1;

            if (strlen($no) == 1) {
                $new_kode = '000' . $no;
            } else if (strlen($no) == 2) {
                $new_kode = '00' . $no;
            } else if (strlen($no) == 3) {
                $new_kode = '0' . $no;
            } else if (strlen($no) == 4) {
                $new_kode = $no;
            }

            $kode_transaksi .= $new_kode;
            $member_id = '';
            $new_keranjang = [];
        }

        return view('petugas.transaksi.transaksi', compact('page', 'produk', 'member', 'transaksi_ke', 'kode_transaksi', 'new_keranjang', 'member_id'));
    }

    public function tambahKeranjang(Request $request)
    {
        $exist = Penjualan::where('id_penjualan', '=', $request->input('kode_transaksi_input'))->get()->first();
        $time = explode(' ', now());

        $request->validate(
            [
                'pilih_produk' => 'required'
            ],
            [
                'pilih_produk.required' => 'Anda belum memilih produk'
            ]
        );

        if ($exist == null) {
            $penjualan = new Penjualan();
            $penjualan->id_penjualan = $request->input('kode_transaksi_input');
            $penjualan->user_id = auth()->user()->id;
            $penjualan->tanggal = $time[0];
            $penjualan->member_id = $request->input('pilih_member_input') ? $request->input('pilih_member_input') : NULL;
            $penjualan->status = 'proses';
            $penjualan->save();

            $detail = new DetailPenjualan();
            $detail->penjualan_id = $request->input('kode_transaksi_input');
            $detail->produk_id = $request->input('pilih_produk');
            $detail->jumlah_beli = $request->input('quantity');
            $detail->diskon = $request->input('diskon') ? $request->input('diskon') : NULL;
            $detail->sub_total_normal = $request->input('quantity') * $request->input('harga_satuan');
            $detail->sub_total_diskon = $request->input('diskon') ? $request->input('sub_total') : 0.00;

            $log = new LogStok();
            $log->produk_id = $request->input('pilih_produk');
            $log->penjualan_id = $request->input('kode_transaksi_input');
            $log->user_id = auth()->user()->id;
            $log->stok_keluar = $request->input('quantity');
            $log->tanggal = $time[0];
            $detail->save();
            $log->save();
        } else {
            $detail = DetailPenjualan::where('penjualan_id', '=', $request->input('kode_transaksi_input'))->where('produk_id', '=', $request->input('pilih_produk'));

            if ($detail->get()->first() == null) {
                $detail = new DetailPenjualan();
                $detail->penjualan_id = $request->input('kode_transaksi_input');
                $detail->produk_id = $request->input('pilih_produk');
                $detail->jumlah_beli = $request->input('quantity');
                $detail->diskon = $request->input('diskon') ? $request->input('diskon') : NULL;
                $detail->sub_total_normal = $request->input('quantity') * $request->input('harga_satuan');
                $detail->sub_total_diskon = $request->input('diskon') ? $request->input('sub_total') : 0.00;

                $log = new LogStok();
                $log->produk_id = $request->input('pilih_produk');
                $log->penjualan_id = $request->input('kode_transaksi_input');
                $log->user_id = auth()->user()->id;
                $log->stok_keluar = $request->input('quantity');
                $log->tanggal = $time[0];
                $detail->save();
                $log->save();
            } else {
                $detail->update([
                    'jumlah_beli' => $request->input('quantity') + $detail->get()->first()->jumlah_beli,
                    'sub_total_normal' => ($request->input('quantity') * $request->input('harga_satuan')) + +$detail->get()->first()->sub_total_normal,
                    'sub_total_diskon' => $request->input('diskon') ? $request->input('sub_total') + $detail->get()->first()->sub_total_diskon : 0.00
                ]);

                $log = LogStok::where('penjualan_id', '=', $request->input('kode_transaksi_input'))->where('produk_id', '=', $request->input('pilih_produk'));

                $log->update([
                    'stok_keluar' => $log->get()->first()->stok_keluar + $request->input('quantity')
                ]);
            }
        }

        return redirect()->back();
    }

    public function hapusKeranjang($id)
    {
        $check = DetailPenjualan::findOrFail($id);
        $exist = DetailPenjualan::where('penjualan_id', '=', $check->penjualan_id)->get();

        if (count($exist) == 1) {
            LogStok::where('penjualan_id', '=', $check->penjualan_id)->where('produk_id', '=', $check->produk_id)->delete();
            $check->delete();
            Penjualan::where('id_penjualan', '=', $check->penjualan_id)->delete();
        } else {
            LogStok::where('penjualan_id', '=', $check->penjualan_id)->where('produk_id', '=', $check->produk_id)->delete();
            $check->delete();
        }

        return redirect()->back();
    }

    public function proses(Request $request, $id)
    {
        $penjualan = Penjualan::where('id_penjualan', '=', $id);

        $penjualan->update([
            'total_harga' => $request->input('total_pembayaran_input'),
            'potongan_member' => $request->input('potongan_member'),
            'tunai' => $request->input('uang_diterima'),
            'kembalian' => $request->input('kembalian_input'),
            'status' => 'selesai'
        ]);

        $request->session()->put('id', $id);

        return redirect()->back()->with('success', 'Transaksi berhasil dilakukan');
    }

    public function struk($id)
    {
        $page = 'main';

        $detail = DetailPenjualan::where('penjualan_id', '=', $id)->get();

        $new_detail = $detail->map(function ($d) {
            $d->sub_total_normal_new = number_format($d->sub_total_normal, 2, ',', '.');
            $d->sub_total_diskon_new = number_format($d->sub_total_normal - $d->sub_total_diskon, 2, ',', '.');
            $d->produk->harga = number_format($d->produk->harga, 2, ',', '.');
            return $d;
        });

        $penjualan = Penjualan::where('id_penjualan', '=', $id)->get();

        $new_penjualan = $penjualan->map(function ($p) {
            $p->total_harga = number_format($p->total_harga, 2, ',', '.');
            $p->potongan_member = number_format($p->potongan_member, 2, ',', '.');
            $p->tunai = number_format($p->tunai, 2, ',', '.');
            $p->kembalian = number_format($p->kembalian, 2, ',', '.');
            $p->waktu = Carbon::parse($p->created_at)->isoFormat('d MMMM Y H:m');

            return $p;
        });

        if (auth()->user()->role == 'administrator') {
            return view('admin.transaksi.struk', compact('page', 'new_detail', 'new_penjualan'));
        } else {
            return view('petugas.transaksi.struk', compact('page', 'new_detail', 'new_penjualan'));
        }
    }

    public function kurangi_quantity(Request $request, $id)
    {
        $detail = DetailPenjualan::findOrFail($id);

        $detail->update([
            'jumlah_beli' => $request->input('kurangi')
        ]);

        $log = LogStok::where('penjualan_id', '=', $detail->penjualan_id)->where('produk_id', '=', $detail->produk_id);

        $produk = Produk::where('id_produk', '=', $detail->produk_id);

        $produk->update([
            'stok' => $produk->get()->first()->stok + ($log->get()->first()->stok_keluar - $request->input('kurangi'))
        ]);

        $log->update([
            'stok_keluar' => $request->input('kurangi')
        ]);


        return redirect()->back();
    }
}
