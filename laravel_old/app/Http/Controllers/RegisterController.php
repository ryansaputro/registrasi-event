<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\User; //Use Model User
use App\Models\Roles; //Use Model User
use Carbon\Carbon; //Use Time created_at & updated_at

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('pages.register.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // custom notif validasi
        $messages = [
            'required' => ':attribute harus di isi !!!',
            'min' => ':attribute harus diisi minimal :min karakter !!!',
            'max' => ':attribute harus diisi maksimal :max karakter !!!',
            'alpha' => ':attribute harus diisi dengan huruf !!!'
        ];
        // fungsi validasi
        $this->validate($request,[
            'nik' => 'required',
            'nama' => 'required|min:5',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:6',
        ],$messages);

        $get_id = Roles::query()->select('id')->where('namaRoles','anggota')->first();
        $roles_id = $get_id->id; 

        // insert data ke table pegawai
        DB::table('users')->insert([
            'roles_id' => $roles_id,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        // alihkan halaman ke view
        return redirect('/register');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
