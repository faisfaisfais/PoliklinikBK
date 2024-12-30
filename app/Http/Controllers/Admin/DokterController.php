<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $listDokter = Dokter::with(['poli'])->get();

        return view('pages.admin.dokter.index', [
            'listDokter' => $listDokter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listPoli = Poli::all();
        return view('pages.admin.dokter.create', [
            'listPoli' => $listPoli
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'namaDokter' => 'required|string',
            'alamat' => 'required|string',
            'noHP' => 'required|string',
            'poli_id' => 'required|integer|exists:poli,id',
        ]);

        // Tambahkan data ke tabel users
        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'roles' => 'Dokter', // Set role sebagai dokter
        ]);

        // Tambahkan data ke tabel dokters
        Dokter::create([
            'users_id' => $user->id,
            'poli_id' => $validated['poli_id'],
            'namaDokter' => $validated['namaDokter'],
            'alamat' => $validated['alamat'],
            'noHP' => $validated['noHP'],
        ]);

        return redirect()->route('dokter.index');
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
        $listDokter = Dokter::findOrFail($id);
        $listPoli = Poli::all();

        return view('pages.admin.dokter.edit', [
            'listDokter' => $listDokter,
            'listPoli' => $listPoli
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'namaDokter' => 'required|string',
            'alamat' => 'required|string',
            'noHP' => 'required|string',
        ]);

        $data = $request->all();

        $item = Dokter::findOrFail($id);

        $item->update($data);

        return redirect()->route('dokter.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Dokter::findOrFail($id);
        $item->delete();

        return redirect()->route('dokter.index');
    }
}
