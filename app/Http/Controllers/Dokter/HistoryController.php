<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID dokter yang sedang login
        $dokterId = auth()->user()->dokter->id;

        // Ambil data pasien hanya untuk dokter yang sedang login
        $listPasien = Pasien::whereHas('pasien_poli.poli_periksa', function ($query) use ($dokterId) {
            // Filter berdasarkan dokter yang login
            $query->whereHas('daftar_poli.jadwal_appointment', function ($q) use ($dokterId) {
                $q->where('dokter_id', $dokterId);
            });
        })
        ->with([
            'pasien_poli' => function ($query) use ($dokterId) {
                $query->whereHas('jadwal_appointment', function ($q) use ($dokterId) {
                    $q->where('dokter_id', $dokterId);
                })
                    ->with('poli_periksa'); 
            },
        ])
        ->get();

        // Kirim data ke view
        return view('pages.dokter.history.index', [
            'listPasien' => $listPasien,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pasien = Pasien::with(['pasien_poli', 'pasien_poli.poli_periksa' , 'pasien_poli.poli_periksa.periksa_obat'])->findOrFail($id);

        return view('pages.dokter.history.detail', compact('pasien'));
    }
}
