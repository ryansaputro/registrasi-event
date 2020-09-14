<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use URL;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $isi;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data=null, $dari=null, $isFreeActive=null, $id_users=null, $regisMember=null)
    {
        $this->data = $data;
        $this->dari = $dari;
        $this->isFreeActive = $isFreeActive;
        $this->id_users = $id_users;
        $this->regisMember = $regisMember;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $isFreeActive = $this->isFreeActive != null ? $this->isFreeActive : null;
        $id_users = $this->id_users != null ? $this->id_users : null;
        $regisMember = $this->regisMember != null ? $this->regisMember : null;
        
        //Halaman konfirmasi
        //logika utk mengirim email member jika sudah daftar event
        if($this->dari == 'user'){
            $view = "email.user";
            $subyek = 'KONFIRMASI PENDAFTARAN EVENT '.$data['nama_event'];
        
        //Halaman notifikasi utk pembayaran
        //logika utk mengirim email jika member sudah melakukan konfirmasi
        }else if($this->dari == 'bayar'){
            $view = "email.notif_member";
            $subyek = "NOTIFIKASI PEMBAYARAN EVENT ".strtoupper($data->nama_event);

        //Halaman notifikasi utk persetujuan bukti pembayaran
        //logika utk mengirim email jika eo sudah melakukan eksekusi approve ataupun menolak pembayaran
        }else if($this->dari == 'cek_bukti'){
            $view = "email.notif_member_cek_bb";
            $subyek = "NOTIFIKASI BUKTI TRANSFER PESERTA NO ".strtoupper($data->nama_event)." PESERTA NO ".$id_users->id;

        //Halaman notifikasi utk bukti pembayaran
        //logika utk mengirim email jika member sudah melakukan pembayaran dan upload bukti
        }else if($this->dari == 'bukti'){
            $view = "email.notif_member_bb";
            $subyek = "APPROVAL ".strtoupper($data['nama_event'])." PESERTA NO ".$regisMember->id;
        
        //Halaman pembuatan event    
        }else if($this->dari == 'eo'){
            $view = "email.eo";
            $subyek = "REGISTRASI BERHASIL";
        //Halaman pembuatan event    
        }else{
            $view = "email.notif_event";
            $subyek = "EVENT ".strtoupper($data->nama_event)." BERHASIL DIBUAT";
        }

        return $this
        ->subject($subyek)
                    ->view($view, compact('data', 'isFreeActive', 'id_users', 'regisMember'));
    }
}
