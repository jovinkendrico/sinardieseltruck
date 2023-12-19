<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\SubAkuns;
use Illuminate\Http\Request;

class SubAkunsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        //
        $akun = Akun::where('id',$id)->first();
        $subakuns = SubAkuns::where('id_akun',$id)->get();
        $latestSubAkun = SubAkuns::where('id_akun',$id)->latest()->first();
        return view('admin.akuns.subakuns.index',['latestSubAkun' => $latestSubAkun])->with('akun',$akun)->with('subakuns',$subakuns);
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
        SubAkuns::create([
            'nomor_akun' => $request->nomor_akun,
            'id_akun' => $request->id_akun,
            'nama'=>$request->nama,
            'debit'=>0,
            'kredit'=>0
        ]);
        return redirect()->route('subakuns.index',$request->id_akun);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        SubAkuns::findOrFail($id)->update([
            'nama' => $request->edit_nama,
        ]);

        return redirect()->route('subakuns.index',$request->id_akun);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SubAkuns::findOrFail($id)->delete();
        return redirect()->back();
    }
}
