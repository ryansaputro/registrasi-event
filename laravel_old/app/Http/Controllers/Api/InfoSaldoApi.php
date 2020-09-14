<?php
/**
 * @author ryan saputro
 * @email ryansaputro52@gmail.com
 * @create date 2019-05-21 13:10:48
 * @modify date 2019-05-21 13:10:48
 * @desc Provide data SALDO HUTANG And SALDO PINJAMAN for Android member by NIK
 */
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; //karena folder dirubah tambah script ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use Carbon\Carbon; //Use Time
use App\Models\Saldo; //Use Model Saldo


class InfoSaldoApi extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_simpanan(Request $request)
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

            $model = Saldo::query()
            ->join('anggota','simpanan_saldo.id_anggota','=','anggota.id_anggota')
            ->select(
                'anggota.*',
                'simpanan_saldo.*')
            ->where('anggota.id_anggota',$id_anggota)->get();
            
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_hutang(Request $request)
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
            $model = DB::table('transaksi_angsuran')
                    ->select('*')
                    ->where('id_anggota',$get->id_anggota)
                    ->get();
                    
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
        
    }}
