<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;

class PeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID dokter yang sedang login
        $dokterId = auth()->user()->dokter->id; // Sesuaikan jika ada relasi dokter

        $periksaPasien = DaftarPoli::with(['poli_periksa', 'pasien', 'jadwal_appointment'])
        ->whereHas('jadwal_appointment', function ($query) use ($dokterId) {
            $query->where('dokter_id', $dokterId); // Filter berdasarkan dokter yang sedang login
        })
        ->get();

        return view('pages.dokter.periksa.index', [
            'periksaPasien' => $periksaPasien,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
        $periksaPasien = DaftarPoli::with('pasien')->findOrFail($id);

        $obat = Obat::all();

        return view('pages.dokter.periksa.create', compact('periksaPasien', 'obat'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $listObat = Obat::where('namaObat', 'like', "%$query%")
            ->orWhere('kemasan', 'like', "%$query%")
            ->select('id', 'namaObat', 'kemasan', 'harga')
            ->limit(10)
            ->get();

        return response()->json($listObat);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'daftar_poli_id' => 'required|exists:daftar_poli,id', // Pastikan list_clinics_id wajib ada dan valid
            'tanggalPeriksa' => 'required|date',
            'catatan' => 'nullable|string',
            'listObat' => 'required|array', // Wajib array
            'listObat.*' => 'exists:obat,id', // Validasi bahwa setiap ID obat ada di tabel medicines
        ]);

        // Simpan data ke tabel examinations
        $periksa = Periksa::create([
            'daftar_poli_id' => $request->input('daftar_poli_id'),
            'tanggalPeriksa' => $request->input('tanggalPeriksa'),
            'catatan' => $request->input('catatan'),
            'harga' => str_replace(',', '', $request->input('harga')), // Menghapus format angka pada harga
        ]);

        // Simpan data ke tabel pivot (examination_details)
        $obat = $request->input('listObat'); // Ambil array ID obat dari form
        foreach ($obat as $obatId) {
            $periksa->periksa_obat()->attach($obatId);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('periksa.index')->with('success', 'Data pemeriksaan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data examination berdasarkan id yang diminta
        $periksa = Periksa::with(['periksa_obat', 'daftar_poli.pasien'])->findOrFail($id);

        // Ambil data pasien melalui relasi listClinic
        $periksa_pasien = $periksa->daftar_poli;

        // Kembalikan ke view
        return view('pages.dokter.periksa.edit', compact('periksa', 'periksa_pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'daftar_poli_id' => 'required|exists:daftar_poli,id',
            'tanggalPeriksa' => 'required|date',
            'catatan' => 'nullable|string',
            'listObat' => 'nullable|array', 
            'listObat.*' => 'exists:obat,id', 
        ]);

        // Temukan pemeriksaan yang akan diupdate
        $periksa = Periksa::findOrFail($id);

        // Update data pemeriksaan
        $periksa->tanggalPeriksa = $request->input('tanggalPeriksa');
        $periksa->catatan = $request->input('catatan');
        $periksa->daftar_poli_id = $request->input('daftar_poli_id'); 
        $periksa->harga = floatval(str_replace(',', '', $request->input('harga'))); 
        $periksa->save();

        // Mengupdate hubungan many-to-many dengan obat-obatan
        if ($request->has('listObat')) {
            $periksa->periksa_obat()->sync($request->input('listObat'));
        }

        // Redirect kembali ke halaman daftar pemeriksaan dengan pesan sukses
        return redirect()->route('periksa.index')->with('success', 'Pemeriksaan berhasil diupdate.');
    }
}
