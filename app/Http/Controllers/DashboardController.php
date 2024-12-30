<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin_dash(Request $request)
    {
        return view('pages.admin.dashboard', [
            'dokter' => Dokter::count(),
            'pasien' => Pasien::count(),
            'poli' => Poli::count(),
            'obat' => Obat::count(),
        ]);
    }

    public function dokter_dash(Request $request)
    {
        // Ambil dokter yang sedang login
        $dokterId = auth()->user()->dokter->id; // Sesuaikan kolom ID sesuai database Anda

        // Hitung jumlah pasien yang berobat ke dokter yang login
        $totalPasien = DaftarPoli::whereHas('jadwal_appointment', function ($query) use ($dokterId) {
            $query->where('dokter_id', $dokterId);
        })->count();

        return view('pages.dokter.dashboard', [
            'pasien' => $totalPasien,
        ]);
    }

    public function pasien_dash(Request $request)
    {
        $pasienId = auth('pasien')->id();
        return view('pages.pasien.dashboard', [
            'pasien_periksa' => DaftarPoli::where('pasien_id', $pasienId)->count()
        ]);
    }
}
