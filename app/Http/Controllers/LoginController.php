<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function viewLogin()
    {
        return view('layout.v_login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Langsung jalankan query untuk admin
        $admin = DB::table('admin')->where('username', $request->username)->first();

        if (!$admin) {
            return view('layout.v_login')->with(['fail'=> 'Admin not found']);
        }

        if ($admin->password !== $request->password) {
            return view('layout.v_login')->with(['fail'=> 'Wrong Password']);
        }

        session(['user' => $admin]);

        return redirect('/transaksi');
    }
    public function logout(Request $request)
    {

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}