<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\Anggota; //Use Model Anggota
use Illuminate\Support\Facades\Session;
use Auth;
use Carbon\Carbon;
use Artisan;

class SigninController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest:anggota')->except('logout');
    // }

    public function getLogin()
    {
        return view('pages.auth.login');   
    }

    public function postLogin(Request $request)
    {
        //custom notif validasi
        $messages = [
            'required'  => ':attribute harus di isi !!!',
            'min'       => ':attribute harus diisi minimal :min karakter !!!',
            'max'       => ':attribute harus diisi maksimal :max karakter !!!',
        ];
        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ],$messages);

        // Passwordnya pake bcrypt otomatis
        $credential = [
            'email' => $request->email, 
            'password' => $request->password,
            'id_status_aktif' => '1'
        ];

        //fungsi guard berada pada file config/auth custom sendiri
        if (Auth::guard('anggota')->attempt($credential)) 
        {
            $data = Anggota::query()->where('email',$request->email)->first();
            $id = $data->id_anggota;
            
            $get_group = DB::table('zmember')
                ->join('zgroup','zmember.group_id','=','zgroup.group_id')
                ->select('zmember.*','zgroup.group_name')
                ->where('zmember.id_anggota',$id)->first();

            Session::put('data',$data);
            Session::put('login', true);
            Session::put('group_name',$get_group->group_name);

            return redirect()->intended('/dashboard');

        } else {
            return redirect()->back()->withInput($request->only('email','remember'));
        }
    }
    
    public function logout()
    {
        if (Auth::guard('anggota')->check()) {
            Auth::guard('anggota')->logout();
            Session::flush();
            Auth::logout();
            Session::forget('data');
        } 
            Auth::logout();
            Session::flush();
            Session::forget('data');
            Session::forget('login');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');

        return redirect('/');
    }
}
