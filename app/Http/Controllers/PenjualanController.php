<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Truk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $penjualans = Penjualan::all();
        return view('transaksi.penjualan.index')->with('penjualans',$penjualans);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $barangs = Barang::all();
        $customers = Customer::all();
        $truks = Truk::all();
        return view('transaksi.penjualan.create')->with('customers',$customers)->with('barangs',$barangs)->with('truks',$truks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $jatuh_tempo = \Carbon\Carbon::parse($request->jatuh_tempo);
        $totalNetto = preg_replace('/[^0-9.]/', '', $request->totalNetto);
        Penjualan::insert([
            'tanggal'=>$tanggal,
            'id_invoice'=>$request->id_invoice,
            'id_customer'=>$request->id_customer,
            'id_truk'=>$request->id_truk,
            'netto'=>$totalNetto,
            'jatuh_tempo'=>$jatuh_tempo,
            'status'=> 'N'
        ]);

        $penjualan = DB::table('penjualans')->latest('id')->first();
        $tableData = json_decode($request->input('tableData'), true);
        foreach ($tableData as $item) {
            $harga = preg_replace('/[^0-9.]/', '', $item['harga']);
            $bruto = $harga * $item['jumlah'];
            $diskon = preg_replace('/[^0-9.]/', '', $item['diskon']);
            $netto = $bruto-$diskon;
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id,
                'id_barang' => $item['id'],
                'jumlah' => $item['jumlah'],
                'uom' => $item['uom'],
                'harga' => $harga,
                'bruto' => $bruto,
                'diskon' => $diskon,
                'netto' => $netto
            ]);
        }

        return redirect('/penjualan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $penjualan = Penjualan::where('id',$id)->first();
        $detailPenjualans = DetailPenjualan::where('id_penjualan',$penjualan->id)->get();
        return view('transaksi.penjualan.show')->with('penjualan',$penjualan)->with('detailPenjualans',$detailPenjualans);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $barangs = Barang::all();
        $customers = Customer::all();
        $truks = Truk::all();
        $penjualan = Penjualan::where('id',$id)->first();
        $tanggal = \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y');
        $jatuh_tempo = \Carbon\Carbon::parse($penjualan->jatuh_tempo)->format('d-m-Y');
        $detailPenjualans = DetailPenjualan::where('id_penjualan',$penjualan->id)->get();
        return view('transaksi.penjualan.edit')->with('truks',$truks)->with('penjualan',$penjualan)->with('detailPenjualans',$detailPenjualans)->with('customers',$customers)->with('barangs',$barangs)->with('tanggal',$tanggal)->with('jatuh_tempo',$jatuh_tempo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $jatuh_tempo = \Carbon\Carbon::parse($request->jatuh_tempo);
        $totalNetto = preg_replace('/[^0-9.]/', '', $request->totalNetto);
        Penjualan::findOrFail($id)->update([
            'tanggal'=>$tanggal,
            'id_invoice'=>$request->id_invoice,
            'id_customer'=>$request->id_customer,
            'id_truk'=>$request->id_truk,
            'netto'=>$totalNetto,
            'jatuh_tempo'=>$jatuh_tempo,
            'status'=> 'N'
        ]);

        $penjualan = DB::table('penjualans')->where('id',$id)->first();

        DetailPenjualan::where('id_penjualan',$penjualan->id)->delete();


        $tableData = json_decode($request->input('tableData'), true);
        foreach ($tableData as $item) {
            $harga = preg_replace('/[^0-9.]/', '', $item['harga']);
            $bruto = $harga * $item['jumlah'];
            $diskon = preg_replace('/[^0-9.]/', '', $item['diskon']);
            $netto = $bruto-$diskon;
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id,
                'id_barang' => $item['id'],
                'jumlah' => $item['jumlah'],
                'uom' => $item['uom'],
                'harga' => $harga,
                'bruto' => $bruto,
                'diskon' => $diskon,
                'netto' => $netto
            ]);
        }

        return redirect('/penjualan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Penjualan::where('id',$id)->delete();
        DB::table('detail_penjualans')->where('id_penjualan', $id)->delete();

        return redirect('/penjualan');

    }
}
