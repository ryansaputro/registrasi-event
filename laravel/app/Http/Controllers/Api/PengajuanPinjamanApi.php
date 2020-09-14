<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; //karena folder dirubah tambah script ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\PengajuanPinjaman; //Use Model Pinjaman
use Carbon\Carbon; //Use Time

class PengajuanPinjamanApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $cek = DB::table('anggota')->where('nik',$request->nik);
        $cari_nik = $cek->get();

        if (count($cari_nik) == 0) {
            $res["code"]    = "204";
            $res['message'] = "Failed!";
            return response($res);
        } else {
            $get = $cek->first();
            $id_anggota = $get->id_anggota;

            $cek_pengajuan = DB::table('pengajuan_pinjaman')->select('no_pengajuan')->get();
            foreach ($cek_pengajuan as $key => $value) {
                foreach ($value as $k => $val) {
                    $data[]=substr($val,2);
                }
            }
            if (count($cek_pengajuan) == 0) {
                $no_pengajuan = 'PE1';
            } else {
                $no = max($data);
                $no_pengajuan = 'PE'.($no+1);
            }

            $pengajuan = [
                'no_pengajuan'   => $no_pengajuan,
                'id_anggota'     => $id_anggota,
                'tgl_pengajuan'  => Carbon::now('Asia/Jakarta'),
                'status_approve' => '0',
                'jumlah_pinjaman'=> $request->jumlah_pinjaman,
                'tenor_pinjaman' => $request->tenor_pinjaman,
            ];

            // insert data ke table ref_divisi
            $model = DB::table('pengajuan_pinjaman')->insert($pengajuan);

            if($model){
                $res["code"]    = "200";
                $res['message'] = "Success!";
                return response($res);
            } else {
                $res["code"]    = "500";
                $res['message'] = "Error!";
                return response($res);
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cek = DB::table('anggota')->where('nik',$request->nik);
        $cari_nik = $cek->get();

        if (count($cari_nik) == 0) {
            $res["code"]    = "204";
            $res['message'] = "Failed!";
            return response($res);
        } else {
            $get = $cek->first();
            $id_anggota = $get->id_anggota;

            $model = DB::table('pengajuan_pinjaman')
                ->join('anggota','pengajuan_pinjaman.id_anggota','=','anggota.id_anggota')
                ->select(
                    'anggota.nik',
                    'pengajuan_pinjaman.*')
                ->where('pengajuan_pinjaman.id_anggota',$id_anggota)->get();
            
            if($model != NULL){
                $res["code"]    = "200";
                $res['message'] = "Success!";
                $res['value']   = $model;
                return response($res);
            } else {
                $res["code"]    = "500";
                $res['message'] = "Failed!";
                return response($res);
            }
        }
        
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
    public function update(Request $request)
    {
        $cek = DB::table('pengajuan_pinjaman')->where('no_pengajuan',$request->no_pengajuan);
        $cari_no = $cek->get();

        if (count($cari_no) == 0) {
            $res["code"]    = "204";
            $res['message'] = "Failed!";
            return response($res);
        } else {
            // $get = $cek->first();

            $pengajuan = [
                'jumlah_pinjaman'=> $request->jumlah_pinjaman,
                'tenor_pinjaman' => $request->tenor_pinjaman,
            ];

            // insert data ke table
            $model = $cek->update($pengajuan);

            if($model){
                $res["code"]    = "200";
                $res['message'] = "Success!";
                return response($res);
            } else {
                $res["code"]    = "500";
                $res['message'] = "Error!";
                return response($res);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $nik            = $request->nik;
        $ket_pembatalan = $request->ket_pembatalan;
        $no_pengajuan   = $request->no_pengajuan;

        $cek = DB::table('anggota')->where('nik', $nik)->first();
        $id_anggota = $cek->id_anggota;
        $data = [
            'batal_oleh'     => $id_anggota,
            'status_approve' => '2',
            'ket_pembatalan' => $ket_pembatalan,
            'tgl_pembatalan' => Carbon::now('Asia/Jakarta'),
        ];

        $model = DB::table('pengajuan_pinjaman')->where('no_pengajuan', $no_pengajuan)->update($data);
        
        if($model){
            $res["code"]    = "200";
            $res['message'] = "Success!";
            return response($res);
        } else {
            $res["code"]    = "500";
            $res['message'] = "Error!";
            return response($res);
        }
    }
}
