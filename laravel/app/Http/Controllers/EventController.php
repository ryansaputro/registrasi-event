<?php
/**
 * @author ryan saputro
 * @email ryansaputro52@gmail.com
 * @create date 2020-01-10 11:07:19
 * @modify date 2020-01-10 11:07:19
 * @desc 
 * 
 * modul pembuatan event semua dilakukan dicontroller ini
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\Anggota; //Use Model Anggota
use App\Models\ProfileChecking; 
use App\Models\UserMeta; //Use Model User Meta
use App\Models\RegistrasiEventModel; //Use Model RegistrasiEventModel
use App\Models\RegistrasiPesertaEventModel; //Use Model RegistrasiPesertaEventModel
use App\Models\EventPortalSepeda; //Use Model EventPortalSepeda
use App\Models\RegistrasiEventJerseyModel; //Use Model RegistrasiEventJerseyModel
use App\Models\User; //Use Model EventPortalSepeda
use App\Models\Komunitas; //Use Model Komunitas
use App\Models\RegistrasiEventJenisPembayaranModel; //Use Model RegistrasiEventJenisPembayaranModel
use DataTables; //Use Datatable Yajra server side 
use PDF; //Use DomPDF export
use Carbon\Carbon; //Use Time 
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;
use Image;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class EventController extends Controller
{
    public $path;
    public $dimensions;
    public $mockup;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->path = public_path('images/event');
        $this->mockup = public_path('images/event/mockup');
        //DEFINISIKAN DIMENSI
        $this->dimensions = ['245', '300', '500'];
    }

    public function index($id)
    {   
        //buat cron job manual
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        
         //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('nama', str_replace("_", " ", $id))->value('id');
        // $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get data event
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama', 'registrasi_event_jenis_pembayaran.harga')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->leftJoin('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_eo.id', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();
        
        //set local 
        DB::statement("SET lc_time_names = 'id_ID'");
        
        //sidebar kanan aktif
        $rightSidebarYearActive = DB::table('registrasi_event')
                ->select('registrasi_event.*', DB::raw('MONTHNAME(tanggal_mulai) bulan'), DB::raw('YEAR(tanggal_mulai) tahun'))
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->groupBy('tahun')
                ->get();
        
        $rightSidebarMonthActive = DB::table('registrasi_event')
                ->select('registrasi_event.*', DB::raw('MONTHNAME(tanggal_mulai) bulan'), DB::raw('YEAR(tanggal_mulai) tahun'))
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->groupBy('bulan')
                ->get();
        
        $rightSidebarActive = DB::table('registrasi_event')
                ->select('registrasi_event.*', DB::raw('MONTHNAME(tanggal_mulai) bulan'), DB::raw('YEAR(tanggal_mulai) tahun'))
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '<>', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();
        
        //sidebar kanan tdk aktif
        $rightSidebarYearNonActive = DB::table('registrasi_event')
                ->select('registrasi_event.*', DB::raw('MONTHNAME(tanggal_mulai) bulan'), DB::raw('YEAR(tanggal_mulai) tahun'))
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '=', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->groupBy('tahun')
                ->get();
        
        $rightSidebarMonthNonActive = DB::table('registrasi_event')
                ->select('registrasi_event.*', DB::raw('MONTHNAME(tanggal_mulai) bulan'), DB::raw('YEAR(tanggal_mulai) tahun'))
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '=', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->groupBy('bulan')
                ->get();
        
        $rightSidebarNonActive = DB::table('registrasi_event')
                ->select('registrasi_event.*', DB::raw('MONTHNAME(tanggal_mulai) bulan'), DB::raw('YEAR(tanggal_mulai) tahun'))
                ->where('registrasi_event.id_eo', $id_eo)
                ->where('registrasi_event.status', '=', '0')
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();
        
        //get data peserta event
        $peserta = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        
        //get data peserta yg sudah bayar
        $pesertaByr = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        

        return view('event.index', compact('id','data', 'peserta', 'pesertaByr', 'rightSidebarYearActive', 'rightSidebarMonthActive', 'rightSidebarActive', 'rightSidebarYearNonActive', 'rightSidebarMonthNonActive', 'rightSidebarNonActive'));
    }

    public function create($id)
    {
        //get data API provinsi
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);

        //get data dari wp
        $event = EventPortalSepeda::where('status', '1')->get();

        //komunitas
        $komunitas = Komunitas::all();
        
         //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('nama', str_replace("_", " ", $id))->value('id');
        
        //syarat dan ketentuan
        $syarat = DB::table('pengaturan_syarat_dan_ketentuan')->where('id_eo', $id_eo)->first();
        
        // dd($provinsi);
        return  view('event.create', compact('provinsi', 'id', 'event', 'komunitas', 'syarat'));
    }
    
    public function AjaxJerseyModel(Request $request){
        //jersey
        $jersey = DB::table('pengaturan_jersey')
                ->select('pengaturan_jersey.*', 'pengaturan_jersey_model.kode AS kd_model', 
                        'pengaturan_jersey_model.nama AS nama_model', 'pengaturan_jersey_darimana.kode AS kd_drmn', 
                        'pengaturan_jersey_darimana.nama AS nama_drmn', 'pengaturan_jersey_size.kode AS kd_size', 
                        'pengaturan_jersey_size.nama AS nama_size', 'pengaturan_jersey_tipe.kode AS kd_tipe', 
                        'pengaturan_jersey_tipe.nama AS nama_tipe')
                ->join('pengaturan_jersey_model', 'pengaturan_jersey.id_jersey_model', '=', 'pengaturan_jersey_model.id')
                ->join('pengaturan_jersey_darimana', 'pengaturan_jersey.id_jersey_darimana', '=', 'pengaturan_jersey_darimana.id')
                ->join('pengaturan_jersey_size', 'pengaturan_jersey.id_jersey_size', '=', 'pengaturan_jersey_size.id')
                ->join('pengaturan_jersey_tipe', 'pengaturan_jersey.id_jersey_tipe', '=', 'pengaturan_jersey_tipe.id')
                ->where('pengaturan_jersey.status', '1');
        
        //get model
        if($request->data == 'getModel'){
            // $data = $jersey->groupBy('pengaturan_jersey_model.id')->get();   
            $jerseys = DB::table('pengaturan_jersey')
                ->select('pengaturan_jersey.*', 'pengaturan_jersey_model.kode AS kd_model', 
                        'pengaturan_jersey_model.nama AS nama_model', 'pengaturan_jersey_darimana.kode AS kd_drmn', 
                        'pengaturan_jersey_darimana.nama AS nama_drmn', 'pengaturan_jersey_size.kode AS kd_size', 
                        'pengaturan_jersey_size.nama AS nama_size', 'pengaturan_jersey_tipe.kode AS kd_tipe', 
                        'pengaturan_jersey_tipe.nama AS nama_tipe')
                ->join('pengaturan_jersey_model', 'pengaturan_jersey.id_jersey_model', '=', 'pengaturan_jersey_model.id')
                ->join('pengaturan_jersey_darimana', 'pengaturan_jersey.id_jersey_darimana', '=', 'pengaturan_jersey_darimana.id')
                ->join('pengaturan_jersey_size', 'pengaturan_jersey.id_jersey_size', '=', 'pengaturan_jersey_size.id')
                ->join('pengaturan_jersey_tipe', 'pengaturan_jersey.id_jersey_tipe', '=', 'pengaturan_jersey_tipe.id')
                ->where('pengaturan_jersey.status', '1');
                
            $IdDrmnNama = $jerseys->pluck('nama_drmn', 'id_jersey_darimana')->toArray();                  
            $IdDrmnId = $jerseys->pluck('id_jersey_darimana', 'id_jersey_darimana')->toArray();                  
            $IdTipeId = $jerseys->pluck('id_jersey_tipe', 'nama_tipe')->toArray();
            $IdModel = $jerseys->pluck('id_jersey_model', 'kd_model')->toArray();
            
            $dataModel = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('kd_model', 'id_jersey_model')->toArray();  
            $kdModel = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('nama_model', 'id_jersey_model')->toArray();  
            $kdTipe = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('kd_tipe', 'id_jersey_model')->toArray();  
            $kdSize = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('kd_size', 'id_jersey_model')->toArray();  
            $NmTipe = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('nama_tipe', 'id_jersey_model')->toArray();  
            $NmSize = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('nama_size', 'id_jersey_model')->toArray();  
            $NmDrmn = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('nama_drmn', 'id_jersey_model')->toArray();  
            $IdDrmn = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('id_jersey_darimana', 'id_jersey_model')->toArray();  
            $IdTipe = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('id_jersey_tipe', 'id_jersey_model')->toArray();  
            $ukuran = $jerseys->groupBy('pengaturan_jersey_model.id')->pluck('ukuran', 'id_jersey_model')->toArray();  
        }
        
        //ketika pembuatan event
        foreach($jersey->get() AS $k => $v){
            
            //pembuatan utk grouping
            if(array_key_exists($v->id_jersey_model, $dataModel)){
                $dataN[$dataModel[$v->id_jersey_model]]["jersey"] = array("id_model" => $v->id_jersey_model, "nama_model" => $v->nama_model, "kd_model" => $v->kd_model, "kd_tipe" => $v->kd_tipe);
                $dataN[$dataModel[$v->id_jersey_model]]["ukuran"][$v->nama_drmn][$v->id_jersey_darimana][] = array("kd_drmn" => $v->kd_drmn, "nama_drmn" => $v->nama_drmn, "kd_size" => $v->kd_size, "nama_size" => $v->nama_size, "ukuran" => $v->ukuran);
                $dataN[$dataModel[$v->id_jersey_model]]["tipe"][$v->nama_drmn][$v->id_jersey_darimana][$v->nama_tipe][$v->id_jersey_tipe][] = array("kd_tipe" => $v->kd_tipe, "id_jersey_tipe" => $v->id_jersey_tipe, "kd_size" => $v->kd_size, "nama_size" => $v->nama_size, "ukuran" => $v->ukuran);
            }
        }
        
        //untuk edit event
        if(isset($request->event)){
            
            $jerseyExists = DB::table('registrasi_event_jersey')->select('*')->where('id_event', $request->event)->get();
            if(count($jerseyExists) > 0){
                foreach($jerseyExists AS $k => $v){
                    $modelX = explode(" ", $v->model);
                    $modelXNew[] = $modelX[1]; 
                    $IdmodelXNew[] = $IdModel[$modelX[0]]; 
                    $NmDrmnX = $v->id_jersey_darimana;
                    $flipdataModel = array_flip($dataModel);
                    $flipmodelX = array_flip($modelX);
                    $idTipeJersy[] = $IdTipeId[$modelX[1]];
                    
                    if (strpos($v->model, $modelX[1]) !== false) {
                        $size[$modelX[1]][] = $v->size;
                        $ukurans[$modelX[1]][] = $v->ukuran;
                    }
                    
                    
                    //pembuatan utk grouping
                    if(array_key_exists($modelX[0], $flipdataModel)){
                        $dataX[$modelX[0]]["jersey"] = array("id_model" => $flipdataModel[$modelX[0]], "nama_model" => $kdModel[$flipdataModel[$modelX[0]]], "kd_model" => $modelX[0], "kd_tipe" => $kdTipe[$flipdataModel[$modelX[0]]]);
                        // $dataX[$flipdataModel[$modelX[0]]]["ukuran"][$v->nama_drmn][$v->id_jersey_darimana][] = array("kd_drmn" => $v->kd_drmn, "nama_drmn" => $v->nama_drmn, "kd_size" => $v->kd_size, "nama_size" => $v->nama_size, "ukuran" => $v->ukuran);
                        $dataX[$modelX[0]]["tipe"][$IdDrmnNama[$NmDrmnX]][$IdDrmnId[$NmDrmnX]][$modelX[1]][$IdTipeId[$modelX[1]]][] = array("kd_tipe" => $kdTipe[$flipdataModel[$modelX[0]]], "id_jersey_tipe" => $IdTipe[$flipdataModel[$modelX[0]]], "kd_size" => $size[$modelX[1]], "nama_size" => $NmSize[$flipdataModel[$modelX[0]]], "ukuran" => $ukuran[$flipdataModel[$modelX[0]]]);
                    }
                }
                
                $idTipe = DB::table('pengaturan_jersey_tipe')->select('*')->whereIn('nama', $modelXNew)->pluck('id')->toArray();
                $models = array_values(array_unique($IdmodelXNew));
                
                $idMdl = count($idTipe) - count($models) ;
                end($models);         // move the internal pointer to the end of the array
                $key = key($models);  // fetches the key of the element pointed to by the internal pointer
                for($i=$key+1; $i<=$idMdl; $i++){
                    $models[$i] = end($models);
                }
                
                return response()->json(['model' => $dataN, 'id_model' => $models, 'jersey' => $dataX, "kdModel" => $modelX[0], "drmn" => str_replace(" ", "_", $IdDrmnNama[$NmDrmnX]), "tipe" => array_values(array_unique($modelXNew)), "id_tipe" => $idTipe, "kd_size" => $size, "ukuran" => $ukurans ]);
            }else{
                return response()->json(['status' => '404', 'model' => $dataN]);
                
            }
            // dd($kdSize[$flipdataModel[$modelX[0]]]);
            
        }else{
            $dataX[] = null;
        }
        
        
        
        return response()->json(['model' => $dataN]);
        
    }

    public function store(Request $request, $eo)
    {
        DB::beginTransaction();
        try {
                $messages = [
                    'required'  => ':attribute harus di isi !!!',
                    'min'       => ':attribute harus diisi minimal :min karakter !!!',
                    'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                    'numeric'   => ':attribute harus diisi dengan angka !!!',
                    'desain_mockup.required_if'   => 'gambar jersey wajib diisi jika event termasuk jersey',
                ];

                $valid = $this->validate($request, [
                    'kode_event'                => 'required|unique:registrasi_event,kode_event|max:3',
                    'nama_event'                => 'required|unique:registrasi_event,nama_event',
                    'tanggal_mulai'             => 'required|date',
                    'tanggal_akhir'             => 'required|date',
                    'tanggal_mulai_pendaftaran' => 'required|date',
                    'tanggal_akhir_pendaftaran' => 'required|date',
                    'tempat_event'              => 'required',
                    'id_provinsi'               => 'required',
                    'id_kota'                   => 'required',
                    'id_kecamatan'              => 'required',
                    'id_desa'                   => 'required',
                    'kode_pos'                  => 'required',
                    'waktu_kumpul'              => 'required|date',
                    'tempat_kumpul'             => 'required',
                    'deskripsi_event'           => 'required',
                    'url_event'                 => 'required',
                    'jenis_event'               => 'required',
                    'syarat'                    => 'required',
                    'biaya_pendaftaran.*'       => 'numeric|required_if:biayaCheck,==,1',
                    'tgl_pendaftaran.*'         => 'date|required_if:biayaCheck,==,1',
                    'tgl_pembayaran.*'          => 'date|required_if:biayaCheck,==,1',
                    'jumlah_peserta'            => 'numeric|required_if:pesertaCheck,==,1',
                    'size.*.*.*.*'              => 'string|required_if:includeJersey,==,on',
                    'e_poster'                  => 'required|image|mimes:jpg,png,jpeg||max:1048',
                    'desain_mockup'             => 'required_if:includeJersey,==,on|image|mimes:jpg,png,jpeg||max:1048',
                ],$messages);


                //pembuatan direktori pada server
                if (!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path,777, true);
                }
                
                //pembuatan nama file
                $nama = strtoupper(str_replace(' ', '_', $request->nama_event));
                $file = $request->file('e_poster');
                $fileName = Carbon::now()->timestamp . '_' . $nama . '.' . $file->getClientOriginalExtension();
                
                //simpan image ke folder
                Image::make($file)->save($this->path . '/' . $fileName);
                
                //looping utk penyimpanan dimensi image
                foreach ($this->dimensions as $row) {
                    $canvas = Image::canvas($row, $row);
                    $resizeImage = Image::make($file)->resize($row, $row, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    if (!File::isDirectory($this->path . '/' . $row)) {
                        File::makeDirectory($this->path . '/' . $row);
                    }
                
                    $canvas->insert($resizeImage, 'center');
                    $canvas->save($this->path . '/' . $row . '/' . $fileName);
                }
                
                //get data eo
                $id_eo = DB::table('registrasi_eo')->select('id')->where('nama', str_replace('_', ' ', $eo))->value('id');

                //simpan ke db registrasi event
                $regis = RegistrasiEventModel::create([
                    'kode_event' => strtoupper($request->kode_event),
                    'nama_event' => $request->nama_event,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_akhir' => $request->tanggal_akhir,
                    'tempat_event' => $request->tempat_event,
                    'id_provinsi' => $request->id_provinsi,
                    'id_kota' => $request->id_kota,
                    'id_kecamatan' => $request->id_kecamatan,
                    'id_desa' => $request->id_desa,
                    'kode_pos' => $request->kode_pos,
                    'waktu_kumpul' => $request->waktu_kumpul,
                    'tempat_kumpul' => $request->tempat_kumpul,
                    'tanggal_awal_pendaftaran' => $request->tanggal_mulai_pendaftaran,
                    'tanggal_akhir_pendaftaran' => $request->tanggal_akhir_pendaftaran,
                    'deskripsi_event' => $request->deskripsi_event,
                    'url_event' => $request->url_event,
                    'url_lain' => $request->url_lain,
                    'id_eo' => $id_eo,
                    'id_jenis_event' => $request->jenis_event,
                    'sponsor' => $request->sponsor,
                    'jumlah_peserta' => $request->jumlah_peserta,
                    'e_poster' => $fileName,
                    'syarat_dan_ketentuan' => $request->syarat,
                ]);
                
                //checking event berbayar
                if($request->biaya_pendaftaran != null){

                    //looping utk biaya pendaftaran dan jenisnya(early bird, normal, ots)
                    foreach($request->biaya_pendaftaran AS $k => $v){

                        //penyimpanan di tabel registrasi event jenis pembayaran
                        RegistrasiEventJenisPembayaranModel::create([
                            'id_event' => $regis->id,
                            'jenis_pembayaran' => $k,
                            'tanggal' => $request->tgl_pendaftaran[$k],
                            'tanggal_bayar' => $request->tgl_pembayaran[$k],
                            'harga' => $v,
                        ]);
                    }
                }

                //jika include jersey dicentang
                if($request->includeJersey == 'on'){
                    
                    foreach($request->size AS $k => $v){
            
                        //$k itu model jersey
                        //$drmn itu isinya internasional atau local
                        foreach($v AS $drmn => $val){
                            
                            //$tipe isinya panjang atau pendek
                            foreach($val AS $tipe => $valu){
                                
                                //isi di explode utk ukuran dan size
                                foreach($valu AS $key => $isi){
                                    
                                    $uk = explode(",", $isi);
                                    
                                    //simpan ke registrasi event jersey
                                    $data = RegistrasiEventJerseyModel::create(
                                        [
                                        'model' => $k.' '.$tipe, 
                                        'id_event' => $regis->id,
                                        'size' => strtoupper($uk[0]), 
                                        'ukuran' => strtoupper($uk[1]), 
                                        ]);
                                }
                            }
                        }
                    }
                    
                    // //save jersey ukuran
                    // foreach($request->ukuran AS $k => $v){
                        
                    //     //looping utk jenis jersey
                    //     foreach($v AS $key => $val){
    
                            // //simpan ke registrasi event jersey
                            // $data = RegistrasiEventJerseyModel::create(
                            //     [
                            //     'model' => $request->style[$k], 
                            //     'id_event' => $regis->id,
                            //     'size' => strtoupper($key), 
                            //     'ukuran' => strtoupper($val), 
                            //     ]);
                    //     }
                    // }

                    //pembuatan direktori pada server
                    if (!File::isDirectory($this->mockup)) {
                        File::makeDirectory($this->mockup,777, true);
                    }
                    
                    //pembuatan nama file
                    $nama = strtoupper(str_replace(' ', '_', $request->nama_event));
                    $desain_mockup = $request->file('desain_mockup');
                    $fileNameMockup = Carbon::now()->timestamp . '_' . $nama . '_JERSEY.' . $file->getClientOriginalExtension();
                    
                    //simpan image ke folder
                    Image::make($desain_mockup)->save($this->mockup . '/' . $fileNameMockup);

                    //insert mockup desain
                    RegistrasiEventModel::find($regis->id)->update(['desain_mockup' => $fileNameMockup]);
                    
                }

                //send email
                $isi =  RegistrasiEventModel::where('id', $regis->id)->first();
                Mail::to(Session::get('data')['email'])->send(new SendMailable($isi));
                
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                dd($ex->getMessage());
                return redirect()->back()
                        ->with('failed', 'Event gagal dibuat');
        }
            DB::commit();
            // dd($request->all());
            return redirect()->route('event.index', [strtolower(str_replace(' ', '_', Session::get('data')['full_name']))])
                    ->with('success', 'Event berhasil dibuat');
    }

    public function dataTable()
    {
        $model = DB::table('registrasi_event')->select('registrasi_event.*', 'registrasi_eo.nama')->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')->where('registrasi_eo.id', Session::get('data')['id_anggota'])->orderBy('registrasi_event.tanggal_mulai', 'DESC')->get();
        $eo = isset($model->first()->nama) ? str_replace(' ', '-', $model->first()->nama) : '';
        return DataTables::of($model)
            ->addColumn('action', function ($model) use  ($eo) {
                return view('layouts_app._action_anggota', [
                    'model' => $model,
                    // 'data' => $model
                    'url_show' => route('event.show', [$eo, strtolower(str_replace(" ","-",$model->kode_event))]),
                    'url_edit' => route('event.edit', [$eo, strtolower(str_replace(" ","-",$model->kode_event))]),
                    'url_list_peserta' => route('event.edit', [$eo, strtolower(str_replace(" ","-",$model->kode_event))]),
                    'xxx' => $model
                ]);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function edit($eo, $kode_event)
    {   
        //ganti format dengan lowercase
        $kode_event = strtolower(str_replace("-"," ",$kode_event));
        
        //get event
        $event = RegistrasiEventModel::where('kode_event', 'LIKE', $kode_event)->first();

        //logika jika event nya ga ada maka di redirect ke 404
        if($event == null){
            return abort(404);
        }else{

            //jika tanggal hari ini lebih dr tanggal event redirect ke 404
            if(date('Y-m-d H:i:s') > $event->tanggal_mulai){
                return abort(404);
            }
        }

        //get data jenis pembayaran by event
        $jenis_pembayaran = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->get();
        
        //get from form wordpress
        $eventPortal = EventPortalSepeda::where('status', '1')->get(); 
        
        //get data API provinsi
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);
        
        //get data API kota
        $respKota = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$event->id_provinsi.'.json')->get();
        $kota = json_decode($respKota, true);
        
        //get data API kecamatan
        $respKec = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kecamatan/'.$event->id_kota.'.json')->get();
        $kecamatan = json_decode($respKec, true);
        
        //get data API desa
        $respDesa = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kelurahan/'.$event->id_kecamatan.'.json')->get();
        $desa = json_decode($respDesa, true);

        //get jersey from event
        $jersey = array_unique(RegistrasiEventJerseyModel::where("id_event", $event->id)->pluck('model')->toArray());
        $dataJersey = RegistrasiEventJerseyModel::where("id_event", $event->id)->get();

        return  view('event.edit', compact('jersey', 'dataJersey', 'provinsi', 'eo', 'event', 'jenis_pembayaran', 'kota', 'kecamatan', 'desa', 'eventPortal'));
    }

    public function update(Request $request, $eo, $kode_event)
    {
        //get data event utk validasi agar kode event unik
        $evt = RegistrasiEventModel::where('kode_event', $kode_event)->first();
        DB::beginTransaction();
        try {
                $messages = [
                    'required'  => ':attribute harus di isi !!!',
                    'min'       => ':attribute harus diisi minimal :min karakter !!!',
                    'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                    'numeric'   => ':attribute harus diisi dengan angka !!!',
                    'required_without' => ':attribute harus diisi dikarenakan sebelumnya kosong !!!',
                    'unique' => ':attribute sudah digunakan !!!',
                    'required_if' => ':attribute harus diisi jika biaya pendaftaran dicetang !!!',
                ];

                $valid = $this->validate($request, [
                    'kode_event'            => 'required|unique:registrasi_event,kode_event,'.$evt->kode_event.',kode_event|max:3',
                    'nama_event'            => 'required|unique:registrasi_event,nama_event,'.$evt->nama_event.',nama_event',
                    'tanggal_mulai'         => 'required|date',
                    'tanggal_akhir'         => 'required|date',
                    'tempat_event'          => 'required',
                    'id_provinsi'           => 'required',
                    'id_kota'               => 'required',
                    'id_kecamatan'          => 'required',
                    'id_desa'               => 'required',
                    'kode_pos'              => 'required',
                    'waktu_kumpul'          => 'required|date',
                    'tempat_kumpul'         => 'required',
                    'tanggal_mulai_pendaftaran' => 'required|date',
                    'tanggal_akhir_pendaftaran' => 'required|date',
                    'deskripsi_event'       => 'required',
                    'url_event'             => 'required',
                    'jenis_event'           => 'required',
                    'biaya_pendaftaran.*'   => 'numeric|required_if:biayaCheck,==,1',
                    'syarat'                => 'required',
                    'tgl_pendaftaran.*'     => 'date|required_if:biayaCheck,==,1',
                    'tgl_pembayaran.*'      => 'date|required_if:biayaCheck,==,1',
                    'jumlah_peserta'        => 'numeric|required_if:pesertaCheck,==,1',
                    // 'ukuran.*.*'            => 'string|required_if:includeJersey,==,on',
                    'e_poster'              => 'required_without:e_poster_value|image|mimes:jpg,png,jpeg|max:1048',
                    'desain_mockup'         => 'required_without:desain_mockup_value|image|mimes:jpg,png,jpeg||max:1048',
                ],$messages);
                    // required_if:includeJersey,==,on|
                //jika ada gambar maka buat folder
                if(!empty($request->file('e_poster'))){
                    if (!File::isDirectory($this->path)) {
                        File::makeDirectory($this->path,777, true);
                    }
                    
                    //pembuatan nama file image
                    $nama = strtoupper(str_replace(' ', '_', $request->nama_event));
                    $file = $request->file('e_poster');
                    $fileName = Carbon::now()->timestamp . '_' . $nama . '.' . $file->getClientOriginalExtension();
                    
                    //hapus iamge dari folder
                    unlink($this->path . '/' . $fileName);
                    unlink($this->path . '/245/' . $fileName);
                    unlink($this->path . '/300/' . $fileName);
                    unlink($this->path . '/500/' . $fileName);

                    //simpan image ke folder
                    Image::make($file)->save($this->path . '/' . $fileName);
                    
                    //looping image sesaui dengan resolusi yg di definisikan
                    foreach ($this->dimensions as $row) {
                        $canvas = Image::canvas($row, $row);
                        $resizeImage = Image::make($file)->resize($row, $row, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    
                        if (!File::isDirectory($this->path . '/' . $row)) {
                            File::makeDirectory($this->path . '/' . $row);
                        }
                    
                        $canvas->insert($resizeImage, 'center');
                        $canvas->save($this->path . '/' . $row . '/' . $fileName);
                    }
                    
                     //get data eo
                    $id_eo = DB::table('registrasi_eo')->select('id')->where('nama', $eo)->value('id');

                    // //get data eo
                    // $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
                    
                    //update data event sesuai id event
                    $regis = RegistrasiEventModel::find($evt->id)->update([
                        'kode_event' => strtoupper($request->kode_event),
                        'nama_event' => $request->nama_event,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_akhir' => $request->tanggal_akhir,
                        'tempat_event' => $request->tempat_event,
                        'id_provinsi' => $request->id_provinsi,
                        'id_kota' => $request->id_kota,
                        'id_kecamatan' => $request->id_kecamatan,
                        'id_desa' => $request->id_desa,
                        'kode_pos' => $request->kode_pos,
                        'waktu_kumpul' => $request->waktu_kumpul,
                        'tempat_kumpul' => $request->tempat_kumpul,
                        'tanggal_awal_pendaftaran' => $request->tanggal_mulai_pendaftaran,
                        'tanggal_akhir_pendaftaran' => $request->tanggal_akhir_pendaftaran,
                        'deskripsi_event' => $request->deskripsi_event,
                        'url_event' => $request->url_event,
                        'url_lain' => $request->url_lain,
                        'id_jenis_event' => $request->jenis_event,
                        'sponsor' => $request->sponsor,
                        'jumlah_peserta' => $request->jumlah_peserta,
                        'e_poster' => $fileName,
                        'syarat_dan_ketentuan' => $request->syarat,
                    ]);
                    
                    //jika event berbayar
                    if($request->biaya_pendaftaran != null){

                        //looping jika jenis pembayaran ada eb, normal dan ots
                        foreach($request->biaya_pendaftaran AS $k => $v){

                            //hapus jenis pembayaran event
                            RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->where('jenis_pembayaran', 'LIKE', $k)->delete();
                            
                            //pembuatan ulang jenis pembayaran event
                            RegistrasiEventJenisPembayaranModel::create([
                                'id_event' => $evt->id,
                                'jenis_pembayaran' => $k,
                                'tanggal' => $request->tgl_pendaftaran[$k],
                                'tanggal_bayar' => $request->tgl_pembayaran[$k],
                                'harga' => $v,
                            ]);
                        }
                    }

                    //jika event gratis
                    if(!isset($request->biayaCheck)){

                        //hapus dari jenis pembayaran event
                        RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->delete();
                    }

                    //jersey
                    if($request->includeJersey == 'on'){
                        
                        //update desain
                        if(!empty($request->file('desain_mockup'))){

                            //check direktori ada ga
                            if (!File::isDirectory($this->mockup)) {
                                File::makeDirectory($this->mockup,777, true);
                            }
                            
                            //pembuatan nama file image
                            $nama = strtoupper(str_replace(' ', '_', $request->nama_event));
                            $file = $request->file('desain_mockup');
                            $fileName = Carbon::now()->timestamp . '_' . $nama . '_JERSEY.' . $file->getClientOriginalExtension();
                            
                            //hapus iamge dari folder
                            $mock = RegistrasiEventModel::select('*')->where('id', $evt->id)->first();
                            
                            if($mock->desain_mockup != null){
                                unlink($this->mockup . '/' . $evt->desain_mockup);    
                            }
                            

                            //simpan image ke folder
                            Image::make($file)->save($this->mockup . '/' . $fileName);

                            RegistrasiEventModel::find($evt->id)->update([
                                'desain_mockup' => $fileName
                            ]);
                        }

                        // //save jersey ukuran
                        // foreach($request->ukuran AS $k => $v){
                            
                        //     //looping utk jenis jersey
                        //     foreach($v AS $key => $val){

                        //         //simpan ke registrasi event jersey
                        //         $data = RegistrasiEventJerseyModel::updateOrCreate(
                                    
                        //             [
                        //             'model' => $request->style[$k], 
                        //             'id_event' => $evt->id,
                        //             'size' => strtoupper($key), 
                        //             'ukuran' => strtoupper($val), 
                        //             ],[
                        //             'size' => strtoupper($key), 
                        //             'ukuran' => strtoupper($val), 
                        //             ]
                                    
                        //         );
                        //     }
                        // }
                        
                    foreach($request->size AS $k => $v){
            
                        //$k itu model jersey
                        //$drmn itu isinya internasional atau local
                        foreach($v AS $drmn => $val){
                            
                            //$tipe isinya panjang atau pendek
                            foreach($val AS $tipe => $valu){
                                
                                //isi di explode utk ukuran dan size
                                foreach($valu AS $key => $isi){
                                    
                                    $uk = explode(",", $isi);
                                    $id_jersey_darimana = DB::table('pengaturan_jersey_darimana')->select('id')->where('nama', str_replace('_', ' ', $drmn))->value('id');
                                    //simpan ke registrasi event jersey
                                    $data = RegistrasiEventJerseyModel::updateOrCreate(
                                        [
                                        'model' => $k.' '.$tipe, 
                                        'id_event' => $evt->id,
                                        'size' => strtoupper($uk[0]), 
                                        'ukuran' => strtoupper($uk[1]), 
                                        ],[
                                        'size' => strtoupper($uk[0]), 
                                        'ukuran' => strtoupper($uk[1]),
                                        'id_jersey_darimana' => $id_jersey_darimana   
                                        ]);
                                }
                            }
                        }
                    }
                        
                    //jk jersey nya tidak di centang    
                    }else{

                        RegistrasiEventJerseyModel::where('id_event', $evt->id)->delete();
                        $mock = RegistrasiEventModel::find($evt->id)->update(['desain_mockup' => null]);
                    }

                    
                //jika update tanpa foto
                }else{

                    //get data eo
                    $id_eo = DB::table('registrasi_eo')->select('id')->where('nama', $eo)->value('id');
                    
                    //update event
                    $regis = RegistrasiEventModel::find($evt->id)->update([
                        'kode_event' => strtoupper($request->kode_event),
                        'nama_event' => $request->nama_event,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_akhir' => $request->tanggal_akhir,
                        'tempat_event' => $request->tempat_event,
                        'id_provinsi' => $request->id_provinsi,
                        'id_kota' => $request->id_kota,
                        'id_kecamatan' => $request->id_kecamatan,
                        'id_desa' => $request->id_desa,
                        'kode_pos' => $request->kode_pos,
                        'waktu_kumpul' => $request->waktu_kumpul,
                        'tempat_kumpul' => $request->tempat_kumpul,
                        'tanggal_awal_pendaftaran' => $request->tanggal_mulai_pendaftaran,
                        'tanggal_akhir_pendaftaran' => $request->tanggal_akhir_pendaftaran,
                        'deskripsi_event' => $request->deskripsi_event,
                        'url_event' => $request->url_event,
                        'url_lain' => $request->url_lain,
                        'id_jenis_event' => $request->jenis_event,
                        'sponsor' => $request->sponsor,
                        'jumlah_peserta' => $request->jumlah_peserta,
                    ]);
                    
                    //jika event bayar
                    if($request->biaya_pendaftaran != null){
                        foreach($request->biaya_pendaftaran AS $k => $v){
                            RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->where('jenis_pembayaran', 'LIKE', $k)->delete();
                            RegistrasiEventJenisPembayaranModel::create([
                                'id_event' => $evt->id,
                                'jenis_pembayaran' => $k,
                                'tanggal' => $request->tgl_pendaftaran[$k],
                                'tanggal_bayar' => $request->tgl_pembayaran[$k],
                                'harga' => $v,
                            ]);
                        }
                    }

                    //jika event gratis
                    if(!isset($request->biayaCheck)){
                        RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->delete();
                    }

                    //jersey
                    if($request->includeJersey == 'on'){
                        
                        //update desain
                        if(!empty($request->file('desain_mockup'))){

                            //check direktori ada ga
                            if (!File::isDirectory($this->mockup)) {
                                File::makeDirectory($this->mockup,777, true);
                            }
                            
                            //pembuatan nama file image
                            $nama = strtoupper(str_replace(' ', '_', $request->nama_event));
                            $file = $request->file('desain_mockup');
                            $fileName = Carbon::now()->timestamp . '_' . $nama . '_JERSEY.' . $file->getClientOriginalExtension();
                            
                            //hapus iamge dari folder
                            $mock = RegistrasiEventModel::select('*')->where('id', $evt->id)->first();
                            
                            if($mock->desain_mockup != null){
                                unlink($this->mockup . '/' . $evt->desain_mockup);    
                            }
                            

                            //simpan image ke folder
                            Image::make($file)->save($this->mockup . '/' . $fileName);

                            RegistrasiEventModel::find($evt->id)->update([
                                'desain_mockup' => $fileName
                            ]);
                        }


                        //save jersey ukuran
                        foreach($request->size AS $k => $v){
            
                        //$k itu model jersey
                        //$drmn itu isinya internasional atau local
                        foreach($v AS $drmn => $val){

                            //$tipe isinya panjang atau pendek
                            foreach($val AS $tipe => $valu){
                                
                                //isi di explode utk ukuran dan size
                                foreach($valu AS $key => $isi){
                                    
                                    $uk = explode(",", $isi);
                                    $id_jersey_darimana = DB::table('pengaturan_jersey_darimana')->select('id')->where('nama', str_replace('_', ' ', $drmn))->value('id');
                                    //simpan ke registrasi event jersey
                                    $data = RegistrasiEventJerseyModel::updateOrCreate(
                                        [
                                        'model' => $k.' '.$tipe, 
                                        'id_event' => $evt->id,
                                        'size' => strtoupper($uk[0]), 
                                        'ukuran' => strtoupper($uk[1]), 
                                        ],[
                                        'size' => strtoupper($uk[0]), 
                                        'ukuran' => strtoupper($uk[1]),
                                        'id_jersey_darimana' => $id_jersey_darimana   
                                        ]);
                                }
                            }
                        }
                    }
                    //jk jersey nya tidak di centang    
                    }else{

                        RegistrasiEventJerseyModel::where('id_event', $evt->id)->delete();
                        $mock = RegistrasiEventModel::find($evt->id)->update(['desain_mockup' => null]);
                    }

                }

                //get data registrasi event utk attribute di email
                $regis = RegistrasiEventModel::where('id', $evt->id)->first();
                $isi = $regis;

                //send email
                Mail::to(Session::get('data')['email'])->send(new SendMailable($isi));

            } catch (\Illuminate\Database\QueryException $ex) {
                
                dd($ex->getMessage());
            DB::rollback();
            return redirect()->back()
               ->with('failed', 'Event gagal diupdate');
        }
        DB::commit();
        // dd($request->all());
        return redirect()->route('event.index', [$eo])
               ->with('success', 'Event berhasil diupdate');
    }
    
    public function show (Request $request, $eo, $kode_event)
    {
        //get event
        $evt = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
        
        //get dari wp
        $eventPortal = EventPortalSepeda::where('status', '1')->pluck('name', 'id')->toArray();
        
        //get jenis pembayaran event
        $jenisPembayaran = RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->value('harga');
        
        //get user yg login
        $user = User::where('ID', Session::get('data')['id_anggota'])->value('user_email');
        
        //get hp user yg login
        $hp_eo = DB::table('registrasi_eo')->select('no_hp_kontak')->where('id_member', Session::get('data')['id_anggota'])->value('no_hp_kontak');
        return view('event.show', compact('evt', 'eo', 'eventPortal', 'jenisPembayaran', 'user', 'hp_eo'));
    }
    
    //fungsi untuk memperpanjang waktu pendaftaran atau menambah quota
    public function ajaxKuota(Request $request)
    {   
        //get data event
        $event = RegistrasiEventModel::where('kode_event', 'LIKE', '%'.$request->kode.'%')->first();
        
        //get data detail event
        $detail = RegistrasiEventJenisPembayaranModel::where('id_event', 'LIKE', $event->id)->first();
        return response()->json([
            'error' => false,
            'event'  => $event,
            'detail'  => $detail,
        ], 200);
    }

    //store waktu perpanjangan event
    public function updateDataEvent(Request $request, $id)
    {
        $messages = [
            'required'  => ':attribute harus di isi !!!',
            'min'       => ':attribute harus diisi minimal :min karakter !!!',
            'kuota_baru.different' => 'jumlah peserta harus berbeda dengan yang sebelumnya !!!',
            'tanggal_daftar_barus.different' => 'tanggal daftar harus berbeda dengan yang sebelumnya !!!',
            'tanggal_bayar_baru.different' => 'tanggal bayar harus berbeda dengan yang sebelumnya !!!',
            'harga_baru.different' => 'harga harus berbeda dengan yang sebelumnya !!!',
            'numeric'   => ':attribute harus diisi dengan angka !!!',
        ];
        
        //kode eo
        $eo = $id;

        //get data event
        $event = RegistrasiEventModel::where('kode_event', 'LIKE', '%'.$request->kode_event.'%')->first();
        
        //checking jika event gratis
        $checkFreeEvent = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->count();

        if($checkFreeEvent > 0){
            
            $valid = $this->validate($request, [
                'jumlah_peserta'        => 'required|numeric',
                'tanggal_mulai'         => 'required|date',
                'tanggal'               => 'required|date',
                'harga'                 => 'required|numeric',
                'kuota_baru'            => 'required|numeric',
                'tanggal_daftar_barus'  => 'required|different:tanggal_mulai|date',
                'tanggal_bayar_baru'    => 'required|different:tanggal|date',
                'harga_baru'            => 'required|numeric',
            ],$messages);
        }else{

            $valid = $this->validate($request, [
                'jumlah_peserta'        => 'required|numeric',
                'tanggal_mulai'         => 'required|date',
                'tanggal'               => 'required|date',
                'harga'                 => 'required|numeric',
                'kuota_baru'            => 'required|numeric',
                'harga_baru'            => 'required|numeric',
            ],$messages);
        }

        DB::beginTransaction();
        try {

            //update kuota event jika kuota sebelumnya tidak sama dengan kuota sekarang
            if($event->jumlah_peserta != $request->kuota_baru){
                RegistrasiEventModel::find($event->id)->update(['jumlah_peserta' => $request->kuota_baru, 'status' => '1']);
            }

            if($checkFreeEvent > 0){
                
                //get detail event dan update
                RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->update([
                    'tanggal_ekstra' => $request->tanggal_daftar_barus, 
                    'tanggal_bayar_ekstra' => $request->tanggal_bayar_baru, 
                    'harga_ekstra' => $request->harga_baru, 
                    'updated_by' => Session::get('data')['id_anggota'], 
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }



        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return redirect()->back()
               ->with('failed', 'Event gagal diupdate');
        }
        DB::commit();
        return redirect()->route('event.index', [$eo])
               ->with('success', 'Event berhasil diupdate');



    }

    public function ajaxGetJersey(Request $request)
    {
        $data = RegistrasiEventJerseyModel::where('id_event', $request->id_event)->get();
        if(count($data) > 0){
            foreach($data AS $k => $v){
                $datas[strtolower(str_replace(" ", "_", $v->model))][$v->size] = $v->ukuran;
            }
            
        }else{
            $datas = [];
        }
        
        $jmlDatas = count($datas);
        return response()->json(['status' => 200, 'jmlDatas' => $jmlDatas,  'datas' => $datas, 'jerseyAjax' => $data]);
    }
}
