<?php

/**
 * @author ryan saputro
 * @email ryansaputro52@gmail.com
 * @create date 2020-01-10 09:52:11
 * @modify date 2020-01-10 09:52:11
 * @desc 
 * 
 * semua proses registrasi event 
 * oleh member dilakukan 
 * di controller ini
 * 
 */

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
use App\Models\RegistrasiPesertaEventPembayaranModel; //Use Model RegistrasiPesertaEventPembayaranModel
use App\Models\RegistrasiEventJerseyModel ; //Use Model RegistrasiEventJerseyModel
use App\Models\Komunitas; //Use Model Komunitas
use DataTables; //Use Datatable Yajra server side 
use PDF; //Use DomPDF export
use URL; 
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
    public $bukti;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->bukti = public_path('images/member/bukti');
        //DEFINISIKAN DIMENSI
        $this->dimensions = ['245', '300', '500'];
    }

    public function index($kode_event, $id_peserta, Request $request)
    {   
        //get url utk yg peserta cuman liat listnya
        $url = explode("?", $_SERVER['REQUEST_URI']);

        //get data event
        $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();

        //checking utk tanggal daftar 
        $tanggalDaftar = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->first();

        //ambil data peserta sesaui dengan event
        $dataPeserta = RegistrasiPesertaEventModel::where('id_event', $event->id);

        //checking jika member sudah mendaftar event maka di redirect ke halaman terdaftar
        $check = $dataPeserta->where(DB::raw('md5(id_member)'), $id_peserta)->count();

        if($check > 0){
            
            //ambil data peserta sesuai dengan id member  dmn statusnya blm bayar
            $cekByr = $dataPeserta->where('status_pembayaran', '0')->count();
            
            //checking ke table registrasi peserta event pembayaran jika peserta sudah melakukan pembayaran 
            $dataByr = RegistrasiPesertaEventPembayaranModel::where(DB::raw('md5(id_member)'), $id_peserta)->where('id_event', $event->id)->first();
            
            //get data peserta yg mendaftar event
            $listPeserta = RegistrasiPesertaEventModel::select('portalse_nci_event_organizer.registrasi_peserta_event.*', 'portalse_nci_portal_1.wp_users.display_name', 'portalse_nci_portal_1.wp_users.ID', 'portalse_nci_portal_1.wp_users.user_email')
                ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_peserta_event.id_member')
                ->where('portalse_nci_event_organizer.registrasi_peserta_event.id_event', $event->id)
                ->get();
            
            //ambil data peserta
            $cekMember = $dataPeserta->first();
            
            //utk isi di tiketnya
            $email = DB::table('portalse_nci_portal_1.wp_users')->select('*')->where(DB::raw('md5(ID)'), $id_peserta)->first();
            
            //
            $pesertaTiket = RegistrasiPesertaEventModel::where('id_event', $event->id)->where(DB::raw('md5(id_member)'), $id_peserta)->first();

            //bank list 
            $bank = DB::table('daftar_bank')->get();
            return view('registrasi_peserta_event.frontend.terdaftar', compact('pesertaTiket', 'email', 'event', 'bank', 'tanggalDaftar', 'cekMember', 'dataByr', 'cekByr', 'listPeserta', 'kode_event', 'id_peserta'));
        
        }
        
        //peserta ga daftar tp cuman pengen liat listnya aja
        if(isset($url[1])){
            
            //jika url sama dengan peserta event
            if($url[1] == "daftar_peserta"){
                $except = $url[1];
                
                //get data peserta yg mendaftar event
                $listPeserta = RegistrasiPesertaEventModel::select('portalse_nci_event_organizer.registrasi_peserta_event.*', 'portalse_nci_portal_1.wp_users.display_name', 'portalse_nci_portal_1.wp_users.ID')
                    ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_peserta_event.id_member')
                    ->where('portalse_nci_event_organizer.registrasi_peserta_event.id_event', $event->id)
                    ->get();
                    
                return view('registrasi_peserta_event.frontend.terdaftar', compact('except', 'event','listPeserta', 'kode_event', 'id_peserta'));
            }
        }

        //get data peserta apakah sudah penuh kuota
        $checkPst = RegistrasiPesertaEventModel::where('id_event', $event->id);
        
        //get user
        $user = User::where(DB::raw('md5(ID)'), $id_peserta)->get();

        //checking event berbayar atau gratis
        $checkEvent = DB::table('registrasi_event')
                ->select('registrasi_event.id', 'registrasi_event_jenis_pembayaran.jenis_pembayaran', 'registrasi_event_jenis_pembayaran.harga')
                ->join('registrasi_event_jenis_pembayaran', 'registrasi_event.id', '=', 'registrasi_event_jenis_pembayaran.id_event')
                ->where('registrasi_event.id', $event->id)
                ->get();
        
        //checking jk gratis maka yg diambil batas tanggalnya di tanggal event
        if(count($checkEvent) == 0){

            //sebelum revisi tgl 10 db nya blm ada tgl pendaftaran
            // $tglEvent = date('Y-m-d',strtotime($event->tanggal_mulai));
            $tglEventAwal = $event->tanggal_awal_pendaftaran;
            $tglEventAkhir = $event->tanggal_akhir_pendaftaran;
        
        }else{

            //cek kalo tanggal event diupdate
            $tglEventAwal = $event->tanggal_awal_pendaftaran;
            $tglEventAkhir = $tanggalDaftar->tanggal_ekstra != null ? $tanggalDaftar->tanggal_ekstra : $event->tanggal_akhir_pendaftaran;

        }

            //get model jersey
            $model = RegistrasiEventJerseyModel::where('id_event', $event->id)->groupBy('model')->get();

            //get list komunitas
            $komunitas = Komunitas::all();

            //get API provinsi        
            $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
            $provinsi = json_decode($response, true);
            // $id = Auth::user()->toArray()['ID'];

            
            //checking kelengkapan profil member
            $userCheckProfile = ProfileChecking::select('v_checking_complete_profile.user_email','v_checking_complete_profile.display_name', 'v_checking_complete_profile.meta_key', 'v_checking_complete_profile.meta_value', 'guid')
                ->leftJoin('wp_posts', 'wp_posts.guid', '=', 'foto')
                ->where(DB::raw('md5(v_checking_complete_profile.ID)'), $id_peserta)
                ->get();
                
                
            //checking jika sudah melengkapi profile
            if(count($userCheckProfile) > 0){

                //loping profile utk mendapatkan semua data profile
                foreach($userCheckProfile AS $k => $v){
                    $profil[$v->meta_key] = $v->meta_key == 'foto' ? $v->guid : $v->meta_value;
                }

                //tambahan profile utk dimasukkan ke array
                $profil['display_name'] = $userCheckProfile[0]['display_name'] == '' ? $user[0]['display_name'] : $userCheckProfile[0]->display_name; 
                $profil['user_email'] = $userCheckProfile[0]['user_email'] == '' ? $user[0]['display_name'] : $userCheckProfile[0]->user_email ; 

            }else{
                
                //jika profile ga lengkap update null
                $profil['display_name'] = $user[0]['display_name'];
                $profil['user_email'] = $user[0]['user_email'];
                $profil['alamat'] = "";
                $profil['tanggal_lahir'] = "";
                $profil['golongan_darah'] = "";
                $profil['pekerjaan'] = "";
                $profil['no_wa_kontak'] = "";
                $profil['jenis_kelamin'] = "";
                $profil['foto'] = "";
                $profil['panggilan'] = "";
                $profil['tempat_lahir'] = "";
                $profil['provinsi'] = "";
                $profil['kota'] = "";
                $profil['kode_pos'] = "";
                $profil['no_hp_kontak'] = "";
            }
            //get data API provinsi dari server portalsepeda.com {note:salah variable harusnya provinsi bukan kota}
            $kotas = isset($profil['provinsi']) ? $profil['provinsi'] : '';
            $responses = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$kotas.'.json')->get();
            $kota = json_decode($responses, true);
            
            //get data API kota
            $respons = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$event->id_provinsi.'.json')->get();
            $kotaEvent = json_decode($respons, true);
            
            //get data API kecamatan
            $respons = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kecamatan/'.$event->id_kota.'.json')->get();
            $kecEvent = json_decode($respons, true);
            
            //get data API kelurahan
            $responce = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kelurahan/'.$event->id_kecamatan.'.json')->get();
            $kelEvent = json_decode($responce, true);
            
            //get data event jenis pembayaran (normal, early bird ataupun on the spot) jika event gratis ga insert data ke registrasi event jenis pembayaran
            $isFree = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->get();
            // $isFreeActive = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->whereDate('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'DESC')->limit(1)->first();
            $isFreeActive = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->orderBy('tanggal', 'DESC')->limit(1)->first();
            
            //get date now
            $now = date('Y-m-d H:i:s');
            
            //checking jika event ada kuota jumlah peserta
            if($event->jumlah_peserta != null){

                //checking jika jumlah pendaftar lebih besar sama dengan kuota
                if($checkPst->count() >= $event->jumlah_peserta){
                    
                    //checking jika tanggal dan kuota event sudah melebihi batas maka event menjadi ditutup
                    if(($now >= $tglEventAkhir)){

                        //update registrasi event
                        RegistrasiEventModel::where('id', $event->id)->update(['status' => '2']);
                        return view('registrasi_peserta_event.frontend.tutup', compact('event'));
                    }else if($checkPst->count() >= $event->jumlah_peserta){
                    
                        //update registrasi event
                        RegistrasiEventModel::where('id', $event->id)->update(['status' => '2']);
                        return view('registrasi_peserta_event.frontend.tutup', compact('event'));
                        
                    }else{
                        
                        //jika masi ada kuota maka bisa daftar
                        return view('registrasi_peserta_event.frontend.index', compact('model', 'komunitas', 'kode_event', 'id_peserta', 'kecEvent', 'kelEvent', 'kotaEvent', 'isFreeActive', 'event', 'provinsi', 'userCheckProfile', 'profil', 'kota'));                
                    }

                }else{
                    if(($now >= $tglEventAkhir)){

                        //update registrasi event
                        RegistrasiEventModel::where('id', $event->id)->update(['status' => '2']);
                        return view('registrasi_peserta_event.frontend.tutup', compact('event'));
                        
                    }else if($checkPst->count() >= $event->jumlah_peserta){
                    
                        //update registrasi event
                        RegistrasiEventModel::where('id', $event->id)->update(['status' => '2']);
                        return view('registrasi_peserta_event.frontend.tutup', compact('event'));
                    
                    }else{

                        //jika masi ada kuota maka bisa daftar
                        return view('registrasi_peserta_event.frontend.index', compact('model', 'komunitas', 'kode_event', 'id_peserta', 'kecEvent', 'kelEvent', 'kotaEvent', 'isFreeActive', 'event', 'provinsi', 'userCheckProfile', 'profil', 'kota'));                }

                    }
            }else{

                if(($now >= $tglEventAkhir)){

                    //update registrasi event
                    RegistrasiEventModel::where('id', $event->id)->update(['status' => '2']);
                    return view('registrasi_peserta_event.frontend.tutup', compact('event'));

                }else{

                    //jika masi ada kuota maka bisa daftar
                    return view('registrasi_peserta_event.frontend.index', compact('model', 'komunitas', 'kode_event', 'id_peserta', 'kecEvent', 'kelEvent', 'kotaEvent', 'isFreeActive', 'event', 'provinsi', 'userCheckProfile', 'profil', 'kota'));                
                }

            }
            
    }

    //peserta melakukan registrasi dihalaman depan
    public function registrasi($kode_event, $id_peserta, Request $request)
    {
        DB::beginTransaction();
        try {
            // if(!isset($request->sk) || $request->sk == 'off'){
            //     return redirect()->back()
            //         ->with('failed', 'Pendaftaran event gagal mohon untuk mencentang syarat dan ketentuan');
            // }
            // $userCheckRegis = RegistrasiPesertaEventModel::where(DB::raw('md5(id_member)'), $id_peserta)->count();
            // dd($userCheckRegis);
            // //checking jika user sudah terdaftar di redirect ke halaman terdaftar
            // if($userCheckRegis > 0){
            //     return redirect()->route('event.dashboard', [$kode_event, $id_peserta]);
            // }

            $messages = [
                'required'  => ':attribute harus di isi !!!',
                'min'       => ':attribute harus diisi minimal :min karakter !!!',
                'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                'digits'    => ':attribute harus diisi maksimal :digits karakter !!!',
                'digits_between'    => ':attribute harus diisi minimal 10 karakter dan maksimal 15 karakter !!!',
                'required_if'    => 'anda harus memilih :attribute jersey !!!',
                'sk.required' => 'anda harus mencontreng kolom persetujuan syarat dan ketentuan !!!'
            ];

            // Terima Data request kemudian validasi dulu
            $this->validate($request, [
                'sk'                  => 'required|',
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
                'ukuran'                => 'required_if:AdaJersey,==,ada',
                'model'                 => 'required_if:AdaJersey,==,ada',
                'komunitas'             => 'required',
                'no_telp'               => 'required|numeric|digits_between:10,15', //tabel,atribut
            ],$messages);

            //membuat requestan dr view diubah menjadi array utk di looping 
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

            //select peserta dari table user sesuai dgn id yg di encrypt
            $id_users = User::where(DB::raw('md5(ID)'), $id_peserta)->first();
            
            //update kelengkapan member 
            foreach($post AS $k => $v){
                $createUser = UserMeta::updateOrCreate(
                    [
                        'user_id' => $id_users->ID,
                        'meta_key' => $v,
                    ],[
                        'meta_value' => $postVal[$k],
                    ]);

                $arr[$v] =  $postVal[$k]; 
            }
            //get data event dari kode event
            $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
            
            //get data eo
            $eo = DB::table('portalse_nci_event_organizer.registrasi_eo')
                ->select('user_email','kode_event','id_member', 'no_wa_kontak', 'nama', 'no_rekening', 'pemilik_rekening', 'nama_bank', 'nama_event')
                ->join('portalse_nci_event_organizer.registrasi_event', 'registrasi_eo.id', '=', 'registrasi_event.id_eo')
                ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_eo.id_member')
                ->where('registrasi_event.id', $event->id)
                ->first();

            //insert ke db registrasi peserta    
            $regis = RegistrasiPesertaEventModel::create([
                'id_event' => $event->id,
                'id_member' => $id_users->ID,
                'tanggal' => date('Y-m-d H:i:s'),
                'nama_kontak' => $request->nama_kontak,
                'hubungan_kontak' => $request->hubungan_kontak,
                'no_telp' => $request->no_telp,
                'is_free' => isset($request->harga) ? 'tidak' : 'ya',
                'status_pembayaran' => '0',
                'jumlah_bayar' => isset($request->harga) ? $request->harga : NULL,
                'komunitas' => $request->komunitas, 
                'model_jersey' => isset($request->model) ? $request->model : NULL,
                'size_jersey' => isset($request->ukuran) ? $request->ukuran : NULL ,
                'status_pendaftaran' => '1',
            ]);
            
            //generate no unik
            if(!isset($request->harga)){
                $kdGr = isset($request->harga) ? 'PAY' : 'FR';
                $peserta = RegistrasiPesertaEventModel::find($regis->id)->update(['no_unik' => strtoupper(str_replace('-', ' ', $kode_event)).$kdGr.$regis->id]);    
            }
            
            
            //get data from API provinsi
            $kotas = $request->provinsi;
            $responses = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$kotas.'.json')->get();
            $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
            $provinsi = json_decode($response, true);
            
            //membuat data API menjadi array
            $kota = json_decode($responses, true);
            foreach($kota AS $k => $v){
                $kota[$v['id']] =  $v['nama'];
            }

            //membuat data API menjadi array
            foreach($provinsi AS $k => $v){
                $provinsi[$v['id']] =  $v['nama'];
            }
            
            

            //membuat array untuk send email di file SendMail.php
            $arr['kota'] = array_key_exists($request->kota, $kota) ? $kota[$request->kota] : '-';
            $arr['provinsi'] = array_key_exists($request->provinsi, $provinsi) ? $provinsi[$request->provinsi] : '-';
            $arr['email'] = $id_users->user_email;
            $data['diri'] = $arr;
            $data['event'] = array('no_telp' => $request->no_telp, 'nama_kontak' => $request->nama_kontak,'hubungan_kontak' => $request->hubungan_kontak);
            $data['nama_event'] = strtoupper($event->nama_event);
            $data['eo'] = strtoupper($eo->nama);
            $data['isi'] ='Terima Kasih anda telah melakukan registrasi untuk mengikuti event '.strtoupper($event->nama_event). '. Adapun data yang anda isikan ke dalam form registrasi kami adalah sebagai berikut:';
            $data['penutup'] = 'Jika Benar, bahwa anda melakukan registrasi untuk mengikuti event '.strtoupper($event->nama_event).', harap klik link berikut :';
            $data['link'] = URL::to('/event/'.$kode_event.'/'.$id_peserta.'/konfirmasi');
            $data['_penutup'] = 'untuk mengkonfirmasi data pendaftaran ini.';
            $SendEmailUser = Mail::to($id_users->user_email)->bcc($eo->user_email)->send(new SendMailable($data, 'user'));
            // $SendEmailEo = Mail::to(Session::get('data')['email'])->send(new SendMailable($data, 'eo'));
        
            } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollback();
                dd($ex->getMessage());
                return redirect()->to('https://portalsepeda.com')
                    ->with('failed', 'Registrasi event gagal');
        }
            DB::commit();
            
            return redirect()->to('https://eo.portalsepeda.com/event/'.$kode_event.'/'.$id_peserta)
                    ->with('success', 'Registrasi event berhasil');
    }

    public function buktiBayar(Request $request, $kode_event, $id_peserta)
    {
            $messages = [
                'required'  => ':attribute harus di isi !!!',
                'min'       => ':attribute harus diisi minimal :min karakter !!!',
                'max'       => ':attribute harus diisi maksimal :max kb !!!',
                'digits'    => ':attribute harus diisi maksimal :digits karakter !!!',
            ];
            // Terima Data request kemudian validasi dulu
            $this->validate($request, [
                'bukti'            => 'required|image|mimes:jpg,png,jpeg||max:1048',
                'bank'             => 'required',
                'atas_nama'        => 'required',
            ],$messages);

            DB::beginTransaction();
            try {

                //get data event dari kode event
                $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
                
                //get data user dari id member yang di encrypt
                $id_users = User::where(DB::raw('md5(ID)'), $id_peserta)->first();
                
                //get data utk harga event
                $isFree = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->first();
                
                //membuat folder bukti di server
                if (!File::isDirectory($this->bukti)) {
                    File::makeDirectory($this->bukti,777, true);
                }

                //membuat nama file
                $nama = strtoupper(str_replace(' ', '_', $event->nama_event)).'_'.strtoupper(str_replace(' ', '_', $request->atas_nama));
                $file = $request->file('bukti');
                $fileName = Carbon::now()->timestamp . '_' . $nama . '.' . $file->getClientOriginalExtension();
                
                //menyimpan image di server
                Image::make($file)->save($this->bukti . '/' . $fileName);
                
                //membuat dimensi image
                foreach ($this->dimensions as $row) {
                    $canvas = Image::canvas($row, $row);
                    $resizeImage = Image::make($file)->resize($row, $row, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                
                    if (!File::isDirectory($this->bukti . '/' . $row)) {
                        File::makeDirectory($this->bukti . '/' . $row);
                    }
                
                    $canvas->insert($resizeImage, 'center');
                    $canvas->save($this->bukti . '/' . $row . '/' . $fileName);
                }

                //get data no registrasi member
                $regisMember = RegistrasiPesertaEventModel::where('id_event', $event->id)->where('id_member', $id_users->ID)->first();

                //get data kelengkapan member
                $userCheckProfile = ProfileChecking::select('v_checking_complete_profile.user_email','v_checking_complete_profile.display_name', 'v_checking_complete_profile.meta_key', 'v_checking_complete_profile.meta_value', 'guid')
                    ->leftJoin('wp_posts', 'wp_posts.guid', '=', 'foto')
                    ->where(DB::raw('md5(v_checking_complete_profile.ID)'), $id_peserta)
                    ->get();
                
                //get data eo
                $eo = DB::table('portalse_nci_event_organizer.registrasi_eo')
                    ->select('user_email AS email_eo','kode_event','id_member', 'no_wa_kontak', 'nama', 'no_rekening', 'pemilik_rekening', 'nama_bank', 'nama_event')
                    ->join('portalse_nci_event_organizer.registrasi_event', 'registrasi_eo.id', '=', 'registrasi_event.id_eo')
                    ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_eo.id_member')
                    ->where('registrasi_event.id', $event->id)
                    ->first();
                
                //checking dan membuat kelengkapan member menjadi array
                if(count($userCheckProfile) > 0){
                    foreach($userCheckProfile AS $k => $v){
                        $profil[$v->meta_key] = $v->meta_key == 'foto' ? $v->guid : $v->meta_value;
                    }
                    $profil['display_name'] = $userCheckProfile[0]['display_name']; 
                    $profil['user_email'] = $userCheckProfile[0]['user_email']; 
                }else{
                    $profil = null;
                }

                //no unik di generate dengan format kode_event_  id_bayar
                $noHp = substr($profil['no_hp_kontak'], -3);
                $thn = date('Y');
                $id_event = strtoupper($event->kode_event);
                $id_member = $id_users->ID;

                //insert ke db table registrasi peserta event
                $save = RegistrasiPesertaEventPembayaranModel::create([
                    'id_event' => $event->id,
                    'id_member' => $id_users->ID,
                    'bank' => $request->bank,
                    'atas_nama' => $request->atas_nama,
                    'bukti' => $fileName,
                    'jumlah' => $isFree == null ? 0 : $isFree->harga,
                ]);

                //get data pembayaran peserta
                $dbayar = RegistrasiPesertaEventPembayaranModel::find($save->id);
                $dataByr = $dbayar->first();
                
                
                //get data registrasi peserta
                $pst = RegistrasiPesertaEventModel::where('id_event', $event->id)->where('id_member', $id_users->ID)->first();

                //send email ke member dan bcc ke eo
                $memberByr = Mail::to($id_users->user_email)->bcc($eo->email_eo)->send(new SendMailable($event, 'cek_bukti', $dataByr, $pst));

            } catch (\Illuminate\Database\QueryException $ex) {
                //throw $th;
                DB::rollback();
                dd($ex->getMessage());
                return redirect()->route('event.dashboard', [$kode_event, $id_peserta])
                    ->with('failed', 'Upload bukti pembayaran gagal');
            }
                DB::commit();
                return redirect()->route('event.dashboard', [$kode_event, $id_peserta])
                    ->with('success', 'Upload bukti pembayaran sukses');

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

    //peserta melakukan konfirmasi dari halaman yg dikirim oleh admin eo ke email peserta
    public function konfirmasi($kode_event, $id_peserta)
    {
        $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
        $id_users = User::where(DB::raw('md5(ID)'), $id_peserta)->first();
        DB::beginTransaction();
        try {

            //code...
            RegistrasiPesertaEventModel::where('id_event', $event->id)->where('id_member', $id_users->ID)->update([
                'konfirmasi' => '1',
                'ip_address' => \Request::ip(),
                'tanggal_konfirmasi' => date('Y-m-d H:i:s')
            ]); 

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            DB::rollback();
            dd($ex->getMessage());
            return redirect()->route('event.pembayaran', [$kode_event, $id_peserta])
                ->with('failed', 'Konfirmasi event gagal');
        }
            DB::commit();
            return redirect()->route('event.pembayaran', [$kode_event, $id_peserta])
                ->with('success', 'Konfirmasi event sukses');

    }

    public function pembayaran($kode_event, $id_peserta)
    {
        //get data member
        $id_users = User::where(DB::raw('md5(ID)'), $id_peserta)->first();
        
        //get data event
        $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $kode_event)))->first();
        
        //get data atrribut event
        $isFreeActive = RegistrasiEventJenisPembayaranModel::where('id_event', $event->id)->whereDate('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'DESC')->limit(1)->first();

        //get data eo
        $eo = DB::table('portalse_nci_event_organizer.registrasi_eo')
            ->select('user_email','kode_event','id_member', 'no_wa_kontak', 'nama', 'no_rekening', 'pemilik_rekening', 'nama_bank', 'nama_event')
            ->join('portalse_nci_event_organizer.registrasi_event', 'registrasi_eo.id', '=', 'registrasi_event.id_eo')
            ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_eo.id_member')
            ->where('registrasi_event.id', $event->id)
            ->first();
 
        //checking jika event gratis
        if($isFreeActive ==  null){
            return redirect()->to(URL::to('/event/'.strtolower($event->kode_event).'/'.$id_peserta))
                    ->with('success', 'Registrasi event berhasil');
            // return view('registrasi_peserta_event.frontend.expired');
        }

        //send email ke member dan bcc ke eo
        $memberByr = Mail::to($id_users->user_email)->bcc($eo->user_email)->send(new SendMailable($eo, 'bayar', $isFreeActive, $id_users));
        return view('registrasi_peserta_event.frontend.bayar', compact('isFreeActive', 'eo', 'id_users'));
    }

    public function getAjaxJersey(Request $request)
    {
        //get data event dari kode event
        $event = RegistrasiEventModel::where('kode_event', strtoupper(str_replace('-', ' ', $request->kode_event)))->first();
        
        //get jersey
        $jersey = RegistrasiEventJerseyModel::select('id', 'model', 'ukuran', 'size')->where('id_event', $event->id)->where('model', 'LIKE', $request->model)->get();
        
        return response()->json(['status' => 200, 'data' => $jersey]);
    }

    public function payment(Request $request)
    {
        $messages = [
                'required'  => ':attribute harus di isi !!!',
                'min'       => ':attribute harus diisi minimal :min karakter !!!',
                'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                'digits'    => ':attribute harus diisi maksimal :digits karakter !!!',
                'digits_between'    => ':attribute harus diisi minimal 10 karakter dan maksimal 15 karakter !!!',
                'required_if'    => 'anda harus memilih :attribute jersey !!!',
                'sk.required' => 'anda harus mencontreng kolom persetujuan syarat dan ketentuan !!!'
            ];

            // Terima Data request kemudian validasi dulu
            $this->validate($request, [
                'sk'                  => 'required|',
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
                'ukuran'                => 'required_if:AdaJersey,==,ada',
                'model'                 => 'required_if:AdaJersey,==,ada',
                'komunitas'             => 'required',
                'no_telp'               => 'required|numeric|digits_between:10,15', //tabel,atribut
            ],$messages);

        $users = User::where('user_email', $request->email)->first();
        $profil = ProfileChecking::where('ID', $users->ID)->where('meta_key', 'no_wa_kontak')->first();
        $end = date('YmdHis');
        $data = array( 
                    'amount' => (int)$request->harga,
                    'cust_email' => $request->email,
                    'cust_id' => $users->ID,
                    'cust_msisdn' => "62".(int)$profil->meta_value,
                    'cust_name' => $request->nama,
                    'failed_url' => 'https://sandbox.finpay.co.id/servicescode/simulator/result/resultfailed.php',
                    'invoice' => 'INV1000000',
                    'items' => "XXX",
                    'mer_signature' => '3ad962bdabe53f9daeaafe745eb0df56930b9b57e703a2fef1769194dd710da5',
                    'merchant_id' => 'PSD2660',
                    'return_url' => 'http://localhost/eo/event/axa/e4da3b7fbbce2345d7772b0674a318d5',
                    'success_url' => 'https://sandbox.finpay.co.id/servicescode/simulator/result/resultsuccess.php',
                    'timeout' => 100,
                    'trans_date' => (int)$end,
                    'add_info1' => 'pay register event',
                    'add_info2' => $request->nama,
                    'add_info3' => $request->nama,
                    'add_info4' => $request->nama,
                    'add_info5' => $request->nama,
                    'back_url' => '',
        );
        // Send a POST request to: http://www.foo.com/bar with arguments 'foz' = 'baz' using JSON
        $response = Curl::to('https://sandbox.finpay.co.id/servicescode/api/pageFinpay.php')
            ->withData($data)
            ->asJson()
            ->post();
            var_dump($data);
            return response()->json(['response' => $response]);
            // print_r($profil->meta_value);
            // dd($request->all());
    }
}
