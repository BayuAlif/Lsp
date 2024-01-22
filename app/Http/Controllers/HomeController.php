<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\laporan;

class HomeController extends Controller
{
    public function index()
    {

        return view('Home.Dashboard');
    }

    public function form(Request $request)
    {
        // dd($request->all());
        //menyimpan data foto menuju storage
        $photoPath = $request->file('photo')->store('public/img');
        $photoFileName = basename($photoPath);

        $validatedData = $request->validate([
            'emails' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:12'],
            'name_report' => ['required', 'string', 'max:255'],
            'photo' => ['image'],
            'content' => ['required', 'string', 'max:2500'],
        ]);

        try {
            DB::table('laporan')->insert([
                'emails' => $validatedData['emails'],
                'subject' => $validatedData['subject'],
                'name_report' => $validatedData['name_report'],
                'photo' => $photoFileName,
                'content' => $validatedData['content'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect('/home')->with('success', 'Laporan Terkirim');
        } catch (\Exception $e) {
            // Mengatasi kesalahan dan mengembalikan ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->with('error', 'Gagal mengirim laporan. Silakan coba lagi.');
        }
    }

    public function login()
    {
        return view('Home.Login');
    }

    public function SendLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }
        return view('gagal');
    }

    public function ViewAdmin()
    {
        $userId = Auth::id();

        //mengambil data dari tabel laporan
        $laporan = laporan::all();
        return view('Home.Admin', compact('laporan'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Clear the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    public function galery()
    {
        return view('Home.galery');
    }
}
