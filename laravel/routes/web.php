<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

// echo "ceng";
// print_r(Session::get('data'));
// print_r($request->session()->get('data'));
// dd( Auth::user());
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('pages.auth.loginGoogle');
    // return redirect()->route('registrasiEO.index');
})->middleware('guest');

Route::get('/administrator', function () {
    return view('pages.auth.login');
})->middleware('guest');

// login via google
Route::get('redirect/{driver}', 'Auth\LoginController@redirectToProvider')->name('login.provider');
Route::get('{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.callback');

// registrasi eo
Route::get('/registrasiEO', 'RegistrasiEOController@index')->name('registrasiEO.index');
Route::post('/registrasiEO', 'RegistrasiEOController@store')->name('registrasiEO.store');
Route::post('/registrasiEO/ajaxKota', 'RegistrasiEOController@ajaxKota');
Route::post('/registrasiEO/ajaxKecamatan', 'RegistrasiEOController@ajaxKecamatan');
Route::post('/registrasiEO/ajaxKelurahan', 'RegistrasiEOController@ajaxKelurahan');

//Route Login
Route::group(['prefix' => 'login'], function(){
  Route::get('/', 'SigninController@getLogin')->middleware('guest');
  Route::post('/', 'SigninController@postLogin')->name('login');
});

Route::get('/logout', 'SigninController@logout');

//dashboard eo
Route::group(['middleware' => ['usersession','web']], function(){
  //dashboard
  Route::get('/dashboard', 'DashboardController@index');
  Route::get('/dashboard/event', 'DashboardController@EventAjax');
  Route::get('/dashboard/gender', 'DashboardController@GenderAjax');
  Route::get('/dashboard/bayar', 'DashboardController@PembayaranAjax');
  Route::get('/dashboard/komunitas', 'DashboardController@KomunitasAjax');
  Route::get('/dashboard/jersey', 'DashboardController@JerseyAjax');
  //menu event
  Route::get('/{nama_eo}/event/registrasi', 'EventController@index')->name('event.index');
  Route::post('/{nama_eo}/event/registrasi', 'EventController@updateDataEvent')->name('event.updateDataEvent');
  Route::post('/{nama_eo}/event/registrasi/ajaxKuota', 'EventController@ajaxKuota')->name('event.ajaxKuota');
  Route::get('/{nama_eo}/event/registrasi-baru', 'EventController@create');
  Route::post('/{nama_eo}/event/registrasi-baru', 'EventController@store');
  Route::get('/{nama_eo}/event/dataTable', 'EventController@dataTable');
  Route::get('/{nama_eo}/event/{kode_event?}/registrasi-edit', 'EventController@edit')->name('event.edit');
  Route::put('/{nama_eo}/event/{kode_event?}/registrasi-edit', 'EventController@update')->name('event.update');
  Route::get('/{nama_eo}/event/{id?}/registrasi-show', 'EventController@show')->name('event.show');
  //ajax event get jersey
  Route::post('/event/ajaxGetJersey', 'EventController@ajaxGetJersey');
  Route::post('/event/AjaxJerseyModel', 'EventController@AjaxJerseyModel');
  
  //menu registrasi peserta -> daftar peserta
  Route::get('/{nama_eo}/registrasi_peserta/daftar_peserta', 'DaftarPesertaController@index')->name('daftar_peserta.index');
  Route::get('/{nama_eo}/registrasi_peserta/daftar_peserta/dataTable', 'DaftarPesertaController@dataTable');
  Route::get('/{nama_eo}/cek_pembayaran', 'DaftarPesertaController@cek_pembayaran')->name('daftar_peserta.cek_pembayaran');
  Route::post('/{nama_eo}/{kode_event}/cek_pembayaran', 'DaftarPesertaController@storePembayaran')->name('daftar_peserta.save_pembayaran');
  
  //menu laporan
  Route::get('/{nama_eo}/laporan/daftar_event', 'LaporanController@daftar_event')->name('laporan.daftar_event');
  Route::get('/{nama_eo}/laporan/daftar_peserta_event', 'LaporanController@daftar_peserta_event')->name('laporan.daftar_peserta_event');
  Route::get('/{nama_eo}/laporan/rekap_data_peserta_by_gender', 'LaporanController@rekap_data_peserta_by_gender')->name('laporan.rekap_data_peserta_by_gender');
  Route::get('/{nama_eo}/laporan/rekap_data_pembayaran', 'LaporanController@rekap_data_pembayaran')->name('laporan.rekap_data_pembayaran');
  Route::get('/{nama_eo}/laporan/rekap_data_komunitas', 'LaporanController@rekap_data_komunitas')->name('laporan.rekap_data_komunitas');
  Route::get('/{nama_eo}/laporan/rekap_data_jersey', 'LaporanController@rekap_data_jersey')->name('laporan.rekap_data_jersey');
});

//registrasi peserta event
Route::get('/event/{kode_event}/{id_peserta}', 'RegistrasiPesertaEventController@index')->name('event.dashboard');
Route::post('/event/{kode_event}/{id_peserta}', 'RegistrasiPesertaEventController@registrasi')->name('event.registrasi');
Route::post('/event/{kode_event}/{id_peserta}/bukti-bayar', 'RegistrasiPesertaEventController@buktiBayar')->name('event.bukti-bayar');
Route::get('/event/{kode_event}/{id_peserta}/konfirmasi', 'RegistrasiPesertaEventController@konfirmasi');
Route::get('/event/{kode_event}/{id_peserta}/pembayaran', 'RegistrasiPesertaEventController@pembayaran')->name('event.pembayaran');
Route::post('/jersey/size', 'RegistrasiPesertaEventController@getAjaxJersey');
Route::post('/payment', 'RegistrasiPesertaEventController@payment');
Route::get('/email', function(){
  return date('d F Y');
});
// //Route CRUD Master  Data
// Route::resource('/anggota', 'AnggotaController')->middleware('auth:anggota');
// Route::resource('/saldo', 'SaldoController')->middleware('auth:anggota');
// Route::resource('/jabatan', 'JabatanController')->middleware('auth:anggota');
// Route::resource('/divisi', 'DivisiController')->middleware('auth:anggota');
// Route::resource('/marital', 'MaritalController')->middleware('auth:anggota');
// Route::resource('/jenis_angsuran', 'JenisAngsuranController')->middleware('auth:anggota');
// Route::resource('/jenis_pinjaman', 'JenisPinjamanController')->middleware('auth:anggota');

// //Route CRUD Simpan Pinjam
// Route::resource('/simpanan', 'SimpananController')->middleware('auth:anggota');
// Route::resource('/pinjaman', 'PinjamanController')->middleware('auth:anggota');
// Route::resource('/approval_pinjaman', 'ApprovalPinjamanController')->middleware('auth:anggota');
// Route::resource('/pembayaran_angsuran', 'PembayaranAngsuranController')->middleware('auth:anggota');
// Route::resource('/sandangpangan', 'SandangpanganController')->middleware('auth:anggota');

// Route::get('approval/{no_pengajuan?}', 'PinjamanController@show_approval')->name('approval')->middleware('auth:anggota');
// Route::post('/update_approval', 'PinjamanController@update_approval')->name('update.approval')->middleware('auth:anggota');

// Route::get('/anggota/{id_anggota?}/saldo', 'AnggotaController@show_saldo')->name('anggota.saldo')->middleware('auth:anggota');
// Route::post('/update_saldo/{id_anggota?}', 'AnggotaController@update_saldo')->name('update.saldo')->middleware('auth:anggota');

// //Route Get Datatable CRUD
// Route::group(['prefix' => 'table', 'middleware' => ['auth:anggota']], function(){
//   //Master Data
//   Route::get('/anggota', 'AnggotaController@dataTable')->name('table.anggota');
//   Route::get('/saldo', 'SaldoController@dataTable')->name('table.saldo');
//   Route::get('/jabatan', 'JabatanController@dataTable')->name('table.jabatan');
//   Route::get('/divisi', 'DivisiController@dataTable')->name('table.divisi');
//   Route::get('/marital', 'MaritalController@dataTable')->name('table.marital');
//   Route::get('/jenis_angsuran', 'JenisAngsuranController@dataTable')->name('table.jenis_angsuran');
//   Route::get('/jenis_pinjaman', 'JenisPinjamanController@dataTable')->name('table.jenis_pinjaman');
//   //Simpan Pinjam
//   Route::get('/simpanan', 'SimpananController@dataTable')->name('table.simpanan');
//   Route::get('/pinjaman', 'PinjamanController@dataTable')->name('table.pinjaman');
//   Route::get('/approval_pinjaman', 'ApprovalPinjamanController@dataTable')->name('table.approval_pinjaman');
//   Route::get('/pembayaran_angsuran', 'PembayaranAngsuranController@dataTable')->name('table.pembayaran_angsuran');
//   Route::get('/sandangpangan', 'SandangpanganController@dataTable')->name('table.sandangpangan');
// });

// //Route Get Datatable Filtering Data
// Route::group(['prefix' => 'table', 'middleware' => ['auth:anggota']], function(){
//   //Anggota
//   Route::get('/anggota_filter/{nik?}', 'AnggotaController@dataTblFilterNik');
//   Route::get('/anggota_filters/{ktp?}', 'AnggotaController@dataTblFilterKtp');
//   //Simpanan Sukarela
//   Route::get('/simpanan_cari_tgl/{cari_tgl?}', 'SimpananController@dataTblFilterTgl');
//   Route::get('/simpanan_cari_nik/{cari_nik?}', 'SimpananController@dataTblFilterNik');
//   Route::get('/simpanan_cari_tgl_nik/{cari_tgl?}/{cari_nik?}', 'SimpananController@dataTblFilterTglNik');
//   //Pengajuan Pinjaman
//   Route::get('/pinjaman_cari_tgl/{cari_tgl?}', 'PinjamanController@dataTblFilterTgl');
//   Route::get('/pinjaman_cari_nik/{cari_nik?}', 'PinjamanController@dataTblFilterNik');
//   Route::get('/pinjaman_cari_tgl_nik/{cari_tgl?}/{cari_nik?}', 'PinjamanController@dataTblFilterTglNik');
//   //Approval Pinjaman
//   Route::get('/approval_cari_tgl/{cari_tgl?}', 'ApprovalPinjamanController@dataTblFilterTgl');
//   Route::get('/approval_cari_nik/{cari_nik?}', 'ApprovalPinjamanController@dataTblFilterNik');
//   Route::get('/approval_cari_tgl_nik/{cari_tgl?}/{cari_nik?}', 'ApprovalPinjamanController@dataTblFilterTglNik');
//   //Pembayaran Angsuran
//   Route::get('/angsuran_cari_tgl/{cari_tgl?}', 'PembayaranAngsuranController@dataTblFilterTgl');
//   Route::get('/angsuran_cari_nik/{cari_nik?}', 'PembayaranAngsuranController@dataTblFilterNik');
//   Route::get('/angsuran_cari_tgl_nik/{cari_tgl?}/{cari_nik?}', 'PembayaranAngsuranController@dataTblFilterTglNik');
// });
 
// //Route print Report
// Route::get('/anggota-print-all/{all?}', 'AnggotaController@anggotaPrint')->name('generate-print')->middleware('auth:anggota');
// Route::get('/anggota-print/{nik?}', 'AnggotaController@anggotaPrintNik')->middleware('auth:anggota');
// Route::get('/anggota-prints/{ktp?}', 'AnggotaController@anggotaPrintKtp')->middleware('auth:anggota');

// Route::group(['prefix' => 'print', 'middleware' => ['auth:anggota']], function(){
//   //Simpanan Sukarela
//   Route::get('/simpanan_sukarela/tgl={cari_tgl?}', 'SimpananController@PrintSS_CariTgl');
//   Route::get('/simpanan_sukarela/nik={cari_nik?}', 'SimpananController@PrintSS_CariNik');
//   Route::get('/simpanan_sukarela/tgl={cari_tgl?}/nik={cari_nik?}', 'SimpananController@PrintSS_CariTglNik');
//   Route::get('/simpanan_sukarela/all={cari_all?}', 'SimpananController@PrintSS_CariAll');
//   //Pengajuan Pinjaman
//   Route::get('/pengajuan_pinjaman/tgl={cari_tgl?}', 'PinjamanController@PrintPP_CariTgl');
//   Route::get('/pengajuan_pinjaman/nik={cari_nik?}', 'PinjamanController@PrintPP_CariNik');
//   Route::get('/pengajuan_pinjaman/tgl={cari_tgl?}/nik={cari_nik?}', 'PinjamanController@PrintPP_CariTglNik');
//   Route::get('/pengajuan_pinjaman/all={cari_all?}', 'PinjamanController@PrintPP_CariAll');
//   //Approval Pinjaman
//   Route::get('/approval_pinjaman/tgl={cari_tgl?}', 'ApprovalPinjamanController@PrintAP_CariTgl');
//   Route::get('/approval_pinjaman/nik={cari_nik?}', 'ApprovalPinjamanController@PrintAP_CariNik');
//   Route::get('/approval_pinjaman/tgl={cari_tgl?}/nik={cari_nik?}', 'ApprovalPinjamanController@PrintAP_CariTglNik');
//   Route::get('/approval_pinjaman/all={cari_all?}', 'ApprovalPinjamanController@PrintAP_CariAll');
//   //Pembayaran Angsuran
//   Route::get('/pembayaran_angsuran/tgl={cari_tgl?}', 'PembayaranAngsuranController@PrintPA_CariTgl');
//   Route::get('/pembayaran_angsuran/nik={cari_nik?}', 'PembayaranAngsuranController@PrintPA_CariNik');
//   Route::get('/pembayaran_angsuran/tgl={cari_tgl?}/nik={cari_nik?}', 'PembayaranAngsuranController@PrintPA_CariTglNik');
//   Route::get('/pembayaran_angsuran/all={cari_all?}', 'PembayaranAngsuranController@PrintPA_CariAll');
// });
// //Button CEK
// Route::get('/anggota/get/{nik?}', 'AnggotaController@cek_nik')->middleware('auth:anggota');
// Route::get('/pinjaman/get_pengajuan/{no_pengajuan?}', 'PinjamanController@cek_no_pengajuan')->middleware('auth:anggota');
// Route::get('/pinjaman/get_jns_pinjaman/{id_jenis_pinjaman?}', 'PinjamanController@cek_jenis_pinjaman')->middleware('auth:anggota');
// Route::get('/pembayaran_angsuran/get_data/{no_pinjaman?}', 'PembayaranAngsuranController@cek_pinjaman')->middleware('auth:anggota');
// Route::get('/pembayaran_angsuran/get_datas/nik={cari_nik?}', 'PembayaranAngsuranController@Cari_nik_pinjaman')->middleware('auth:anggota');

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
