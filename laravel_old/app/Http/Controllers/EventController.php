<?php

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

class EventController extends Controller
{
    public $path;
    public $dimensions;
    public $event;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->path = public_path('images/event');
        //DEFINISIKAN DIMENSI
        $this->dimensions = ['245', '300', '500'];
    }

    public function index($id)
    {   
        RegistrasiEventModel::where('tanggal_mulai', '<', date('Y-m-d H:i:s'))->update(['status' => '0']);
        $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
        
        $data = DB::table('registrasi_event')
                ->select('registrasi_event.*', 'registrasi_eo.nama')
                ->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id')
                ->where('registrasi_eo.id', $id_eo)
                ->orderBy('registrasi_event.tanggal_mulai', 'DESC')
                ->get();
        // dd($data);
        $peserta = DB::table('registrasi_peserta_event')->select(DB::raw('COUNT(id) AS jml'), 'id_event')->groupBy('id_event')->pluck('jml', 'id_event')->toArray();
        $pesertaByr = DB::table('registrasi_peserta_event')->select(DB::raw('COUNT(id) AS jml'), 'id_event')->where('is_free', 'tidak')->where('status_pembayaran', '2')->groupBy('id_event')->pluck('jml', 'id_event')->toArray();
        return view('event.index', compact('id','data', 'peserta', 'pesertaByr'));
    }

    public function create($id)
    {
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);

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
                    // 'array'     => ':attribute harus diisi dengan angka !!!',
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
                    // 'url_lain'              => 'required',
                    'jenis_event'           => 'required',
                    'biaya_pendaftaran.*'   => 'numeric|required_if:biayaCheck,==,1',
                    'tgl_pendaftaran.*'     => 'date|required_if:biayaCheck,==,1',
                    'tgl_pembayaran.*'      => 'date|required_if:biayaCheck,==,1',
                    'jumlah_peserta'        => 'numeric|required_if:pesertaCheck,==,1',
                    'e_poster'              => 'required|image|mimes:jpg,png,jpeg||max:2048',
                ],$messages);
                
                

                if (!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path,777, true);
                }
                
                $nama = str_replace(' ', '_', $request->nama_event);
                $file = $request->file('e_poster');
                $fileName = Carbon::now()->timestamp . '_' . $nama . '.' . $file->getClientOriginalExtension();
                Image::make($file)->save($this->path . '/' . $fileName);
            
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
                
                $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
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
                
                if($request->biaya_pendaftaran != null){
                    foreach($request->biaya_pendaftaran AS $k => $v){
                        RegistrasiEventJenisPembayaranModel::create([
                            'id_event' => $regis->id,
                            'jenis_pembayaran' => $k,
                            'tanggal' => $request->tgl_pendaftaran[$k],
                            'tanggal_bayar' => $request->tgl_pembayaran[$k],
                            'harga' => $v,
                        ]);
                    }
                }


                $isi = 'ini adalah isi dari event nya';
                Mail::to('eventorganizer@portalsepeda.com')->send(new SendMailable($isi));

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
        
        $kode_event = strtolower(str_replace("-"," ",$kode_event));
        $event = RegistrasiEventModel::where('kode_event', 'LIKE', $kode_event)->first();

        if($event == null){
            return abort(404);
        }else{
            if(date('Y-m-d H:i:s') > $event->tanggal_mulai){
                return abort(404);
            }
        }
        $jenis_pembayaran = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->get();
        $eventPortal = EventPortalSepeda::where('status', '1')->get(); //get from form wordpress
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);
        $respKota = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$event->id_provinsi.'.json')->get();
        $kota = json_decode($respKota, true);
        $respKec = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kecamatan/'.$event->id_kota.'.json')->get();
        $kecamatan = json_decode($respKec, true);
        $respDesa = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kelurahan/'.$event->id_kecamatan.'.json')->get();
        $desa = json_decode($respDesa, true);
        return  view('event.edit', compact('provinsi', 'eo', 'event', 'jenis_pembayaran', 'kota', 'kecamatan', 'desa', 'eventPortal'));
    }

    public function update(Request $request, $eo, $kode_event)
    {
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
                if(!empty($request->file('e_poster'))){
                    if (!File::isDirectory($this->path)) {
                        File::makeDirectory($this->path,777, true);
                    }
                    
                    $nama = str_replace(' ', '_', $request->nama_event);
                    $file = $request->file('e_poster');
                    $fileName = Carbon::now()->timestamp . '_' . $nama . '.' . $file->getClientOriginalExtension();
                    unlink($this->path . '/' . $fileName);
                    unlink($this->path . '/245/' . $fileName);
                    unlink($this->path . '/300/' . $fileName);
                    unlink($this->path . '/500/' . $fileName);

                    Image::make($file)->save($this->path . '/' . $fileName);
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

                    $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
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

                    if(!isset($request->biayaCheck)){
                        RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->delete();
                    }

                    
                }else{
                    $id_eo = DB::table('registrasi_eo')->select('id')->where('id_member', Session::get('data')['id_anggota'])->value('id');
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

                    if(!isset($request->biayaCheck)){
                        RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->delete();
                    }

                }

                $isi = 'ini adalah isi dari event yg telah diupdate ya';
                Mail::to(Session::get('data')['email'])->send(new SendMailable($isi));

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
    
            
    public function show (Request $request, $eo, $kode_event){
        $evt = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
        $eventPortal = EventPortalSepeda::where('status', '1')->pluck('name', 'id')->toArray();
        $jenisPembayaran = RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->value('harga');
        $user = User::where('ID', Session::get('data')['id_anggota'])->value('user_email');
        $hp_eo = DB::table('registrasi_eo')->select('no_hp_kontak')->where('id_member', Session::get('data')['id_anggota'])->value('no_hp_kontak');
        return view('event.show', compact('evt', 'eo', 'eventPortal', 'jenisPembayaran', 'user', 'hp_eo'));
    } 
}
