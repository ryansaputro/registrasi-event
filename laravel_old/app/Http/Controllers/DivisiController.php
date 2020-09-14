<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\Divisi; //Use Model Divisi
use DataTables; //Use Datatable Yajra server side 
use Carbon\Carbon; //Use Time created_at & updated_at
use Illuminate\Support\Facades\Session;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::get('group_name') == "admin") {
            return view('pages.masterdata.data_divisi.index');
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
        $model = new Divisi();
        return view('pages.masterdata.data_divisi.f_tambah_divisi',compact('model')); //compact = fungsi passing data
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
            'id_divisi'    => 'required',
            'nama_divisi'  => 'required',
        ],$messages);
        
        $data = [
            'id_divisi'    => $request->id_divisi,
            'nama_divisi'  => $request->nama_divisi
        ];

        // insert data ke table ref_divisi
        $model = Divisi::insert($data);
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
        $get = Divisi::query()->where('id_divisi',$id)->first(); //menentukan apakah id nya ada/tidak
        return view('pages.masterdata.data_divisi.f_detail_divisi', compact('get')); //compact = fungsi passing data
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
        $model = Divisi::query()->where('id_divisi',$id)->first(); //menentukan apakah id nya ada/tidak
        return view('pages.masterdata.data_divisi.f_tambah_divisi', compact('model')); //compact = fungsi passing data
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
            'id_divisi'    => 'required',
            'nama_divisi'  => 'required',
        ],$messages);
        
        $data = [
            'id_divisi'    => $request->id_divisi,
            'nama_divisi'  => $request->nama_divisi
        ];

        $model = Divisi::query()->where('id_divisi', $id)->update($data);
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
        $anggota = Divisi::where('id_divisi',$id);
        $anggota->delete();
    }

    public function dataTable()
    {
        $model = DB::table('ref_divisi')->get();
        return DataTables::of($model)
            ->addColumn('action', function ($model) {
                return view('layouts_app._action', [
                    'model' => $model,
                    'url_show' => route('divisi.show', $model->id_divisi),
                    'url_edit' => route('divisi.edit', $model->id_divisi),
                    'url_destroy' => route('divisi.destroy', $model->id_divisi)
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }
}
