<?php

/**
 * @author ryan saputro
 * @email ryansaputro52@gmail.com
 * @create date 2020-01-10 09:54:29
 * @modify date 2020-01-10 09:54:29
 * @desc 
 * 
 * menu daftar peserta 
 * & pembayaran di halaman eo 
 * dilakukan di controller ini
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
use App\Models\RegistrasiPesertaEventPembayaranModel; //Use Model RegistrasiPesertaEventModel
use App\Models\RegistrasiEoModel; //Use Model RegistrasiPesertaEventModel
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
    
    public function index(Request $request, $eo)
    {   
        //get data eo
        $eoData = RegistrasiEoModel::where('nama', str_replace('_', ' ', $eo))->first();        
        
        //get data event eo yg aktif utk filter
        $Dataevent = RegistrasiEventModel::where('id_eo', $eoData->id)->where('status', '<>', '0');
        
        //get data event to array
        $eventArr = $Dataevent->pluck('id')->toArray();
        
        //get data event utk search
        $event = $Dataevent->get();        
        
        //get all list event eo
        $getData = RegistrasiPesertaEventModel::select('portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.created_at AS tgl_byr','portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.atas_nama', 'portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.bukti', 'portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.jumlah','portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.bank','portalse_nci_event_organizer.registrasi_peserta_event.*', 'portalse_nci_portal_1.wp_users.display_name', 'portalse_nci_portal_1.wp_users.ID')
            ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_peserta_event.id_member')
            ->leftJoin('portalse_nci_event_organizer.registrasi_peserta_event_pembayaran', function($join){
                $join->on('portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.id_event', '=', 'portalse_nci_event_organizer.registrasi_peserta_event.id_event');
                $join->on('portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.id_member', '=', 'portalse_nci_event_organizer.registrasi_peserta_event.id_member');
            })
            ->join('portalse_nci_event_organizer.registrasi_event', 'portalse_nci_event_organizer.registrasi_event.id','portalse_nci_event_organizer.registrasi_peserta_event.id_event')
            ->where('portalse_nci_event_organizer.registrasi_event.id_eo', $eoData->id);
        
        //kondisi jika ada key yg dicari
        if(isset($request->cari)){
            $cari = $request->cari_event;
            if($cari != 'xxx'){
                $getData->where(DB::raw('md5(portalse_nci_event_organizer.registrasi_peserta_event.id_event)'), $cari);
            }
        }else{
            $cari = null;
        }

        //get data peserta event
        $data = $getData->get();
        
        return view('registrasi_peserta_event.backend.index', compact('eo', 'data', 'event', 'cari'));
    }

    public function cek_pembayaran(Request $request, $eo)
    {
        $eoData = RegistrasiEoModel::where('nama', str_replace('_', ' ', $eo))->first();
        $event = RegistrasiEventModel::where('id_eo', $eoData->id)->where('status', '<>', '0')->get();
        $datas = RegistrasiPesertaEventPembayaranModel::select('portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.*', 
                'portalse_nci_event_organizer.registrasi_event.nama_event', 
                'portalse_nci_event_organizer.registrasi_event.kode_event', 
                'portalse_nci_portal_1.wp_users.display_name', 
                'portalse_nci_portal_1.wp_users.ID')
                ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','=','portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.id_member')
                ->join('portalse_nci_event_organizer.registrasi_event', 'portalse_nci_event_organizer.registrasi_event.id','=','portalse_nci_event_organizer.registrasi_peserta_event_pembayaran.id_event')
                ->where('portalse_nci_event_organizer.registrasi_event.id_eo', $eoData->id);

        if(isset($request->cari)){
            $cari = $request->cari_event;
            $datas->where(DB::raw('md5(portalse_nci_event_organizer.registrasi_event.id)'), $cari);
        }else{
            $cari = null;
        }
        
        $data = $datas->get();
        return view('pembayaran.index', compact('data', 'eo', 'event', 'cari'));
    }

    public function storePembayaran(Request $request, $eo, $kode_event)
    {
        
        DB::beginTransaction();
        try {
            
            //get data eo
            $eoData = RegistrasiEoModel::where('nama', str_replace('_', ' ', $eo))->first();
                   
            //get data eo
            $eo = DB::table('portalse_nci_event_organizer.registrasi_eo')
                ->select('portalse_nci_event_organizer.registrasi_eo.id', 'user_email','kode_event','id_member', 'no_wa_kontak', 'nama', 'no_rekening', 'pemilik_rekening', 'nama_bank', 'nama_event')
                ->join('portalse_nci_event_organizer.registrasi_event', 'registrasi_eo.id', '=', 'registrasi_event.id_eo')
                ->join('portalse_nci_portal_1.wp_users', 'portalse_nci_portal_1.wp_users.ID','portalse_nci_event_organizer.registrasi_eo.id_member')
                ->where('portalse_nci_event_organizer.registrasi_eo.nama', str_replace('_', ' ', $eo))
                ->first();
                
            //get data event
            $event = RegistrasiEventModel::where('id_eo', $eoData->id)->where('kode_event', strtoupper($kode_event))->where('status', '<>', '0')->first();

            //get data member
            $id_user = User::where(DB::raw('md5(ID)'), $request->id_member)->first();

            $userCheckProfile = ProfileChecking::select('v_checking_complete_profile.user_email','v_checking_complete_profile.display_name', 'v_checking_complete_profile.meta_key', 'v_checking_complete_profile.meta_value', 'guid')
                ->leftJoin('wp_posts', 'wp_posts.guid', '=', 'foto')
                ->where(DB::raw('md5(v_checking_complete_profile.ID)'), $request->id_member)
                ->get();
            
            //get profil member
            if(count($userCheckProfile) > 0){

                foreach($userCheckProfile AS $k => $v){
                    $profil[$v->meta_key] = $v->meta_key == 'foto' ? $v->guid : $v->meta_value;
                }

                $profil['display_name'] = $userCheckProfile[0]['display_name']; 
                $profil['user_email'] = $userCheckProfile[0]['user_email']; 

            }else{

                $profil = null;

            }
            
            //get id pembayaran
            $dataByr = RegistrasiPesertaEventPembayaranModel::where('id_event', $event->id)->where(DB::raw('md5(id_member)'), $request->id_member)->first();

            //no unik di generate dengan format no_hp_ tahun_ kode_event_ id_member_ id_bayar
            $noHp = substr($profil['no_hp_kontak'], -3);
            $thn = date('Y');
            $id_event = $event->id;
            $id_member = $id_user->ID;

            //insert ke db table registrasi peserta event pembayaran
            $data = RegistrasiPesertaEventPembayaranModel::where('id_event', $event->id)->where('id_member', $id_user->ID)->update([
                'status_approval'  => '1',
                'approval_oleh'    => Session::get('data')['id_anggota'],
                'jumlah_approval'  => $request->jumlah_approval,
                'tanggal_approval' => date('Y-m-d H:i:s'),
            ]);
                
            //update ke table peserta event dengan status sesuai yg dieksekusi
            $pst = RegistrasiPesertaEventModel::where('id_event', $event->id)->where('id_member', $id_user->ID)->first();
            $updPst = $pst->update(['status_pembayaran' => '1' ]);
            
            // //generate unik kode
            $cd = $pst->is_free == 'ya' ? 'FR' : 'PAY';
            $idPserta = $pst->is_free == 'ya' ? $pst->id :  $dataByr->id ;

            // //insert no unik
            // $dbayar->update(['no_unik' => $id_event.$cd.$idPserta]);

             //generate no unik
            $peserta = RegistrasiPesertaEventModel::where('id_event', $event->id)->where('id_member', $id_user->ID)->update(['no_unik' => strtoupper($event->kode_event).$cd.$idPserta]);

            
            //send email
            $memberCekByr = Mail::to($id_user->user_email)
                ->bcc($eo->user_email)
                ->send(new SendMailable($event, 'bukti', $profil, $dataByr, $pst));

        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return redirect()->back()
                    ->with('danger', $request->approval.' pembayaran gagal');
        }
        DB::commit();
        return redirect()->back()
                ->with('success', $request->approval.' pembayaran sukses');

    }

}
