<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'pengajuan_pinjaman'], function(){
    Route::post('/store', 'Api\PengajuanPinjamanApi@store'); //create
    Route::post('/show', 'Api\PengajuanPinjamanApi@show'); //read
});

Route::group(['prefix' => 'info_saldo'], function(){
    Route::post('/show_simpanan', 'Api\InfoSaldoApi@show_simpanan'); //read
    Route::post('/show_hutang', 'Api\InfoSaldoApi@show_hutang'); //read
});
