<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class AkunsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $akuns = Akun::all();
        return view('admin.akuns.index')->with('akuns',$akuns);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Akun::insert([
            'nama' => $request->nama,
            'nomor_akun' => $request->nomor_akun,
            'debit' => 0,
            'kredit' => 0
        ]);
        return redirect('/admin/akuns');
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
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Akun::findOrFail($id)->update([
            'nama' => $request->edit_nama,
            'nomor_akun' => $request->edit_nomor_akun
        ]);
        return redirect('/admin/akuns');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Akun::findOrFail($id)->delete();
        return redirect('/admin/akuns');
    }
}
