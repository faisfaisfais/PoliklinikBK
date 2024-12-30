<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ObatRequest; 
use App\Models\Obat;
use Illuminate\Http\Request;

use Illuminate\Support\Str; //memakai library atau fungsi string dari laravel

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $listObat = Obat::all();

        return view('pages.admin.obat.index', [
            'listObat' => $listObat,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $obat = Obat::all();
        return view('pages.admin.obat.create', [
            'obat' => $obat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ObatRequest $request)
    {
        $data = $request->all(); //berfungsi memanggil semua data form dan memasukan ke variable $data

        Obat::create($data);

        return redirect()->route('obat.index');
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
        $item = Obat::findOrFail($id); //findOrFail berfungsi jika data ada maka dimunculin, jika tidak ada maka akan return 404 atau data tidak ketemu

        return view('pages.admin.obat.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ObatRequest $request, $id)
    {
        $data = $request->all();

        $item = Obat::findOrFail($id);

        $item->update($data);

        return redirect()->route('obat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Obat::findOrFail($id);
        $item->delete();

        return redirect()->route('obat.index');
    }
}
