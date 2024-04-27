<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $page = 'main';
        $title = 'dashboard';

        $data = User::findOrFail(auth()->user()->id);

        if (auth()->user()->role == 'administrator') {
            return view('admin.profil.index', compact('page', 'title', 'data'));
        } else {
            return view('petugas.profil.index', compact('page', 'title', 'data'));
        }
    }

    public function update(Request $request)
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

        $user = User::where('email', '=', $request->email)->where('id', '!=', auth()->user()->id)->get()->first();

        if ($user != null) {
            return redirect()->back()->with('error', 'Email sudah ada');
        }

        if ($request->password) {
            User::findOrFail(auth()->user()->id)->update([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } else {
            User::findOrFail(auth()->user()->id)->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
