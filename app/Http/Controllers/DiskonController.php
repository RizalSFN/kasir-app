<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'main';
        $title = 'diskon';

        $diskon = Diskon::all();

        if ($diskon->isEmpty()) {
            $message = 'Data tidak ada';
        } else {
            $message = '';
        }

        return view('admin.diskon.index', compact('page', 'title', 'diskon', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'main';
        $title = 'diskon';

        $diskon = Diskon::all();

        if (count($diskon) > 0) {
            return redirect()->back();
        }

        return view('admin.diskon.create', compact('page', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nominal_minimum' => 'required|numeric',
                'diskon' => 'required|numeric'
            ],
            [
                'nominal_minimum.required' => 'Kolom ini harus diisi',
                'diskon.required' => 'Kolom ini harus diisi',
                'nominal_minimum.numeric' => 'Kolom ini harus berisi angka saja',
                'diskon.numeric' => 'Kolom ini harus berisi angka saja',
            ]
        );

        $diskon = new Diskon();
        $diskon->minimum_transaksi = $request->nominal_minimum;
        $diskon->diskon = $request->diskon;
        $diskon->save();

        return redirect()->route('admin.diskon')->with('success', 'Diskon member berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = 'main';
        $title = 'diskon';

        $diskon = Diskon::findOrFail($id);
        return view('admin.diskon.edit', compact('page', 'title', 'diskon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nominal_minimum' => 'required|numeric',
                'diskon' => 'required|numeric'
            ],
            [
                'nominal_minimum.required' => 'Kolom ini harus diisi',
                'diskon.required' => 'Kolom ini harus diisi',
                'nominal_minimum.numeric' => 'Kolom ini harus berisi angka saja',
                'diskon.numeric' => 'Kolom ini harus berisi angka saja',
            ]
        );

        Diskon::findOrFail($id)->update([
            'minimum_transaksi' => $request->nominal_minimum,
            'diskon' => $request->diskon
        ]);

        return redirect()->route('admin.diskon')->with('success', 'Diskon member berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Diskon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Diskon member berhasil dihapus');
    }

    public function getDiskon()
    {
        $data = Diskon::get(['minimum_transaksi', 'diskon'])->first();
        return response()->json(['minimum' => $data->minimum_transaksi, 'diskon' => $data->diskon]);
    }
}
