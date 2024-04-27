<?php

namespace App\Http\Controllers;

use App\Models\LogStok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = 'main';
        $title = 'produk';

        $search = $request->query('search', '');

        if ($search == '') {
            $data = Produk::where('status', '=', 'ready')->paginate(2);
        } else {
            $data = Produk::where('id_produk', 'LIKE', '%' . $search . '%')
                ->orWhere('nama', 'LIKE', '%' . $search . '%')
                ->orWhere('status', 'LIKE', $search)
                ->paginate(10);
        }

        if ($data->total() == 0) {
            $message = 'Data tidak ada';
            $new_data = '';
            $pagination = [];
        } else {
            $new_data = $data->map(function ($d) {
                $d->harga = number_format($d->harga, 2, ',', '.');
                return $d;
            });
            $message = '';

            $pagination = new LengthAwarePaginator(
                $new_data,
                $data->total(),
                $data->perPage(),
                $data->currentPage(),
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );
        }

        if (auth()->user()->role == 'administrator') {
            return view('admin.produk.index', compact('page', 'title', 'search', 'message', 'data', 'pagination'));
        } else {
            return view('petugas.produk.index', compact('page', 'title', 'search', 'message', 'data', 'pagination'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'main';
        $title = 'produk';

        $produk = Produk::orderBy('created_at', 'DESC')->get()->first();

        if ($produk == null) {
            $new_id = 'PRD-0001';
        } else {
            $ex = explode('-', $produk->id_produk);
            $id = $ex[1] + 1;

            if (strlen($id) == 1) {
                $new_id = 'PRD-000' . $id;
            } else if (strlen($id) == 2) {
                $new_id = 'PRD-00' . $id;
            } else if (strlen($id) == 3) {
                $new_id = 'PRD-0' . $id;
            } else if (strlen($id) == 4) {
                $new_id = 'PRD-' . $id;
            }
        }

        if (auth()->user()->role == 'administrator') {
            return view('admin.produk.create', compact('page', 'title', 'new_id'));
        } else {
            return view('petugas.produk.create', compact('page', 'title', 'new_id'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_produk' => 'required',
                'harga_produk' => 'required|numeric',
                'stok_produk' => 'required|numeric',
                'diskon_produk' => 'nullable|numeric',
            ],
            [
                'nama_produk.required' => 'Kolom ini harus diisi',
                'harga_produk.required' => 'Kolom ini harus diisi',
                'harga_produk.numeric' => 'Kolom harus berisi angka saja',
                'stok_produk.numeric' => 'Kolom harus berisi angka saja',
                'diskon_produk.numeric' => 'Kolom harus berisi angka saja',
                'stok_produk.required' => 'Kolom ini harus diisi'
            ]
        );

        $time = explode(' ', now());

        $produk = new Produk();
        $produk->id_produk = $request->input('id_produk');
        $produk->nama = $request->nama_produk;
        $produk->harga = $request->harga_produk;
        $produk->stok = $request->stok_produk;
        $produk->diskon = $request->diskon_produk ? $request->diskon_produk : NULL;
        $produk->status = 'ready';

        $log = new LogStok();
        $log->produk_id = $request->input('id_produk');
        $log->user_id = auth()->user()->id;
        $log->stok_masuk = $request->stok_produk;
        $log->tanggal = $time[0];
        $produk->save();
        $log->save();

        return redirect()->back()->with('success', 'Data produk berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = 'main';
        $title = 'produk';

        $produk = Produk::where('id_produk', '=', $id)->get()->first();

        if (auth()->user()->role == 'administrator') {
            return view('admin.produk.edit', compact('page', 'title', 'produk'));
        } else {
            return view('petugas.produk.edit', compact('page', 'title', 'produk'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_produk' => 'required',
                'harga_produk' => 'required|numeric',
                'tambah_stok_produk' => 'nullable|numeric',
                'kurang_stok_produk' => 'nullable|numeric',
                'diskon_produk' => 'nullable|numeric'
            ],
            [
                'nama_produk.required' => 'Kolom ini harus diisi',
                'harga_produk.required' => 'Kolom ini harus diisi',
                'harga_produk.numeric' => 'Kolom harus berisi angka saja',
                'kurang_stok_produk.numeric' => 'Kolom harus berisi angka saja',
                'diskon_produk.numeric' => 'Kolom harus berisi angka saja',
                'tambah_stok_produk.numeric' => 'Kolom ini harus diisi'
            ]
        );

        $produk = Produk::where('id_produk', '=', $id);
        $time = explode(' ', now());

        if ($request->tambah_stok_produk || $request->kurang_stok_produk) {
            $produk->update([
                'nama' => $request->nama_produk,
                'harga' => $request->harga_produk,
                'stok' => $request->tambah_stok_produk ? $produk->get()->first()->stok + $request->tambah_stok_produk : $produk->get()->first()->stok - $request->kurang_stok_produk,
                'diskon' => $request->diskon_produk ? $request->diskon_produk : NULL
            ]);
        } else {
            $produk->update([
                'nama' => $request->nama_produk,
                'harga' => $request->harga_produk,
                'diskon' => $request->diskon_produk ? $request->diskon_produk : NULL
            ]);
        }

        $time = explode(' ', now());

        $log = new LogStok();
        $log->produk_id = $id;
        $log->user_id = auth()->user()->id;
        $log->stok_masuk = $request->tambah_stok_produk ? $request->tambah_stok_produk : NULL;
        $log->stok_keluar = $request->kurang_stok_produk ? $request->kurang_stok_produk : NULL;
        $log->tanggal = $time[0];
        $log->save();

        if (auth()->user()->role == 'administrator') {
            return redirect()->route('admin.produk')->with('success', 'Data produk berhasil diubah');
        } else {
            return redirect()->route('petugas.produk')->with('success', 'Data produk berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $status)
    {
        Produk::where('id_produk', '=', $id)->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Status produk berhasil diubah');
    }

    public function getHarga($id)
    {
        $harga = Produk::where('id_produk', '=', $id)->get('harga')->first();
        return response()->json(['harga' => $harga->harga]);
    }

    public function getStok($id)
    {
        $stok = Produk::where('id_produk', '=', $id)->get('stok')->first();
        return response()->json(['stok' => $stok->stok]);
    }

    public function getDiskon($id)
    {
        $diskon = Produk::where('id_produk', '=', $id)->get('diskon')->first();
        return response()->json(['diskon' => $diskon->diskon]);
    }
}
