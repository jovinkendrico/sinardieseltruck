<?php

namespace App\Http\Controllers;

use App\Models\DetailPengecekan;
use App\Models\Pengecekan;
use App\Models\Perlengkapan;
use App\Models\Truk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PengecekanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pengecekans = Pengecekan::all();
        return view('mobil.pengecekanmobil.index')->with('pengecekans',$pengecekans);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $truks = Truk::all();
        $perlengkapans = Perlengkapan::all();
        return view('mobil.pengecekanmobil.create')->with('truks',$truks)->with('perlengkapans',$perlengkapans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        Pengecekan::insert([
            'tanggal'=>$tanggal,
            'pemeriksa'=>$request->pemeriksa,
            'id_truk'=>$request->id_truk,
            'service'=>$request->service
        ]);

        $pengecekan = DB::table('pengecekans')->latest('id')->first();
        $tableData = json_decode($request->input('tableData'), true);
        foreach($tableData as $item){
            $id_kondisi = 0;
            $id_deskripsi = 0;
            if($item['kondisi'] == "Baik"){
                $id_kondisi = 1;
            }
            if($item['deskripsi'] == "Ada"){
                $id_deskripsi = 1;
            }
            DetailPengecekan::create([
                'id_pengecekan'=> $pengecekan->id,
                'id_perlengkapan' => $item['id'],
                'kondisi' => $id_kondisi,
                'deskripsi'=> $id_deskripsi
            ]);
        }

        return redirect('/pengecekan');
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
