<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use App\Models\Member;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = 'main';
        $title = 'member';

        $search = $request->query('search', '');

        if ($search == '') {
            $data = Member::where('status', '=', 'aktif')->paginate(10);
        } else {
            $data = Member::where('id_member', 'LIKE', '%' . $search . '%')
                ->orWhere('nama', 'LIKE', '%' . $search . '%')
                ->orWhere('alamat', 'LIKE', '%' . $search . '%')
                ->orWhere('telepon', 'LIKE', '%' . $search . '%')
                ->where('status', '=', 'aktif')
                ->paginate(10);
        }

        if ($data->total() == 0) {
            $message = 'Data tidak ada';
        } else {
            $message = '';
            $new_data = $data->map(function ($d) {
                $d->transaksi = count(Penjualan::where('member_id', '=', $d->id_member)->get());
                return $d;
            });
        }

        if (auth()->user()->role == 'administrator') {
            return view('admin.member.index', compact('page', 'title', 'data', 'message'));
        } else {
            return view('petugas.member.index', compact('page', 'title', 'data', 'message'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'main';
        $title = 'member';

        $member = Member::orderBy('created_at', 'DESC')->get()->first();

        if ($member == null) {
            $new_id = 'MBR-0001';
        } else {
            $ex = explode('-', $member->id_member);
            $id = $ex[1] + 1;

            if (strlen($id) == 1) {
                $new_id = 'MBR-000' . $id;
            } else if (strlen($id) == 2) {
                $new_id = 'MBR-00' . $id;
            } else if (strlen($id) == 3) {
                $new_id = 'MBR-0' . $id;
            } else if (strlen($id) == 4) {
                $new_id = 'MBR-' . $id;
            }
        }

        if (auth()->user()->role == 'administrator') {
            return view('admin.member.create', compact('page', 'title', 'new_id'));
        } else {
            return view('petugas.member.create', compact('page', 'title', 'new_id'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_member' => 'required',
                'alamat_member' => 'required',
                'telepon_member' => 'required|numeric',
            ],
            [
                'nama_member.required' => 'Kolom ini harus diisi',
                'alamat_member.required' => 'Kolom ini harus diisi',
                'telepon_member.required' => 'Kolom ini harus diisi',
                'telelpon_member.numeric' => 'Kolom harus berisi angka saja'
            ]
        );

        $member = new Member();
        $member->id_member = $request->input('id_member');
        $member->nama = $request->nama_member;
        $member->alamat = $request->alamat_member;
        $member->telepon = $request->telepon_member;
        $member->status = 'aktif';
        $member->save();

        if (auth()->user()->role == 'administrator') {
            return redirect()->route('admin.member')->with('success', 'Data member berhasil disimpan');
        } else {
            return redirect()->route('petugas.member')->with('success', 'Data member berhasil disimpan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = 'main';
        $title = 'member';

        $data = Member::where('id_member', '=', $id)->get()->first();

        if (auth()->user()->role == 'administrator') {
            return view('admin.member.edit', compact('page', 'title', 'data'));
        } else {
            return view('petugas.member.edit', compact('page', 'title', 'data'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_member' => 'required',
                'alamat_member' => 'required',
                'telepon_member' => 'required|numeric'
            ],
            [
                'nama_member.required' => 'Kolom ini harus diisi',
                'alamat_member.required' => 'Kolom ini harus diisi',
                'telepon_member.required' => 'Kolom ini harus diisi',
                'telelpon_member.numeric' => 'Kolom harus berisi angka saja'
            ]
        );

        $member = Member::where('id_member', '=', $id)->update([
            'nama' => $request->nama_member,
            'alamat' => $request->alamat_member,
            'telepon' => $request->telepon_member
        ]);

        if (auth()->user()->role == 'administrator') {
            return redirect()->route('admin.member')->with('success', 'Data member berhasil diubah');
        } else {
            return redirect()->route('petugas.member')->with('success', 'Data member berhasil diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $status)
    {
        Member::where('id_member', '=', $id)->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Status member berhasil diubah');
    }
}
