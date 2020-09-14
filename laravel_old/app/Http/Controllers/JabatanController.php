<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\Jabatan; //Use Model Jabatan
use DataTables; //Use Datatable Yajra server side 
use Carbon\Carbon; //Use Time created_at & updated_at
use Illuminate\Support\Facades\Session;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::get('group_name') == "admin") {
            return view('pages.masterdata.data_jabatan.index');
        } else {
            return redirect()->intended('/dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $model = new Jabatan();
        return view('pages.masterdata.data_jabatan.f_tambah_jabatan',compact('model')); //compact = fungsi passing data
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //custom notif validasi
        $messages = [
            'required'  => ':attribute harus di isi !!!',
            'min'       => ':attribute harus diisi minimal :min karakter !!!',
            'max'       => ':attribute harus diisi maksimal :max karakter !!!',
        ];
        // Terima Data request kemudian validasi dulu
        $this->validate($request, [
            'id_jabatan'    => 'required',
            'nama_jabatan'  => 'required',
        ],$messages);
        
        $data = [
            'id_jabatan'    => $request->id_jabatan,
            'nama_jabatan'  => $request->nama_jabatan
        ];

        // insert data ke table ref_divisi
        $model = Jabatan::insert($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $get = Jabatan::query()->where('id_jabatan',$id)->first(); //menentukan apakah id nya ada/tidak
        return view('pages.masterdata.data_jabatan.f_detail_jabatan', compact('get')); //compact = fungsi passing data
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Jabatan::query()->where('id_jabatan',$id)->first(); //menentukan apakah id nya ada/tidak
        return view('pages.masterdata.data_jabatan.f_tambah_jabatan', compact('model')); //compact = fungsi passing data
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
        //custom notif validasi
        $messages = [
            'required'  => ':attribute harus di isi !!!',
            'min'       => ':attribute harus diisi minimal :min karakter !!!',
            'max'       => ':attribute harus diisi maksimal :max karakter !!!',
        ];
        // Terima Data request kemudian validasi dulu
        $this->validate($request, [
            'id_jabatan'    => 'required',
            'nama_jabatan'  => 'required',
        ],$messages);
        
        $data = [
            'id_jabatan'    => $request->id_jabatan,
            'nama_jabatan'  => $request->nama_jabatan
        ];

        $model = Jabatan::query()->where('id_jabatan', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::where('id_jabatan',$id);
        $jabatan->delete();
    }

    public function dataTable()
    {
        $model = DB::table('ref_jabatan')->get();
        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view('layouts_app._action', [
                    'model' => $model,
                    'url_show' => route('jabatan.show', $model->id_jabatan),
                    'url_edit' => route('jabatan.edit', $model->id_jabatan),
                    'url_destroy' => route('jabatan.destroy', $model->id_jabatan)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
