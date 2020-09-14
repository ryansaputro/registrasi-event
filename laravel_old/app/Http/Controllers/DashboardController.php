<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $cek = Session::get('data')['id_anggota'] != null ? Session::get('data')['id_anggota'] : 'kosong';
        if(($cek == 'kosong')){
            return redirect('login')->with('alert','Kamu harus login dulu');
        }
        else{
            return view('/dashboard');
        }
    }
}
