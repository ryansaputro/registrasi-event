<?php

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

class RegistrasiEOController extends Controller
{
    public $path;
    public $dimensions;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->path = public_path('images/eo');
        //DEFINISIKAN DIMENSI
        $this->dimensions = ['245', '300', '500'];
    }

    
    public function index()
    {  
        $data = DB::table('registrasi_eo')->select('*')->where('id_member', Auth::user()->toArray()['ID'])->get()->toArray();
        if(count($data) > 0){
            Session::put('group_name', 'anggota');
            Session::put('data', array('id_anggota' => Auth::user()->toArray()['ID'], 'full_name' => $data[0]->nama, 'foto' => $data[0]->logo, 'email' => Auth::user()->toArray()['user_email']));
            Session::put('login',TRUE);

            return redirect('/dashboard');
        }
        
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/propinsi.json')->get();
        $provinsi = json_decode($response, true);
        $id = Auth::user()->toArray()['ID'];
        $userCheckProfile = ProfileChecking::select('v_checking_complete_profile.meta_key', 'v_checking_complete_profile.meta_value', 'guid')->leftJoin('wp_posts', 'wp_posts.guid', '=', 'foto')->where('v_checking_complete_profile.ID', $id)->get();
        
        if(count($userCheckProfile) > 0){
            foreach($userCheckProfile AS $k => $v){
                $profil[$v->meta_key] = $v->meta_key == 'foto' ? $v->guid : $v->meta_value;
            }
        }else{
            $profil = null;
        }
        
        $kotas = isset($profil['provinsi']) ? $profil['provinsi'] : '';
        $responses = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$kotas.'.json')->get();
        $kota = json_decode($responses, true);
        return view('registrasi_eo.index', compact('provinsi', 'id', 'userCheckProfile', 'profil', 'kota'));
    }
    public function ajaxKota(Request $request)
    {
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kabupaten/'.$request->id.'.json')->get();
        $provinsi = json_decode($response, true);
        return  response()->json(['getKota' => $provinsi]);
    }

    public function ajaxKecamatan(Request $request)
    {
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kecamatan/'.$request->id.'.json')->get();
        $provinsi = json_decode($response, true);
        return  response()->json(['getKota' => $provinsi]);
    }

    public function ajaxKelurahan(Request $request)
    {
        $response = Curl::to('https://portalsepeda.com/portalsepeda/wp-content/uploads/data-indonesia-master/kelurahan/'.$request->id.'.json')->get();
        $provinsi = json_decode($response, true);
        return  response()->json(['getKota' => $provinsi]);
    }

    /**
     * Fungsi Create ke database.
     */
    public function store(Request $request)
    {
        // dd($this->path);
        DB::beginTransaction();
        try {
                $messages = [
                    'required'  => ':attribute harus di isi !!!',
                    'min'       => ':attribute harus diisi minimal :min karakter !!!',
                    'max'       => ':attribute harus diisi maksimal :max karakter !!!',
                ];
                // Terima Data request kemudian validasi dulu
                $this->validate($request, [
                    'nama'                  => 'required|unique:registrasi_eo,nama',
                    'panggilan'             => 'required',
                    'jenis_kelamin'         => 'required',
                    'tempat_lahir'          => 'required',
                    'tanggal_lahir'         => 'required',
                    'no_hp_kontak'         => 'required|numeric|digits:12',
                    'no_wa_kontak'         => 'required|numeric|digits:12',
                    'golongan_darah'        => 'required',
                    'pekerjaan'             => 'required',
                    'provinsi'              => 'required',
                    'kota'                  => 'required',
                    'alamat'                => 'required',
                    'kode_pos'              => 'required', //tabel,atribut
                    'nama_eo'               => 'required',
                    'email_eo'              => 'required|string|email|max:255',
                    'kontak_eo'             => 'required',
                    'no_hp_kontak_eo'       => 'required|numeric|digits:12',
                    'no_wa_kontak_eo'       => 'required|numeric|digits:12',
                    'logo_eo'               => 'required|image|mimes:jpg,png,jpeg||max:2048',
                    'provinsi_eo'           => 'required',
                    'kota_eo'               => 'required',
                    'kode_pos_eo'           => 'required',
                ],$messages);

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

                
            //code...
            foreach($post AS $k => $v){
                $meta_key[$v] = $postVal[$k]; 
                $createUser = UserMeta::updateOrCreate([
                        'user_id' => $id,
                        'meta_key' => $v,
                    ], [
                        'meta_value' => $postVal[$k],
                    ]);
                    if($createUser){
                        $ins ="1";
                    }else{
                        $ins = "0";
                    }
            }

            if($ins == '1'){
                if (!File::isDirectory($this->path)) {
                    File::makeDirectory($this->path,777, true);
                }
                        $nama = str_replace(' ', '_', $request->nama);
                        $file = $request->file('logo_eo');
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
                            'status' => '1',
                            'alamat_web' => $request->alamat_web,
                        ]);
                        Auth::logout();   
                        Session::put('name',$request->nama_eo);
                        Session::put('email',$request->email_eo);
                        Session::put('group_name', 'anggota');
                        Session::put('data', array('id_anggota' => $regis->id, 'full_name' => $request->nama_eo, 'foto' => $fileName, 'email' => $request->email_eo));
                        
                        Session::put('login',TRUE);
            }



         } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return redirect('/')
                ->with('danger', 'Registrasi Event Organizer gagal');
        }
        DB::commit();
        return redirect('/dashboard')
                ->with('danger', 'Registrasi Event Organizer berhasil');
    }

}
