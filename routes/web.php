<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Dokter\HistoryController;
use App\Http\Controllers\Dokter\ProfileController;
use App\Http\Controllers\Dokter\JadwalController;
use App\Http\Controllers\Dokter\PeriksaController;
use App\Http\Controllers\Pasien\PasienPeriksaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginPasienController;
use App\Http\Controllers\Auth\RegisterPasienController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/login-pasien', [LoginPasienController::class, 'showLoginForm'])->name('pasien.login.form');
Route::post('/login-pasien', [LoginPasienController::class, 'login'])->name('pasien.login');
Route::post('/logout-pasien', [LoginPasienController::class, 'logout'])->name('pasien.logout');

Route::get('/register-pasien', [RegisterPasienController::class, 'showRegistrationForm'])->name('pasien.register.form');
Route::post('/register-pasien', [RegisterPasienController::class, 'register'])->name('pasien.register');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('/admin')
    ->middleware(['auth', 'admin'])
    ->group(function () { //prefix untuk menambahkan awalan URL ke semua rute yang didefinisikan di dalam grup, cth : http://example.com, rute ini akan menjadi http://example.com/admin.
        Route::get('/', [DashboardController::class, 'admin_dash'])->name('dashboard-admin'); //merujuk ke function index dari DashboardController dan route ini diberi nama 'dashboard' supaya tau route ini utk bagian apa

        Route::resource('pasien', PasienController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('poli', PoliController::class);
    });

Route::prefix('/dokter')
    ->middleware(['auth', 'dokter'])
    ->group(function () { //prefix untuk menambahkan awalan URL ke semua rute yang didefinisikan di dalam grup, cth : http://example.com, rute ini akan menjadi http://example.com/admin.
        Route::get('/', [DashboardController::class, 'dokter_dash'])->name('dashboard-dokter'); //merujuk ke function index dari DashboardController dan route ini diberi nama 'dashboard' supaya tau route ini utk bagian apa

        Route::resource('jadwal', JadwalController::class);
        Route::resource('history', HistoryController::class);
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update/{redirect}', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('periksa', [PeriksaController::class, 'index'])->name('periksa.index');
        Route::get('periksa/{id}/create', [PeriksaController::class, 'create'])->name('periksa.create');
        Route::post('periksa', [PeriksaController::class, 'store'])->name('periksa.store');
        Route::get('periksa/{id}/edit', [PeriksaController::class, 'edit'])->name('periksa.edit');
        Route::put('periksa/{id}', [PeriksaController::class, 'update'])->name('periksa.update');
        Route::delete('periksa/{id}', [PeriksaController::class, 'destroy'])->name('periksa.destroy');

        Route::get('/dokter/obat/search', [PeriksaController::class, 'search'])->name('obat.search');
    });

Route::prefix('/pasien')
    ->middleware(['pasien'])
    ->group(function () { //prefix untuk menambahkan awalan URL ke semua rute yang didefinisikan di dalam grup, cth : http://example.com, rute ini akan menjadi http://example.com/admin.
        Route::get('/', [DashboardController::class, 'pasien_dash'])->name('dashboard-pasien'); //merujuk ke function index dari DashboardController dan route ini diberi nama 'dashboard' supaya tau route ini utk bagian apa

        Route::resource('pasien_periksa', PasienPeriksaController::class);
    });

Auth::routes();
// Auth::routes(['login' => false]);
