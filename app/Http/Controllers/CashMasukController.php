<?php

namespace App\Http\Controllers;

use App\Models\CashMasuk;
use App\Models\DetailCashMasuk;
use App\Models\SubAkuns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CashMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cashmasuks = CashMasuk::all();
        return view('cash.cashmasuk.index')->with('cashmasuks',$cashmasuks);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $subakuns = SubAkuns::all();
        return view('cash.cashmasuk.create')->with('subakuns',$subakuns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $total = preg_replace('/[^0-9.]/', '', $request->totalJumlah);
        CashMasuk::insert([
            'tanggal' => $tanggal,
            'id_bukti' => $request->id_invoice,
            'id_akunmasuk' => $request->akun_masuk,
            'total' => $total
        ]);

        $cashmasuk = DB::table('cash_masuks')->latest('id')->first();
        $tableData = json_decode($request->input('tableData'), true);

        foreach($tableData as $item){
            $jumlah = preg_replace('/[^0-9.]/', '', $item['jumlah']);
            DetailCashMasuk::insert([
                'id_cashmasuk' => $cashmasuk->id,
                'id_akunkeluar' => $item['id'],
                'deskripsi' => $item['deskripsi'],
                'jumlah' => $jumlah
            ]);
        }
        return redirect('/cashmasuk');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $cashmasuk = CashMasuk::where('id',$id)->first();
        $detailcashmasuks = DetailCashMasuk::where('id_cashmasuk',$cashmasuk->id)->get();
        return view('cash.cashmasuk.show')->with('cashmasuk',$cashmasuk)->with('detailcashmasuks',$detailcashmasuks);
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
        CashMasuk::where('id',$id)->delete();
        DB::table('detail_cash_masuks')->where('id_cashmasuk', $id)->delete();
        return redirect('/cashmasuk');

    }
}
