<?php

use App\Http\Controllers\Pasien\PasienPeriksaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('register/check', 'Auth\RegisterController@check')->name('api-register-check');
Route::get('register-patient/check', 'Auth\RegisterPasienController@check')->name('api-register-pasien-check');
Route::get('/jadwal/{poliId}', [PasienPeriksaController::class, 'getJadwalByPoli']);
