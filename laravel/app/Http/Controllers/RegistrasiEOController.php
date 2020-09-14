<?php
/**
 * @author ryan saputro
 * @email ryansaputro52@gmail.com
 * @create date 2020-01-10 11:35:54
 * @modify date 2020-01-10 11:35:54
 * @desc 
 * 
 * modul pembuatan eo
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //query builder laravel
use App\Models\Anggota; //Use Model Anggota
use App\Models\ProfileChecking; 
use App\Models\UserMeta; //Use Model User Meta
use App\Models\RegistrasiEoModel; //Use Model RegistrasiEo
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

class RegistrasiEOController extends Controller
{
    public $logo;
    public $identitas;
    public $buku_tabungan;
    public $dimensions;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->logo = public_path('images/eo/logo');
        $this->identitas = public_path('images/eo/identitas');
        $this->buku_tabungan = public_path('images/eo/buku_tabungan');
        //DEFINISIKAN DIMENSI
        $this->dimensions = ['245', '300', '500'];
    }

    /**
     * Menampilkan Fungsi Utama Modul Anggota
     */
    
    public function index()
    {   
        if(Auth::user() == null):
        // $checkEo = DB::
            return redirect('/');
        
        elseif(Auth::user() != null):
            //get data eo dan jadikan ke array
            $data = DB::table('registrasi_eo')->select('*')->where('id_member', Auth::user()->ID)->get()->toArray();
            
            //jika member sudah terdaftar jadi eo maka ambil data
            if(count($data) > 0){
                
                //set session
                Session::put('group_name', 'anggota');
                Session::put('data', array('id_anggota' => Auth::user()->toArray()['ID'], 'full_name' => $data[0]->nama, 'foto' => $data[0]->logo, 'email' => Auth::user()->toArray()['user_email']));
                Session::put('login',TRUE);
    
                return redirect('/dashboard');
            }
        endif;
        
        //get data API provinsi
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);
        
        //utk id form
        $id = Auth::user()->ID;
        
        //checking kelengkapan profile
        $userCheckProfile = ProfileChecking::select('v_checking_complete_profile.meta_key', 'v_checking_complete_profile.meta_value', 'guid')->leftJoin('wp_posts', 'wp_posts.guid', '=', 'foto')->where('v_checking_complete_profile.ID', $id)->get();
        if(count($userCheckProfile) > 0){
            foreach($userCheckProfile AS $k => $v){
                $profil[$v->meta_key] = $v->meta_key == 'foto' ? $v->guid : $v->meta_value;
            }
        }else{
            $profil = null;
        }
        
        //get data API kota dari id provinsi
        $kotas = isset($profil['provinsi']) ? $profil['provinsi'] : '';
        $responses = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$kotas.'.json')->get();
        $kota = json_decode($responses, true);

        return view('registrasi_eo.index', compact('provinsi', 'id', 'userCheckProfile', 'profil', 'kota'));
    }

    public function ajaxKota(Request $request)
    {
        //get data API kota dari id provinsi yg dipilih
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$request->id.'.json')->get();
        $provinsi = json_decode($response, true);
        return  response()->json(['getKota' => $provinsi]);
    }

    public function ajaxKecamatan(Request $request)
    {
        //get data API kecamatan dari kota yg dipilih
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kecamatan/'.$request->id.'.json')->get();
        $provinsi = json_decode($response, true);

        return  response()->json(['getKota' => $provinsi]);
    }

    public function ajaxKelurahan(Request $request)
    {
        //get data API kelurahan dari kecamatan yg dipilih 
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kelurahan/'.$request->id.'.json')->get();
        $kel = json_decode($response, true);
        return  response()->json(['getKota' => $kel]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
                $messages = [
                    'required'  => ':attribute harus di isi !!!',
                    'min'       => ':attribute harus diisi minimal :min kb !!!',
                    'max'       => ':attribute harus diisi maksimal :max kb !!!',
                    'digits_between'    => ':attribute harus diisi minimal 10 karakter dan maksimal 15 karakter !!!',
                    'numeric'    => ':attribute harus diisi menggunakan angka !!!',
                    'digits'    => ':attribute harus diisi 5 digit !!!',
                    'norek_pemilik.regex'    => 'pemilik rekening format tidak sesuai hanya boleh menggunakan abjad tidak boleh angka !!!',
                    'mimes'    => ':attribute format gambar tidak sesuai hanya boleh menggunakan .jpg, .png, ataupun .jpeg !!!',
                    'image'    => ':attribute harus berupa gambar !!!',
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
                    'kode_pos'              => 'required|numeric|digits:5', //tabel,atribut
                    'nama_eo'               => 'required|unique:registrasi_eo,nama',
                    'email_eo'              => 'required|string|email|max:255',
                    'kontak_eo'             => 'required',
                    'no_hp_kontak_eo'       => 'required|numeric|digits_between:10,15',
                    'no_wa_kontak_eo'       => 'required|numeric|digits_between:10,15',
                    'logo_eo'               => 'required|image|mimes:jpg,png,jpeg|max:512',
                    'provinsi_eo'           => 'required',
                    'kota_eo'               => 'required',
                    'kode_pos_eo'           => 'required|numeric|digits:5',
                    'identitas'             => 'required|image|mimes:jpg,png,jpeg|max:512',
                    'buku_tabungan'         => 'required|image|mimes:jpg,png,jpeg|max:512',
                    'identitas'             => 'required|image|mimes:jpg,png,jpeg|max:512',
                    'norek'                 => 'required|numeric',
                    'norek_pemilik'         => 'required|string|regex:/^[\pL\s\-]+$/u',
                    'bank'                  => 'required|string',
                ],$messages);

                //get data dari form yg diinput dan dijadikan ke array
                $postVal[0] = $request->nama;
                $postVal[1] = $request->panggilan;
                $postVal[2] = $request->jenis_kelamin;
                $postVal[3] = $request->tempat_lahir;
                $postVal[4] = $request->tanggal_lahir;
                $postVal[5] = $request->golongan_darah;
                $postVal[6] = $request->pekerjaan;
                $postVal[7] = $request->provinsi;
                $postVal[8] = $request->kota;
                $postVal[9] = $request->alamat;
                $postVal[10] = $request->kode_pos;
                $postVal[11] = $request->no_hp_kontak;
                $postVal[12] = $request->no_wa_kontak;
                
                //pembuatan array sesuai dengan kelengkapan profil member
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
                $id = Auth::user()->toArray()['ID'];

            //looping array diatas dan diinsert ke user meta yg berada di db wp
            foreach($post AS $k => $v){

                //update atau create kelengkapan user meta
                $createUser = UserMeta::updateOrCreate([
                        'user_id' => $id,
                        'meta_key' => $v,
                    ], [
                        'meta_value' => $postVal[$k],
                    ]);

                    //jika sukses insert
                    if($createUser){
                        $ins ="1";
                    }else{
                        $ins = "0";
                    }
            }

            //checking jika sukses insert atau update data kelengkapan member
            if($ins == '1'){

                //proses simpan logo di folder//
                if (!File::isDirectory($this->logo)) {
                    File::makeDirectory($this->logo,777, true);
                }
                        $nama = str_replace(' ', '_', $request->nama);
                        $file = $request->file('logo_eo');
                        $fileName = Carbon::now()->timestamp . '_' . $nama . '.' . $file->getClientOriginalExtension();
                        Image::make($file)->save($this->logo . '/' . $fileName);
                    
                        foreach ($this->dimensions as $row) {
                            $canvas = Image::canvas($row, $row);
                            $resizeImage = Image::make($file)->resize($row, $row, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        
                            if (!File::isDirectory($this->logo . '/' . $row)) {
                                File::makeDirectory($this->logo . '/' . $row);
                            }
                        
                            $canvas->insert($resizeImage, 'center');
                            $canvas->save($this->logo . '/' . $row . '/' . $fileName);
                        }

                //proses simpan identitas ke folder//
                if (!File::isDirectory($this->identitas)) {
                    File::makeDirectory($this->identitas,777, true);
                }
                        $nama = str_replace(' ', '_', $request->nama);
                        $files = $request->file('identitas');
                        $filesName = Carbon::now()->timestamp . '_' . $nama . '.' . $files->getClientOriginalExtension();
                        Image::make($files)->save($this->identitas . '/' . $filesName);
                    
                        foreach ($this->dimensions as $row) {
                            $canvas = Image::canvas($row, $row);
                            $resizeImage = Image::make($files)->resize($row, $row, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        
                            if (!File::isDirectory($this->identitas . '/' . $row)) {
                                File::makeDirectory($this->identitas . '/' . $row);
                            }
                        
                            $canvas->insert($resizeImage, 'center');
                            $canvas->save($this->identitas . '/' . $row . '/' . $filesName);
                        }

                //proses simpan buku_tabungan ke folder//
                if (!File::isDirectory($this->buku_tabungan)) {
                    File::makeDirectory($this->buku_tabungan,777, true);
                }
                        $nama = str_replace(' ', '_', $request->nama);
                        $filez = $request->file('buku_tabungan');
                        $filezName = Carbon::now()->timestamp . '_' . $nama . '.' . $filez->getClientOriginalExtension();
                        Image::make($filez)->save($this->buku_tabungan . '/' . $filezName);
                    
                        foreach ($this->dimensions as $row) {
                            $canvas = Image::canvas($row, $row);
                            $resizeImage = Image::make($filez)->resize($row, $row, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        
                            if (!File::isDirectory($this->buku_tabungan . '/' . $row)) {
                                File::makeDirectory($this->buku_tabungan . '/' . $row);
                            }
                        
                            $canvas->insert($resizeImage, 'center');
                            $canvas->save($this->buku_tabungan . '/' . $row . '/' . $filezName);
                        }
                
                //proses simpan registrasi eo
                $regis = RegistrasiEoModel::create([
                    'id_member' => $id,
                    'nama' => $request->nama_eo,
                    'kontak' => $request->kontak_eo,
                    'no_hp_kontak' => $request->no_hp_kontak_eo,
                    'no_wa_kontak' => $request->no_wa_kontak_eo,
                    'id_provinsi' => $request->provinsi_eo,
                    'id_kota' => $request->kota_eo,
                    'alamat' => $request->alamat_eo,
                    'kode_pos' => $request->kode_pos_eo,
                    'logo' => $fileName,
                    'identitas' => $filesName,
                    'buku_rekening' => $filezName,
                    'no_rekening' => $request->norek,
                    'pemilik_rekening' => $request->norek_pemilik,
                    'nama_bank' => $request->bank,
                    'status' => '1',
                    'alamat_web' => $request->alamat_web,
                ]);
                
                //pembuatan session jika sukses
                Session::put('name',$request->nama_eo);
                Session::put('email',$request->email_eo);
                Session::put('group_name', 'anggota');
                Session::put('data', array('id_anggota' => $regis->id, 'full_name' => $request->nama_eo, 'foto' => $fileName, 'email' => $request->email_eo));
                // Auth::login(['name' => $request->nama_eo, 'email' => $request->email_eo, 'group_name' => 'anggota', 'data' => array('id_anggota' => $regis->id, 'full_name' => $request->nama_eo, 'foto' => $fileName, 'email' => $request->email_eo)]);
                Session::put('login',TRUE);
                
                //send email
                $isi =  RegistrasiEoModel::where('id', $regis->id)->first();
                Mail::to(Session::get('data')['email'])->send(new SendMailable($isi, "eo"));
                
            }

         } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            $arr = array('msg' => 'Something goes to wrong. Please try again later', 'status' => false);
            return Response()->json($arr);
            // dd($ex->getMessage());
            // return redirect('/')
            //     ->with('danger', 'Registrasi Event Organizer gagal');
        }
        DB::commit();
        $arr = array('msg' => 'Successfully submit form using ajax', 'status' => true);
        return Response()->json($arr);
        // return redirect('/dashboard')
        //         ->with('danger', 'Registrasi Event Organizer berhasil');
    }

}
