<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\DetailHistorySubAkuns;
use App\Models\DetailSubAkuns;
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
            'kredit'=>0,
            'saldo' => $request->saldo
        ]);
        return redirect()->route('subakuns.index',$request->id_akun);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $detailSubAkuns = DetailSubAkuns::where('id_subakun',$id)->get();
        $subakun = SubAkuns::where('id',$id)->first();
        return view('admin.akuns.subakuns.show')->with('detailSubAkuns',$detailSubAkuns)->with('subakun',$subakun);
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

    public function fetchDetailSubakunData($id)
    {
        // Fetch additional data based on the $id
        $detailSubAkunData = DetailHistorySubAkuns::where('id_detailsubakun',$id)->get();

        // You can return the data as JSON, or HTML, or any format you prefer
        // For simplicity, let's assume you have a blade view called 'additional_data.blade.php'
        return response()->json($detailSubAkunData);
    }
}
