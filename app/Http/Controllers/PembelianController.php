<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function parseCurrencyToNumeric($currencyString)
    {
        // Remove non-numeric characters (except dot for decimal point)
        $numericString = preg_replace('/[^0-9.]/', '', $currencyString);

        // Convert to float
        return (float) $numericString;
    }
    public function index()
    {
        //
        $pembelians = Pembelian::all();
        return view('transaksi.pembelian.index')->with('pembelians',$pembelians);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('transaksi.pembelian.create')->with('suppliers',$suppliers)->with('barangs',$barangs);
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
        Pembelian::insert([
            'tanggal'=>$tanggal,
            'id_invoice'=>$request->id_invoice,
            'id_supplier'=>$request->id_supplier,
            'netto'=>$totalNetto,
            'jatuh_tempo'=>$jatuh_tempo,
            'status'=> 'N'
        ]);

        $pembelian = DB::table('pembelians')->latest('id')->first();
        $tableData = json_decode($request->input('tableData'), true);
        foreach ($tableData as $item) {
            $harga = preg_replace('/[^0-9.]/', '', $item['harga']);
            $bruto = $harga * $item['jumlah'];
            $diskon = preg_replace('/[^0-9.]/', '', $item['diskon']);
            $netto = $bruto-$diskon;
            DetailPembelian::create([
                'id_pembelian' => $pembelian->id,
                'id_barang' => $item['id'],
                'jumlah' => $item['jumlah'],
                'uom' => $item['uom'],
                'harga' => $harga,
                'bruto' => $bruto,
                'diskon' => $diskon,
                'netto' => $netto
            ]);
        }

        return redirect('/pembelian');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $pembelian = Pembelian::where('id',$id)->first();
        $detailPembelians = DetailPembelian::where('id_pembelian',$pembelian->id)->get();
        return view('transaksi.pembelian.show')->with('pembelian',$pembelian)->with('detailPembelians',$detailPembelians);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $pembelian = Pembelian::where('id',$id)->first();
        $tanggal = \Carbon\Carbon::parse($pembelian->tanggal)->format('m-d-Y');
        $jatuh_tempo = \Carbon\Carbon::parse($pembelian->jatuh_tempo)->format('m-d-Y');
        $detailPembelians =DetailPembelian::where('id_pembelian',$pembelian->id)->get();
        return view('transaksi.pembelian.edit')->with('pembelian',$pembelian)->with('detailPembelians',$detailPembelians)->with('suppliers',$suppliers)->with('barangs',$barangs)->with('tanggal',$tanggal)->with('jatuh_tempo',$jatuh_tempo);
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
        Pembelian::findOrFail($id)->update([
            'tanggal'=>$tanggal,
            'id_invoice'=>$request->id_invoice,
            'id_supplier'=>$request->id_supplier,
            'netto'=>$totalNetto,
            'jatuh_tempo'=>$jatuh_tempo,
            'status'=> 'N'
        ]);


        //get id pembelian yang di update
        $pembelian = DB::table('pembelians')->where('id',$id)->first();


        //delete detailpembelian sebelumnya
        DetailPembelian::where('id_pembelian',$pembelian->id)->delete();


        //tambah data ke detail pembelian
        $tableData = json_decode($request->input('tableData'), true);
        foreach ($tableData as $item) {
            $harga = preg_replace('/[^0-9.]/', '', $item['harga']);
            $bruto = $harga * $item['jumlah'];
            $diskon = preg_replace('/[^0-9.]/', '', $item['diskon']);
            $netto = $bruto-$diskon;
            DetailPembelian::create([
                'id_pembelian' => $pembelian->id,
                'id_barang' => $item['id'],
                'jumlah' => $item['jumlah'],
                'uom' => $item['uom'],
                'harga' => $harga,
                'bruto' => $bruto,
                'diskon' => $diskon,
                'netto' => $netto
            ]);
        }

        return redirect('/pembelian');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Pembelian::where('id',$id)->delete();
        DB::table('detail_pembelians')->where('id_pembelian', $id)->delete();

        return redirect('/pembelian');

    }
}
