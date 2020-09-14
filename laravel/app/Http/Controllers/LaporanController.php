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
use App\Models\User; //Use Model EventPortalSepeda
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

class LaporanController extends Controller
{


    public function daftar_event($id)
    {   
        //buat cron job manual
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get data event
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->leftJoin('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_eo.id', $id_eo)
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

        return view('laporan.daftar_event', compact('id','data', 'peserta', 'pesertaByr'));
    }
    
    public function rekap_data_pembayaran($id)
    {   
        //buat cron job manual
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get data event
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->leftJoin('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_eo.id', $id_eo)
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();

        //get data peserta event
        $peserta = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        
        //get data peserta yg sudah bayar dan belum
        $pesertaByr = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        //dd($pesertaByr);
        $pesertaBlmByr = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '0')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
                
        return view('laporan.rekap_data_pembayaran', compact('id','data', 'peserta', 'pesertaByr','pesertaBlmByr'));
    }
    
    public function rekap_data_peserta_by_gender($id)
    {   
        //buat cron job manual
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get data event
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->leftJoin('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_eo.id', $id_eo)
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();
                
        //get data peserta event
        $peserta = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
                
        //get data peserta by gender
        $pesertaLaki = 
        app('db')->connection()->select("
        SELECT COUNT(b.meta_value) as jml,a.id_event
        FROM portalse_nci_event_organizer_test.`registrasi_peserta_event` a
        LEFT JOIN portalse_nci_portalsepeda_test.wp_usermeta b
        on a.id_member=b.user_id
        WHERE b.meta_key = 'jenis_kelamin' AND b.meta_value='Laki-Laki'
        GROUP by a.id_event
        ");
        
        foreach($pesertaLaki as $key => $value){
            //foreach($value as $key => $vale){
                $pluck_laki[$value->id_event] = $value->jml;
            //}
        }
    
        //dd($pluck_laki);
        
        $pesertaPr = 
        app('db')->connection()->select("
        SELECT COUNT(b.meta_value) as jml,a.id_event
        FROM portalse_nci_event_organizer_test.`registrasi_peserta_event` a
        LEFT JOIN portalse_nci_portalsepeda_test.wp_usermeta b
        on a.id_member=b.user_id
        WHERE b.meta_key = 'jenis_kelamin' AND b.meta_value='Perempuan'
        GROUP by a.id_event
        ");
        foreach($pesertaPr as $key => $value){
            //foreach($value as $key => $vale){
                $pluck_perempuan[$value->id_event] = $value->jml;
            //}
        }
        //dd($pluck_perempuan);        
        return view('laporan.rekap_data_peserta_by_gender', compact('id','data', 'peserta', 'pluck_laki','pluck_perempuan'));
    }
    
    public function rekap_data_komunitas($id)
    {   
        //buat cron job manual
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get data event
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->leftJoin('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_eo.id', $id_eo)
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();

        //get data peserta event
        $peserta = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        
        //get data peserta yg sudah bayar dan belum
        $pesertaKom = DB::table('registrasi_peserta_event')
                ->select('komunitas', 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->groupBy('komunitas')
                ->pluck('komunitas', 'id_event')
                ->toArray();
        //dd($pesertaKom);
                
        return view('laporan.rekap_data_komunitas', compact('id','data', 'peserta', 'pesertaKom'));
    }
    
    public function rekap_data_jersey($id)
    {   
        //buat cron job manual
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        
        //get data eo
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        //get data event
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->leftJoin('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_eo.id', $id_eo)
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();
        
        //get data peserta event
        $peserta = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        
        //get data peserta yg ukuran
        $ukuranS = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->where('size_jersey', 'S')
                ->groupBy('size_jersey')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
                
        $ukuranM = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->where('size_jersey', 'M')
                ->groupBy('size_jersey')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
                
        $ukuranL = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->where('size_jersey', 'L')
                ->groupBy('size_jersey')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        //dd($ukuranL);
        $ukuranXL = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->where('size_jersey', 'XL')
                ->groupBy('size_jersey')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
                
        $ukuranXS = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->where('size_jersey', 'XS')
                ->groupBy('size_jersey')
                ->groupBy('id_event')
                ->pluck('jml', 'id_event')
                ->toArray();
        //dd($ukuranXS);
        $ukuranXXL = DB::table('registrasi_peserta_event')
                ->select(DB::raw('COUNT(id) AS jml'), 'id_event')
                ->where('is_free', 'tidak')
                ->where('status_pembayaran', '1')
                ->where('size_jersey', 'XXL')
                ->pluck('jml', 'id_event')
                ->toArray();
        //dd($ukuranXXL);
                
        return view('laporan.rekap_data_jersey', compact('id','data', 'peserta', 'ukuranS', 'ukuranM', 'ukuranL','ukuranXL','ukuranXS','ukuranXXL'));
    }
    
    public function create($id)
    {
        //get data API provinsi
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);

        //get data dari wp
        $event = EventPortalSepeda::where('status', '1')->get();

        return  view('event.create', compact('provinsi', 'id', 'event'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
                $messages = [
                    'required'  => ':attribute harus di isi !!!',
                    'min'       => ':attribute harus diisi minimal :min karakter !!!',
                    'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                    'numeric'   => ':attribute harus diisi dengan angka !!!',
                ];

                $valid = $this->validate($request, [
                    'kode_event'            => 'required|unique:registrasi_event,kode_event',
                    'nama_event'            => 'required|unique:registrasi_event,nama_event',
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
                    'deskripsi_event'       => 'required',
                    'url_event'             => 'required',
                    'jenis_event'           => 'required',
                    'biaya_pendaftaran.*'   => 'numeric|required_if:biayaCheck,==,1',
                    'tgl_pendaftaran.*'     => 'date|required_if:biayaCheck,==,1',
                    'tgl_pembayaran.*'      => 'date|required_if:biayaCheck,==,1',
                    'jumlah_peserta'        => 'numeric|required_if:pesertaCheck,==,1',
                    'e_poster'              => 'required|image|mimes:jpg,png,jpeg||max:2048',
                ],$messages);
                
                //pembuatan direktori pada server
                if (!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path,777, true);
                }
                
                //pembuatan nama file
                $nama = str_replace(' ', '_', $request->nama_event);
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
                $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
                
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
                    'deskripsi_event' => $request->deskripsi_event,
                    'url_event' => $request->url_event,
                    'url_lain' => $request->url_lain,
                    'id_eo' => $id_eo,
                    'id_jenis_event' => $request->jenis_event,
                    'sponsor' => $request->sponsor,
                    'jumlah_peserta' => $request->jumlah_peserta,
                    'e_poster' => $fileName,
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

                //send email
                $isi = $regis;
                Mail::to(Session::get('data')['email'])->send(new SendMailable($isi));

            } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('failed', 'Event gagal diupdate');
        }
            DB::commit();
            return redirect()->route('event.index', [Session::get('data')['id_anggota']])
                    ->with('success', 'Event berhasil diupdate');
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
        return  view('event.edit', compact('provinsi', 'eo', 'event', 'jenis_pembayaran', 'kota', 'kecamatan', 'desa', 'eventPortal'));
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
                    'kode_event'            => 'required|unique:registrasi_event,kode_event,'.$evt->kode_event.',kode_event',
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
                    'deskripsi_event'       => 'required',
                    'url_event'             => 'required',
                    'jenis_event'           => 'required',
                    'biaya_pendaftaran.*'   => 'numeric|required_if:biayaCheck,==,1',
                    'tgl_pendaftaran.*'     => 'date|required_if:biayaCheck,==,1',
                    'tgl_pembayaran.*'      => 'date|required_if:biayaCheck,==,1',
                    'jumlah_peserta'        => 'numeric|required_if:pesertaCheck,==,1',
                    'e_poster'              => 'required_without:e_poster_value|image|mimes:jpg,png,jpeg||max:2048',
                ],$messages);

                //jika ada gambar maka buat folder
                if(!empty($request->file('e_poster'))){
                    if (!File::isDirectory($this->path)) {
                        File::makeDirectory($this->path,777, true);
                    }
                    
                    //pembuatan nama file image
                    $nama = str_replace(' ', '_', $request->nama_event);
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
                    $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
                    
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
                        'deskripsi_event' => $request->deskripsi_event,
                        'url_event' => $request->url_event,
                        'url_lain' => $request->url_lain,
                        'id_eo' => $id_eo,
                        'id_jenis_event' => $request->jenis_event,
                        'sponsor' => $request->sponsor,
                        'jumlah_peserta' => $request->jumlah_peserta,
                        'e_poster' => $fileName,
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

                    
                //jika update tanpa foto
                }else{

                    //get data eo
                    $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
                    
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
                        'deskripsi_event' => $request->deskripsi_event,
                        'url_event' => $request->url_event,
                        'url_lain' => $request->url_lain,
                        'id_eo' => $id_eo,
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

                }

                //get data registrasi event utk attribute di email
                $regis = RegistrasiEventModel::where('id', $evt->id)->first();
                $isi = $regis;

                //send email
                Mail::to(Session::get('data')['email'])->send(new SendMailable($isi));

            } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            return redirect()->back()
               ->with('failed', 'Event gagal diupdate');
        }
        DB::commit();
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
            'tanggal_daftar_baru.different' => 'tanggal daftar harus berbeda dengan yang sebelumnya !!!',
            'tanggal_bayar_baru.different' => 'tanggal bayar harus berbeda dengan yang sebelumnya !!!',
            'harga_baru.different' => 'harga harus berbeda dengan yang sebelumnya !!!',
            'numeric'   => ':attribute harus diisi dengan angka !!!',
        ];

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

        DB::beginTransaction();
        try {

            //kode eo
            $eo = $id;

            //get data event
            $event = RegistrasiEventModel::where('kode_event', 'LIKE', '%'.$request->kode_event.'%')->first();

            //update kuota event jika kuota sebelumnya tidak sama dengan kuota sekarang
            if($event->jumlah_peserta != $request->kuota_baru){
                RegistrasiEventModel::find($event->id)->update(['jumlah_peserta' => $request->kuota_baru, 'status' => '1']);
            }

            //get detail event dan update
            RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->update([
                'tanggal_ekstra' => $request->tanggal_daftar_barus, 
                'tanggal_bayar_ekstra' => $request->tanggal_bayar_baru, 
                'harga_ekstra' => $request->harga_baru, 
                'updated_by' => Session::get('data')['id_anggota'], 
                'updated_at' => date('Y-m-d H:i:s')
            ]);
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
}
