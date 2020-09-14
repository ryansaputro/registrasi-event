<?php

/**
 * @author ryan saputro
 * @email ryansaputro52@gmail.com
 * @create date 2020-01-10 09:59:21
 * @modify date 2020-01-10 09:59:21
 * @desc 
 * 
 * menu dashboard eo dan chart dilakukan di 
 * controller ini
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Charts\DashboardChart;
use App\Charts\DaftarEventChart;
use App\Charts\JumlahPesertaEventChart;
use App\Charts\KomunitasChart;
use App\Charts\JumlahJerseyChart;
use App\Charts\PesertaEventByGenderChart;
use App\Charts\PembayaranEventChart;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\RegistrasiEoModel;
use App\Models\RegistrasiEventModel;
use DB;

class DashboardxController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    { 
        //get data from ajax
        $api = url('/dashboard/event');
        $apiPst = url('/dashboard/gender');
        $apiPby = url('/dashboard/bayar');
        $apiKom = url('/dashboard/komunitas');
        $apiJersey = url('/dashboard/jersey');
        
        
        //get data event per eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Auth::user()->ID)->value('id');
        //ambil data jika di set
        if(isset($request->events)){
            $id_event = $request->events;
            $cek = DB::table('registrasi_event')->select('id')->where('id_eo', $id_eo)->where('status', '<>', '0')->where('id', $id_event)->value('id');
            $cek_peserta = DB::table('registrasi_peserta_event')->select('id')->where('id_event', $id_event)->value('id');
            $bayar = new PembayaranEventChart;
            $bayar->minimalist(true);
            if($cek == null){
                //tidak ada event
                $bayar->labels(['Tidak Ada Event'])->load($apiPby);
            }else{
                if($cek_peserta == null){
                    //ada event but belum ada yang daftar
                    $bayar->labels(['Belum Ada'])->load($apiPby);
                    //$bayar->title(['Hiya'])->load($apiPby);
                }else{
                    //sudah ada yg atau belum bayar
                    $bayar->labels(['Sudah Bayar', 'Belum Bayar'])->load($apiPby);
                }
            }
        }else{
            //ambil data jika di tidak set
            $cek = DB::table('registrasi_event')->select('id')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai', 'asc')->limit(1)->value('id');
            $bayar = new PembayaranEventChart;
            $bayar->minimalist(true);
            if($cek == null){
                //tidak ada event
                $id_event = 0;
                $bayar->labels(['Tidak Ada Event'])->load($apiPby);
            }else{
                $id_event = DB::table('registrasi_event')->select('*')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai', 'asc')->limit(1)->value('id');
                $cek_peserta = DB::table('registrasi_peserta_event')->select('id')->where('id_event', $id_event)->value('id');
                if($cek_peserta == null){
                    //belum ada yang daftar
                    $id_event = DB::table('registrasi_event')->select('*')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai', 'asc')->limit(1)->value('id');
                    $bayar->labels(['Belum Ada'])->load($apiPby);
                }else{
                    //cek ada yg sudah atau belum bayar
                    $id_event = DB::table('registrasi_event')->select('*')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai', 'asc')->limit(1)->value('id');
                    $bayar->labels(['Sudah Bayar', 'Belum Bayar'])->load($apiPby);
                }
                
            }
        }
 
        $dataEvent = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->where('registrasi_eo.id', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'ASC')
                ->groupBy('registrasi_event.id');

        $dataKomunitas = DB::table('registrasi_peserta_event')
                ->select('*')
                ->where('id_event', '=', $id_event)
                ->orderBy('komunitas', 'ASC')
                ->groupBy('komunitas');
        
        $dataJersey = DB::table('registrasi_peserta_event')
                ->select('size_jersey')
                ->where('id_event', $id_event)
                ->orderBy('size_jersey', 'ASC')
                ->groupBy('size_jersey');
                
        $cek_jersey = app('db')->connection()->select(" 
        SELECT COUNT(id) as count 
        FROM registrasi_peserta_event 
        WHERE id_event = $id_event ");

        $ceks_jersey = DB::table('registrasi_peserta_event')->select('*', DB::raw('COUNT(size_jersey) AS jumlah_jersey'))->where('id_event', $id_event)->groupBy('size_jersey')->pluck('size_jersey')->toArray();
        if($ceks_jersey == null ){
            $ceks_jersey = array("XS", "S", "M", "L", "XL", "XXL");
            //dd($jerseyku);
        }else{
            $jerseyku = $ceks_jersey;
        }
        
        $dtEvent = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->where('registrasi_eo.id', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'ASC')
                ->groupBy('registrasi_event.id')
                ->get();

        $member = $dataEvent->where('registrasi_event.id', $id_event)->pluck('nama_event')->toArray(); //ganti
        $cek_komunitas = app('db')->connection()->select(" 
        SELECT COUNT(id) as count 
        FROM registrasi_peserta_event 
        WHERE id_event = $id_event ");
        
        if($cek_komunitas[0]->count == 0){
            //echo "sini";
            $komunitasku = array("Belum Ada");
        }else{
            $komunitasku = $dataKomunitas->pluck('komunitas')->toArray();
        }
        //dd($komunitasku);
        //pembuatan label chart event berlangsung
        $chart = new DaftarEventChart;
        $data =$dataEvent->get();
        $gender = new PesertaEventByGenderChart;
        //$bayar = new PembayaranEventChart;
        $komunitas =  new KomunitasChart;
        $jersey = new JumlahJerseyChart;
        $chart->labels($member)->load($api);
        $gender->minimalist(true);
        $gender->labels(['Laki-laki', 'Perempuan'])->load($apiPst);
        //$bayar->labels(['Belum Bayar', 'Sudah Bayar'])->load($apiPby);
        $jersey->minimalist(true);
        $komunitas->labels($komunitasku)->load($apiKom);
        $jersey->labels($ceks_jersey)->load($apiJersey);
        
        //checking session
        $cek = Session::get('data')['id_anggota'] != null ? Session::get('data')['id_anggota'] : 'kosong';
        
        if(($cek == 'kosong')){
            return redirect('login')->with('alert','Kamu harus login dulu');
        }
        else{
            return view('/dashboard', compact('dtEvent', 'chart', 'data', 'gender','bayar', 'komunitas', 'jersey', 'id_event'));
        }
    }

    public function EventAjax(Request $request)
    {
        //get data event dan peserta per eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        $event =  isset($request->event);
        if($event){
            $id_et= $request->event;
            //echo $id_et;
        }else{
            $cek = DB::table('registrasi_event')->select('*')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('id', 'DESC')->get();
            if(count($cek) > 0){
                $id_et = DB::table('registrasi_event')->select('*')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('id', 'DESC')->value('id');    
            }else{
                $id_et = '';
            }
            //echo $id_et;
        }
        
        //get data peserta dari event
        $dataEvent = 
        app('db')->connection()->select(" 
                SELECT COUNT(id_member) as count 
                FROM registrasi_peserta_event 
                WHERE id_event = '$id_et' AND no_unik != '' GROUP BY status_pembayaran ASC ");
        //dd($dataEvent);
        if($dataEvent == null){
            $hm = "null";
            $data = array();
        }else{
            $hm =  "tidak null";
            $data= array($dataEvent[0]->count);
        }
        
        //pembuatan chart
        $chart = new DaftarEventChart;
        
        //setting chart
        $chart->labels(['Jan', 'Feb', 'Mar']);
        $chart->dataset('Daftar Peserta', 'bar', $data)->options([
                    'fill' => 'true',
                    'borderColor' => '#d91d48',
                ]);


        return $chart->api();
    }

    public function GenderAjax(Request $request)
    {
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get event
        $event = RegistrasiEventModel::where('id_eo', $id_eo)->where('status', '1')->first();
        
        //get data id member untuk di filter di user meta
        $regisMember = DB::table('registrasi_event')
                ->select('registrasi_peserta_event.id_member')
                ->join('registrasi_peserta_event', 'registrasi_event.id', '=', 'registrasi_peserta_event.id_event')
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0');
        
        //checking jika meng klik tombol cari
        $event =  isset($request->event) ? $request->event : 'xxx';
        
        //filter in db
        if($event != 'xxx'){
            $regisMember->where('id_event', $event);
        }

        //get user id dan di jadikan array
        $user_id = $regisMember->pluck('id_member')->toArray();
        $id_member =  implode(', ', $user_id);
        
        //get user meta
        $users = UserMeta::select(\DB::raw("COUNT(user_id) as count"), 'meta_value')
                    ->whereIn('meta_value', ['Laki-Laki', 'Perempuan'])
                    ->whereIn('user_id', $user_id)
                    ->groupBy("meta_value")
                    ->pluck('count', 'meta_value');

        //membuat chart
        $gender = new PesertaEventByGenderChart;
  
        //setting jenis chart dan labelnya
        // $gender->dataset(['Laki-laki', 'Perempuan']);
        $gender->dataset('Gender Event '.$id_member, 'doughnut', $users)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ])
                ->backgroundColor(collect(['#7158e2','#3ae374']));
                
  
        return $gender->api();
    }
    
    public function PembayaranAjax(Request $request)
    {
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get event
        $event = RegistrasiEventModel::where('id_eo', $id_eo)->where('status', '1')->first();
        
        //get data id member untuk di filter di user meta
        $regisMember = DB::table('registrasi_event')
                ->select('registrasi_peserta_event.id_member')
                ->join('registrasi_peserta_event', 'registrasi_event.id', '=', 'registrasi_peserta_event.id_event')
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0');
        
        //checking jika meng klik tombol cari
        $event =  isset($request->event) ? $request->event : 'xxx';
        
        //filter in db
        if($event != 'xxx'){
            $regisMember->where('id_event', $event);
        }
        //get user id dan di jadikan array
        if($event == 0){
            //jika ga da event  
            $user_id[] = "0";
            $id_member = "0";
            $us[] = "Kosong";
        }else{
            $user_id = $regisMember->pluck('id_member')->toArray();
            if($user_id == null){
                //ada event but belum ada transaksi atau belum ada yang daftar;
                $us = array();
            }else{
                //ada event dan sudah ada yang daftar, mencari yang sudah atau belum bayar;
                $id_member =  implode(', ', $user_id);
                $users = app('db')->connection()->select(" 
                SELECT COUNT(id_member) as count 
                FROM registrasi_peserta_event 
                WHERE id_member IN ($id_member) AND id_event = $event AND no_unik != '' GROUP BY status_pembayaran ASC ");
                
                foreach($users as $key => $value){
                    foreach($value as $key => $val){
                        $us[] = $val;
                    }
                }
            }
        }
        
        //membuat chart
        $bayar = new PembayaranEventChart;
  
        //setting jenis chart dan labelnya
        $bayar->dataset('Pembayaran Event '.$event, 'pie', $us)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ])
                ->backgroundColor(collect(['#7158e2','#3ae374']));
  
        return $bayar->api();
    }
    
    public function KomunitasAjax(Request $request)
    {
        //get data event dan peserta per eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        $cek = DB::table('registrasi_event')->select('id')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai')->value('id');
        if($cek == null){
            $id_ev = 0;
        }else{
            $id_ev = $cek;
        }
        $event =  isset($request->event) ? $request->event : $id_ev;
        
        //cetak judul daftar event
        if($cek == null){
            $id_event = 0;
            $judul = "Tidak Ada Event";
        }else{
            $id_event = DB::table('registrasi_event')->select('id')->where('id_eo', $id_eo)->orderBy('tanggal_mulai', 'asc')->value('id');
            $nama_event =  DB::table('registrasi_event')->select('nama_event')->where('id', $event)->value('nama_event');
            $judul = "Data Komunitas Event ".$nama_event;
        }
        
        //jumlah data event
        $dataEvent = app('db')->connection()->select(" 
        SELECT COUNT(id) as count 
        FROM registrasi_peserta_event 
        WHERE id_event = $event AND no_unik != '' GROUP BY komunitas ASC");
        
        //dd($dataEvent);
        if($dataEvent == null){
            $us[]="kosong";
        }else{
            foreach($dataEvent as $key => $value){
                foreach($value as $key => $val){
                    $us[] = $val;   
                }
            }
        }
        
        //pembuatan chart
        $komunitas = new KomunitasChart;
  
        //setting chart
        $komunitas->dataset($judul, 'bar', $us)->options([
                    'fill' => 'true',
                    'borderColor' => '#61C123',
                ]);


        return $komunitas->api();
    }
    
    public function JerseyAjax(Request $request)
    {
        //$apiJersey = url('/dashboard/jersey');
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        $event =  isset($request->event);
        if($event){
            $id_et= $request->event;
            // $id_et= "a";
        }else{
            $id_et = DB::table('registrasi_event')->select('id')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai', 'asc')->limit(1)->value('id');
            // $id_et = "b";
        }
        // dd($id_et);
        // //get event
        // $event = RegistrasiEventModel::where('id_eo', $id_eo)->where('status', '1')->first();
        // dd($request->event);
        //get data id member untuk di filter di user meta
        $regisMember = DB::table('registrasi_event')
                ->select('registrasi_peserta_event.size_jersey', DB::raw('COUNT(size_jersey) AS jumlah_jersey'))
                ->join('registrasi_peserta_event', 'registrasi_event.id', '=', 'registrasi_peserta_event.id_event')
                ->where('registrasi_event.status', '<>', '0')
                ->where('registrasi_event.id', $id_et)
                ->groupBy('registrasi_peserta_event.size_jersey');
                
        $jrsey = $regisMember->pluck('jumlah_jersey');
        // dd($jrsey);
        // $jrsey = $regisMember->pluck('jumlah_jersey')->toArray();
        //checking jika meng klik tombol cari
        // $event =  isset($request->event) ? $request->event : 'xxx';
        
        //filter in db
        // if($event != 'xxx'){
        //     $regisMember->where('id_event', $event);
        // }
        
        // $cek_jersey = app('db')->connection()->select(" 
        // SELECT COUNT(id) as count 
        // FROM registrasi_peserta_event 
        // WHERE id_event = $event AND no_unik != '' ");
        
        // //get user id dan di jadikan array
        // $user_id = $regisMember->pluck('id_member')->toArray();
        // $id_member =  implode(', ', $user_id);
        
        // $users = app('db')->connection()->select(" 
        // SELECT COUNT(ID) as count
        // FROM registrasi_peserta_event 
        // WHERE id_event = $event AND no_unik != '' GROUP BY size_jersey ASC");
        
        // if($cek_jersey[0]->count == 0 ){
        //     $us[] = array("kosongcuyx");
        // }else{
        //     foreach($users as $key => $value){
        //         foreach($value as $key => $val){
        //             $us[] = $val;   
        //         }
        //     }
        //     //$us[] = $users[0]->size_jersey;
        // }
        
        //membuat chart
        $jersey = new JumlahJerseyChart;
        
        //setting jenis chart dan labelnya
        $jersey->dataset('Jersey Event xxx', 'pie', $jrsey)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ])
                ->backgroundColor(collect(['#7158e2','#3ae374']));
                
        //echo json_encode(array("status"=>"200","user"=>$us));
        return $jersey->api();
    }
}
