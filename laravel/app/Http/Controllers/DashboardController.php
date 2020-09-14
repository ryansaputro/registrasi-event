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
use App\Models\RegistrasiPesertaEventModel;
use DB;
use Charts;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {   
        //get data event per eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Auth::user()->ID)->value('id');

        if(isset($request->events)){
            $id_event = $request->events;
        }else{
            $id_event = DB::table('registrasi_event')->select('*')->where('id_eo', $id_eo)->where('status', '<>', '0')->orderBy('tanggal_mulai', 'asc')->limit(1)->value('id');
        }
        
        // $id_event = 1;
        /**
         * data jumlah event
         */
        $dtEvent = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->where('registrasi_eo.id', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'ASC')
                ->groupBy('registrasi_event.id')
                ->get();

        $dataKomunitas = DB::table('registrasi_peserta_event')
                ->select('*')
                ->where('id_event', '=', $id_event)
                ->orderBy('komunitas', 'ASC')
                ->get();

        $chart = Charts::database($dataKomunitas, 'bar', 'google')
			      ->title("Graphic")
			      ->elementLabel("Peserta Registrasi")
                  ->responsive(true)
                  ->colors(['#d91d48'])
                  ->yAxisTitle('Jumlah Peserta')
                  ->groupByMonth(date('Y'), true)
                  ->template('green-material')
                  ->language('id');
                //   ->settings();
        // dd($chart);
        /**
         * data gender
         */   

         //get data id member untuk di filter di user meta
        $regisMember = DB::table('registrasi_event')
                ->select('registrasi_peserta_event.id_member')
                ->join('registrasi_peserta_event', 'registrasi_event.id', '=', 'registrasi_peserta_event.id_event')
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.id', '=', $id_event)
                ->where('registrasi_event.status', '<>', '0');
        
        //get user id dan di jadikan array
        $user_id = $regisMember->pluck('id_member')->toArray();
        $id_member =  implode(', ', $user_id);
        
        //get user meta
        $perempuan = UserMeta::select(\DB::raw("COUNT(user_id) as count"), 'meta_value')
                    ->whereIn('meta_value', ['Perempuan'])
                    ->whereIn('user_id', $user_id)
                    ->groupBy("meta_value")
                    ->value('count');
        //get user meta
        $laki = UserMeta::select(\DB::raw("COUNT(user_id) as count"), 'meta_value')
                    ->whereIn('meta_value', ['Laki-Laki'])
                    ->whereIn('user_id', $user_id)
                    ->groupBy("meta_value")
                    ->value('count');

        $gender =   Charts::create('donut', 'google')
                    ->title('Graphic')
                    ->labels(['Perempuan: '.$perempuan. ' orang', 'Laki-Laki: '.$laki. ' orang'])
                    ->values([$perempuan == null ? 0 : $perempuan,$laki == null ? 0 : $laki])
                    ->dimensions(1000,500)
                    ->colors(['#FF8E00', '#2874AF'])
                    ->responsive(true);

        /**
         * data bayar
         */ 

                 $regisMember = DB::table('registrasi_event')
                ->select('registrasi_peserta_event.id_member')
                ->join('registrasi_peserta_event', 'registrasi_event.id', '=', 'registrasi_peserta_event.id_event')
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0');
        
        //get user id dan di jadikan array
        $user_id = $regisMember->pluck('id_member')->toArray();
        $id_member =  implode(', ', $user_id);
        
        //get user meta
        $bayar = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('status_pembayaran', '1')
                    ->where('id_event', $id_event)
                    ->value('count');
        //get user meta
        $blm = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('status_pembayaran', '0')
                    ->where('id_event', $id_event)
                    ->value('count');

        $bayarChart =   Charts::create('donut', 'google')
                    ->title('Graphic')
                    ->labels(['Bayar: '.$bayar.' orang', 'Belum: '.$blm.' orang'])
                    ->values([$bayar == null ? 0 : $bayar,$blm == null ? 0 : $blm])
                    ->dimensions(1000,500)
                    ->colors(['#3BCB45', '#DB1C4A'])
                    ->responsive(true);

        /**
         * data jersey
         */ 

        $regisMember = DB::table('registrasi_event')
                ->select('registrasi_peserta_event.id_member')
                ->join('registrasi_peserta_event', 'registrasi_event.id', '=', 'registrasi_peserta_event.id_event')
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0');
        
        //get user id dan di jadikan array
        $user_id = $regisMember->pluck('id_member')->toArray();
        $id_member =  implode(', ', $user_id);
        
        //get jersey
        $xs = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('size_jersey', 'XS')
                    ->where('id_event', $id_event)
                    ->value('count');
        //get jersey
        $s = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('size_jersey', 'S')
                    ->where('id_event', $id_event)
                    ->value('count');

        //get jersey
        $m = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('size_jersey', 'M')
                    ->where('id_event', $id_event)
                    ->value('count');

        //get jersey
        $l = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('size_jersey', 'L')
                    ->where('id_event', $id_event)
                    ->value('count');

        //get jersey
        $xl = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('size_jersey', 'XL')
                    ->where('id_event', $id_event)
                    ->value('count');

        //get jersey
        $xxl = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(id) as count"))->where('size_jersey', 'XXL')
                    ->where('id_event', $id_event)
                    ->value('count');

        $jersey =   Charts::create('bar', 'google')
                    ->title('Graphic')
                    ->elementLabel("Ukuran Jersey")
                    ->labels(['XS', 'S', 'M', 'L', 'XL', 'XXL'])
                    ->values([$xs == null ? 0 : $xs,$s == null ? 0 : $s,$m == null ? 0 : $m,$l == null ? 0 : $l,$xl == null ? 0 : $xl,$xxl == null ? 0 : $xxl])
                    ->dimensions(1000,500)
                    ->yAxisTitle('Jumlah Jersey')
                    ->colors(['#FF8E00'])
                    ->responsive(true);
        /**
         * data komunitas
         *  */ 

        //get komunitas
        $kom = RegistrasiPesertaEventModel::select(\DB::raw("COUNT(komunitas) as count"), "komunitas")
                ->groupBy('komunitas')
                ->where('id_event', $id_event);            
        $label = count($kom->pluck('komunitas')) > 0 ? $kom->pluck('komunitas') : $label = array();
        $values = count($kom->pluck('count')) > 0 ? $kom->pluck('count') : $values = array();

        $komunitas = Charts::database($kom, 'bar', 'google')
			      ->title("Graphic")
			      ->elementLabel("Komunitas Registrasi")
                  ->responsive(true)
                  ->colors(['#3BCB45'])
                  ->labels($label)
                  ->values($values);
                //   ->settings();

                  //checking session
        $cek = Session::get('data')['id_anggota'] != null ? Session::get('data')['id_anggota'] : 'kosong';
        
        if(($cek == 'kosong')){
            return redirect('login')->with('alert','Kamu harus login dulu');
        }
        else{
            return view('/dashboard', compact('dtEvent', 'chart', 'id_event', 'gender', 'bayarChart', 'jersey', 'komunitas'));
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
