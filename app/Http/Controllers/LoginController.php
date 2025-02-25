<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('auth.login');
    }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|max:10'
        ]);

        if (Auth::guard('anggota')->check() || Auth::guard('user')->check()) {
            return back()->with('loginFailed', 'Udah login BNGG!!');
        }

        if (Auth::guard('anggota')->attempt($credentials)) {
            return redirect()->intended('/listkegiatan');
        }

        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginFailed', 'Login Failed');

    }

    public function logout(Request $request)
    {

        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();

        } else {
            Auth::guard('anggota')->logout();
        }

        return redirect('login');

    }

}
