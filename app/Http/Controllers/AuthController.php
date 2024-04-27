<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $page = 'auth';

        if (Auth::check()) {
            if (auth()->user()->status == 'nonaktif') {
                Auth::logout();
                return redirect()->route('login')->withInput()->with('error', 'Akun anda sudah nonaktif');
            } else if (auth()->user()->role == 'administrator') {
                return redirect()->route('admin.dashboard');
            } else if (auth()->user()->role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            }
        } else {
            return view('auth.login', compact('page'));
        }
    }

    public function login(Request $request)
    {
        // if (auth()->user() != null) {
        //     if (auth()->user()->role == 'administrator') {
        //         return redirect()->route('admin.dashboard');
        //     } else {
        //         return redirect()->route('petugas.dashboard');
        //     }
        // }

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($data)) {
            if (auth()->user()->role == 'administrator') {
                if (auth()->user()->status == 'nonaktif') {
                    Auth::logout();
                    return redirect()->back()->withInput()->with('error', 'Akun anda sudah nonaktif');
                } else {
                    return redirect()->route('admin.dashboard');
                }
            } else {
                if (auth()->user()->status == 'nonaktif') {
                    Auth::logout();
                    return redirect()->back()->withInput()->with('error', 'Akun anda sudah nonaktif');
                } else {
                    return redirect()->route('petugas.dashboard');
                }
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
