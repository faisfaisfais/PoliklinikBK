<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasienRequest;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listPasien = Pasien::all();

        return view('pages.admin.pasien.index', [
            'listPasien' => $listPasien,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil tahun dan bulan saat ini
        $yearMonth = Carbon::now()->format('Ym'); // format: 202411

        // Ambil jumlah pasien yang terdaftar untuk bulan tersebut
        $pasienCount = Pasien::where('nomorRM', 'like', $yearMonth . '%')->count();

        // Generate No RM dengan format tahun-bulan-urutan
        $nomorRMBaru = $yearMonth . '-' . str_pad($pasienCount + 1, 3, '0', STR_PAD_LEFT);

        return view('pages.admin.pasien.create', compact('nomorRMBaru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PasienRequest $request)
    {
        $data = $request->all(); //berfungsi memanggil semua data form dan memasukan ke variable $data

        Pasien::create($data);

        return redirect()->route('pasien.index');
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
        $item = Pasien::findOrFail($id); //findOrFail berfungsi jika data ada maka dimunculin, jika tidak ada maka akan return 404 atau data tidak ketemu

        return view('pages.admin.pasien.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PasienRequest $request, $id)
    {
        $data = $request->all();

        $item = Pasien::findOrFail($id);

        $item->update($data);

        return redirect()->route('pasien.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Pasien::findOrFail($id);
        $item->delete();

        return redirect()->route('pasien.index');
    }
}
