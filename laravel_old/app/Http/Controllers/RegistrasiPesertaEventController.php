<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\Anggota; //Use Model Anggota
use App\Models\ProfileChecking; 
use App\Models\UserMeta; //Use Model User Meta
use App\Models\User; //Use Model User Meta
use App\Models\RegistrasiEventModel; //Use Model RegistrasiEventModel
use App\Models\EventPortalSepeda; //Use Model EventPortalSepeda
use App\Models\RegistrasiEventJenisPembayaranModel; //Use Model RegistrasiEventJenisPembayaranModel
use App\Models\RegistrasiPesertaEventModel; //Use Model RegistrasiPesertaEventModel
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

class RegistrasiPesertaEventController extends Controller
{
    
    public function index($kode_event, $id_peserta)
    {   
        $userCheckRegis = RegistrasiPesertaEventModel::where(DB::raw('md5(id_member)'), $id_peserta)->count();
        if($userCheckRegis > 0){
            return view('registrasi_peserta_event.frontend.terdaftar');
        }

        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);
        $id_users = User::where(DB::raw('md5(ID)'), $id_peserta)->first();
        $id = $id_users->ID;
        $userCheckProfile = ProfileChecking::select('v_checking_complete_profile.user_email','v_checking_complete_profile.display_name', 'v_checking_complete_profile.meta_key', 'v_checking_complete_profile.meta_value', 'guid')
                ->leftJoin('wp_posts', 'wp_posts.guid', '=', 'foto')
                ->where(DB::raw('md5(v_checking_complete_profile.ID)'), $id_peserta)
                ->get();
                if(count($userCheckProfile) > 0){
                    foreach($userCheckProfile AS $k => $v){
                        $profil[$v->meta_key] = $v->meta_key == 'foto' ? $v->guid : $v->meta_value;
                    }
                    $profil['display_name'] = $userCheckProfile[0]['display_name']; 
                    $profil['user_email'] = $userCheckProfile[0]['user_email']; 
                }else{
                    $profil = null;
                }
        // dd($profil);
        $kotas = isset($profil['provinsi']) ? $profil['provinsi'] : '';
        $responses = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$kotas.'.json')->get();
        
        $kota = json_decode($responses, true);
        $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
        
        $respons = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$event->id_provinsi.'.json')->get();
        $kotaEvent = json_decode($respons, true);
        
        $respons = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kecamatan/'.$event->id_kota.'.json')->get();
        $kecEvent = json_decode($respons, true);
        
        $responce = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kelurahan/'.$event->id_kecamatan.'.json')->get();
        $kelEvent = json_decode($responce, true);
        
        $isFree = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->get();
        $isFreeActive = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->whereDate('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'DESC')->limit(1)->first();
        return view('registrasi_peserta_event.frontend.index', compact('kode_event', 'id_peserta', 'kecEvent', 'kelEvent', 'kotaEvent', 'isFreeActive', 'event', 'provinsi', 'id', 'userCheckProfile', 'profil', 'kota'));
    }

    /**
     * Fungsi Create ke database.
     */
    public function registrasi($kode_event, $id_peserta, Request $request)
    {
        DB::beginTransaction();
        try {
            // if(!isset($request->sk) || $request->sk == 'off'){
            //     return redirect()->back()
            //         ->with('failed', 'Pendaftaran event gagal');
            // }
            $userCheckRegis = RegistrasiPesertaEventModel::where(DB::raw('md5(id_member)'), $id_peserta)->count();
            if($userCheckRegis > 0){
                // return abort(404);
                return view('registrasi_peserta_event.frontend.terdaftar');
            }

            $messages = [
                'required'  => ':attribute harus di isi !!!',
                'min'       => ':attribute harus diisi minimal :min karakter !!!',
                'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                'digits'    => ':attribute harus diisi maksimal :digits karakter !!!',
                'between'    => ':attribute harus diisi minimal 10 karakter sampai dengan 15 karakter !!!',
            ];
            // Terima Data request kemudian validasi dulu
            $this->validate($request, [
                'nama'                  => 'required|',
                'panggilan'             => 'required',
                'jenis_kelamin'         => 'required',
                'tempat_lahir'          => 'required',
                'tanggal_lahir'         => 'required',
                'no_hp_kontak'          => 'required|numeric|digits_between:10,15',
                'no_wa_kontak'          => 'required|numeric|digits_between:10,15',
                'golongan_darah'        => 'required',
                'pekerjaan'             => 'required',
                'provinsi'              => 'required',
                'kota'                  => 'required',
                'alamat'                => 'required',
                'kode_pos'              => 'required', //tabel,atribut
                'nama_kontak'           => 'required',
                'hubungan_kontak'       => 'required',
                'no_telp'               => 'required|numeric|digits_between:10,15', //tabel,atribut
            ],$messages);

            $postVal[0] = $request->nama;
            $postVal[1] = $request->panggilan;
            $postVal[2] = $request->jenis_kelamin;
            $postVal[3] = $request->tempat_lahir;
            $postVal[4] = str_replace('-', '',$request->tanggal_lahir);
            $postVal[5] = $request->golongan_darah;
            $postVal[6] = $request->pekerjaan;
            $postVal[7] = $request->provinsi;
            $postVal[8] = $request->kota;
            $postVal[9] = $request->alamat;
            $postVal[10] = $request->kode_pos;
            $postVal[11] = $request->no_hp_kontak;
            $postVal[12] = $request->no_wa_kontak;
            
            $post[0] = "nama";
            $post[1] = "panggilan";
            $post[2] = "jenis_kelamin";
            $post[3] = "tempat_lahir";
            $post[4] = "tanggal_lahir";
            $post[5] = "golongan_darah";
            $post[6] = "pekerjaan";
            $post[7] = "provinsi";
            $post[8] = "kota";
            $post[9] = "alamat";
            $post[10] ="kode_pos";
            $post[11] ="no_hp_kontak";
            $post[12] ="no_wa_kontak";

            $id_users = User::where(DB::raw('md5(ID)'), $id_peserta)->first();
            foreach($post AS $k => $v){
                $meta_key[$v] = $postVal[$k]; 
                $createUser = UserMeta::updateOrCreate([
                        'user_id' => $id_users->ID,
                        'meta_key' => $v,
                    ], [
                        'meta_value' => $postVal[$k],
                    ]);
            }

                $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
                $jml = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->first();
                $regis = RegistrasiPesertaEventModel::create([
                    'id_event' => $event->id,
                    'id_member' => $id_users->ID,
                    'tanggal' => date('Y-m-d H:i:s'),
                    'nama_kontak' => $request->nama_kontak,
                    'hubungan_kontak' => $request->hubungan_kontak,
                    'no_telp' => $request->no_telp,
                    'is_free' => isset($request->harga) ? 'tidak' : 'ya',
                    'status_pembayaran' => '0',
                    // 'jumlah_bayar' => isset($request->harga) ? $request->harga : NULL,
                    'jumlah_bayar' => ($jml == null) > 0 ? $jml->harga : NULL,
                ]);

                $isi = 'Terima Kasih telah me-registrasi event '.strtoupper($event->nama_event);
                Mail::to($id_users->user_email)->send(new SendMailable($isi));

            } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return redirect()->to('https://portalsepeda.com')
                    ->with('failed', 'Event gagal dibuat');
        }
        DB::commit();
            return redirect()->to('https://portalsepeda.com')
                    ->with('success', 'Event berhasil dibuat');
    }


    public function dataTable()
    {
        $model = DB::table('registrasi_event')->select('registrasi_event.*', 'registrasi_eo.nama')->join('registrasi_eo', 'registrasi_event.id_eo', '=', 'registrasi_eo.id_member')->where('registrasi_eo.id_member', Session::get('data')['id_anggota'])->orderBy('registrasi_event.tanggal_mulai', 'DESC')->get();
        $eo = isset($model->first()->nama) ? str_replace(' ', '-', $model->first()->nama) : '';
        return DataTables::of($model)
            ->addColumn('action', function ($model) use  ($eo) {
                return view('layouts_app._action_anggota', [
                    'model' => $model,
                    // 'data' => $model
                    'url_show' => route('event.show', [$eo, strtolower(str_replace(" ","-",$model->kode_event))]),
                    'url_edit' => route('event.edit', [$eo, strtolower(str_replace(" ","-",$model->kode_event))]),
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
                        'id_eo' => Session::get('data')['id_anggota'],
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
                                'harga' => $v,
                            ]);
                        }
                    }

                    if(!isset($request->biayaCheck)){
                        RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->delete();
                    }

                    
                }else{
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
                        'id_eo' => Session::get('data')['id_anggota'],
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
                                'harga' => $v,
                            ]);
                        }
                    }

                    if(!isset($request->biayaCheck)){
                        RegistrasiEventJenisPembayaranModel::where('id_event', $evt->id)->delete();
                    }

                }

                $isi = 'ini adalah isi dari event yg telah diupdate ya';
                Mail::to('eventorganizer@portalsepeda.com')->send(new SendMailable($isi));

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
