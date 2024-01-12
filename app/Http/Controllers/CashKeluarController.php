<?php

namespace App\Http\Controllers;

use App\Models\CashKeluar;
use App\Models\DetailCashKeluar;
use App\Models\DetailSubAkuns;
use App\Models\SubAkuns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cashkeluars = CashKeluar::all();
        return view('cash.cashkeluar.index')->with('cashkeluars',$cashkeluars);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $subakuns = SubAkuns::all();
        return view('cash.cashkeluar.create')->with('subakuns',$subakuns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $total = preg_replace('/[^0-9.]/', '', $request->totalJumlah);
        CashKeluar::insert([
            'tanggal' => $tanggal,
            'id_bukti' => $request->id_invoice,
            'deskripsi' => $request->keterangan,
            'id_akunkeluar' => $request->akun_keluar,
            'total' => $total
        ]);

        $cashkeluar = DB::table('cash_keluars')->latest('id')->first();
        $tableData = json_decode($request->input('tableData'), true);

        //atur trasaksi akun cash keluar
        DetailSubAkuns::insert([
            'tanggal' => $tanggal,
            'id_subakun' => $cashkeluar->id_akunkeluar,
            'deskripsi' => $cashkeluar->id_bukti,
            'kredit' => $total,
            'debit' => 0
        ]);
        SubAkuns::where('id',$cashkeluar->id_akunkeluar)->decrement('saldo',$total);


        foreach($tableData as $item){
            $jumlah = preg_replace('/[^0-9.]/', '', $item['jumlah']);
            DetailCashKeluar::insert([
                'id_cashkeluar' => $cashkeluar->id,
                'id_akunmasuk' => $item['id'],
                'deskripsi' => $item['deskripsi'],
                'jumlah' => $jumlah
            ]);

            //atur transaksi akun cash keluar untuk akun masuk
            DetailSubAkuns::insert([
                'tanggal' => $tanggal,
                'id_subakun'=> $item['id'],
                'deskripsi' => $item['deskripsi'],
                'kredit' => 0,
                'debit' => $jumlah
            ]);
            SubAkuns::where('id',$item['id'])->increment('saldo',$jumlah);
        }

        return redirect('/cashkeluar');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $cashkeluar = CashKeluar::where('id',$id)->first();
        $detailcashkeluars = DetailCashKeluar::where('id_cashkeluar',$cashkeluar->id)->get();
        return view('cash.cashkeluar.show')->with('cashkeluar',$cashkeluar)->with('detailcashkeluars',$detailcashkeluars);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $subakuns = SubAkuns::all();
        $cashkeluar = CashKeluar::where('id',$id)->first();
        $tanggal = \Carbon\Carbon::parse($cashkeluar->tanggal)->format('m-d-Y');
        $detailcashkeluars = DetailCashKeluar::where('id_cashkeluar',$cashkeluar->id)->get();
        return view('cash.cashkeluar.edit')->with('tanggal',$tanggal)->with('cashkeluar',$cashkeluar)->with('detailcashkeluars',$detailcashkeluars)->with('subakuns',$subakuns);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cashkeluarawal = CashKeluar::where('id',$id)->first();
        SubAkuns::where('id',$cashkeluarawal->id_akunkeluar)->increment('saldo',$cashkeluarawal->total);

        DetailSubAkuns::where('deskripsi',$cashkeluarawal->id_bukti)->delete();
        $delDetSubAkuns = DetailSubAkuns::where('id_bukti',$cashkeluarawal->id_bukti)->get();
        foreach($delDetSubAkuns as $delDetSubAkun){
            SubAkuns::where('id',$delDetSubAkun->id_subakun)->decrement('saldo',$delDetSubAkun->kredit);
        }
        DetailSubAKuns::where('id_bukti',$cashkeluarawal->id_bukti)->delete();
        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $total = preg_replace('/[^0-9.]/', '', $request->totalJumlah);
        CashKeluar::findOrFail($id)->update([
            'tanggal' => $tanggal,
            'id_bukti' => $request->id_invoice,
            'deskripsi' => $request->keterangan,
            'id_akunkeluar' => $request->akun_keluar,
            'total' => $total
        ]);

        $cashkeluar = DB::table('cash_keluars')->where('id',$id)->first();

        DetailCashKeluar::where('id_cashkeluar',$cashkeluar->id)->delete();

        DetailSubAkuns::insert([
            'tanggal' => $tanggal,
            'id_subakun' => $cashkeluar->id_akunkeluar,
            'deskripsi' => $cashkeluar->id_bukti,
            'kredit' => $total,
            'debit' => 0
        ]);
        SubAkuns::where('id',$cashkeluar->id_akunkeluar)->decrement('saldo',$total);


        $tableData = json_decode($request->input('tableData'), true);
        foreach($tableData as $item){
            $jumlah = preg_replace('/[^0-9.]/', '', $item['jumlah']);
            DetailCashKeluar::insert([
                'id_cashkeluar' => $cashkeluar->id,
                'id_akunmasuk' => $item['id'],
                'deskripsi' => $item['deskripsi'],
                'jumlah' => $jumlah
            ]);
            DetailSubAkuns::insert([
                'tanggal' => $tanggal,
                'id_subakun'=> $item['id'],
                'deskripsi' => $item['deskripsi'],
                'kredit' => 0,
                'debit' => $jumlah
            ]);
            SubAkuns::where('id',$item['id'])->increment('saldo',$jumlah);
        }

        return redirect('/cashkeluar');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        CashKeluar::where('id',$id)->delete();
        DB::table('detail_cash_keluars')->where('id_cashkeluar', $id)->delete();
        return redirect('/cashkeluar');
    }
}
