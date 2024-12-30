<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PoliRequest;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listPoli = Poli::all();

        return view('pages.admin.poli.index', [
            'listPoli' => $listPoli,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $poli = Poli::all();
        return view('pages.admin.poli.create', [
            'poli' => $poli
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PoliRequest $request)
    {
        $data = $request->all(); //berfungsi memanggil semua data form dan memasukan ke variable $data

        Poli::create($data);

        return redirect()->route('poli.index');
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
        $item = Poli::findOrFail($id); //findOrFail berfungsi jika data ada maka dimunculin, jika tidak ada maka akan return 404 atau data tidak ketemu

        return view('pages.admin.poli.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PoliRequest $request, $id)
    {
        $data = $request->all();

        $item = Poli::findOrFail($id);

        $item->update($data);

        return redirect()->route('poli.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Poli::findOrFail($id);
        $item->delete();

        return redirect()->route('poli.index');
    }
}
