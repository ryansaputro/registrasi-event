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

class DaftarPesertaController extends Controller
{
    /**
     * Menampilkan Fungsi Utama Modul Anggota
     */
    
    public function index($eo)
    {   
        $data = RegistrasiPesertaEventModel::select('portalse_nci_event_organizer.registrasi_peserta_event.*', 'portalse_nci_portalsepeda.wp_users.display_name', 'portalse_nci_portalsepeda.wp_users.ID')
            ->join('portalse_nci_portalsepeda.wp_users', 'portalse_nci_portalsepeda.wp_users.ID','portalse_nci_event_organizer.registrasi_peserta_event.id_member')
            ->get();
        return view('registrasi_peserta_event.backend.index', compact('eo', 'data'));
    }
    public function dataTable()
    {
        $model = RegistrasiPesertaEventModel::select('portalse_nci_event_organizer.registrasi_peserta_event.*', 'portalse_nci_portalsepeda.wp_users.display_name', 'portalse_nci_portalsepeda.wp_users.ID')
            ->join('portalse_nci_portalsepeda.wp_users', 'portalse_nci_portalsepeda.wp_users.ID','portalse_nci_event_organizer.registrasi_peserta_event.id_member')
            ->get();

        $eo = isset($model->first()->nama) ? str_replace(' ', '-', $model->first()->nama) : '';
        return DataTables::of($model)
            ->editColumn('status_pembayaran', function ($model) {
                if ($model->status_pembayaran == 0) return ('belum lunas');
                if ($model->status_pembayaran == 1) return ('lunas');
                if ($model->status_pembayaran == 2) return ('kadaluarsa');
            })
            ->editColumn('jenis_event', function ($model) {
                if ($model->is_free == 'ya') return ('Gratis');
                if ($model->is_free == 'tidak') return ('Berbayar');
            })
            ->addIndexColumn()
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
