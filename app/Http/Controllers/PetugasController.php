<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = 'main';
        $title = 'petugas';

        $search = $request->query('search', '');

        if ($search == '') {
            $data = User::where('status', '=', 'aktif')->where('role', '=', 'petugas')->get();
        } else {
            $data = USer::where('id', 'LIKE', $search)
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('status', 'LIKE', $search)
                ->where('role', '=', 'petugas')
                ->get();
        }

        if ($data->isEmpty()) {
            $message = 'Data tidak ada';
        } else {
            $message = '';
        }

        return view('admin.petugas.index', compact('page', 'title', 'data', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'main';
        $title = 'petugas';

        return view('admin.petugas.create', compact('page', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'email' => 'required|email',
                'password' => 'required|regex:/[0-9]/'
            ],
            [
                'nama.required' => 'Kolom ini harus diisi',
                'email.required' => 'Kolom ini harus diisi',
                'password.required' => 'Kolom ini harus diisi',
                'email.email' => 'Email tidak valid',
                'password.regex' => 'Password harus berisi angka dan huruf'
            ]
        );

        $user = User::where('email', '=', $request->email)->get()->first();

        if ($user != null) {
            return redirect()->back()->withInput()->with('error', 'Email sudah ada');
        }

        $user = new User();
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'petugas';
        $user->status = 'aktif';
        $user->save();

        return redirect()->route('admin.petugas')->with('success', 'Data petugas berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = 'main';
        $title = 'petugas';

        $petugas = User::findOrFail($id);

        return view('admin.petugas.edit', compact('page', 'title', 'petugas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama' => 'required',
                'email' => 'required|email',
                'password' => 'nullable|regex:/[0-9]/'
            ],
            [
                'nama.required' => 'Kolom ini harus diisi',
                'email.required' => 'Kolom ini harus diisi',
                'password.required' => 'Kolom ini harus diisi',
                'email.email' => 'Email tidak valid',
                'password.regex' => 'Password harus berisi angka dan huruf'
            ]
        );

        $user = User::where('email', '=', $request->email)->where('id', '!=', $id)->get()->first();

        if ($user != null) {
            return redirect()->back()->with('error', 'Email sudah ada');
        }

        if ($request->password) {
            User::findOrFail($id)->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } else {
            User::findOrFail($id)->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('admin.petugas')->with('success', 'Data petugas berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $status)
    {
        User::where('id', '=', $id)->update([
            'status' => $status
        ]);

        return redirect()->back()->with('success', 'Status petugas berhasil diubah');
    }
}
