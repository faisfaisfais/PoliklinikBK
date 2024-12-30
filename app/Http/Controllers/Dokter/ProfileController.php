<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dokter\ProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan data dokter yang login
        $dokter = auth()->user()->dokter;

        return view('pages.dokter.profile.index', [
            'dokter' => $dokter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, $redirect)
    {
        // Mendapatkan data dokter yang login
        $dokter = auth()->user()->dokter;

        // Update data user terkait (username dan password jika ada)
        $user = $dokter->user;

        $updateData = [
            'username' => $request->username,
        ];

        // Hanya update password jika field password diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Update data dokter
        $dokter->update($request->only('namaDokter', 'alamat', 'noHP'));

        return redirect()->route($redirect);
    }
}
