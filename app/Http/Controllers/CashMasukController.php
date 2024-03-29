<?php

namespace App\Http\Controllers;

use App\Models\CashMasuk;
use App\Models\DetailCashMasuk;
use App\Models\DetailSubAkuns;
use App\Models\SubAkuns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class CashMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function generateInvoiceNumber($tanggal)
    {
        // Extract the month and year from the provided tanggal
        $month = \Carbon\Carbon::parse($tanggal)->format('m');
        $year = \Carbon\Carbon::parse($tanggal)->format('y');
        $yearp = \Carbon\Carbon::parse($tanggal)->format('Y');

        // Get the last invoice in the given month and year
        $lastInvoice = CashMasuk::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $yearp)
            ->orderBy('id','desc')
            ->first();

        if ($lastInvoice) {
            // Extract the sequential number from the last invoice ID
            $sequentialNumber = (int)substr($lastInvoice->id_bukti, -4) +1;
        } else {
            // If no previous invoice exists, start with 1
            $sequentialNumber = 1;
        }

        // Increment the sequential number and return the formatted invoice ID
        return 'CM/' . $month . $year . '/' . sprintf('%04d', $sequentialNumber);
    }
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
            'id_bukti' => $this->generateInvoiceNumber($request->tanggal),
            'id_akunmasuk' => $request->akun_masuk,
            'total' => $total
        ]);

        $cashmasuk = DB::table('cash_masuks')->latest('id')->first();
        $tableData = json_decode($request->input('tableData'), true);


        //atur trasaksi akun cash masuk
        DetailSubAkuns::insert([
            'tanggal' => $tanggal,
            'id_subakun' => $cashmasuk->id_akunmasuk,
            'id_bukti' => $cashmasuk->id_bukti,
            'deskripsi' => $cashmasuk->id_bukti,
            'kredit' => 0,
            'debit' => $total
        ]);
        SubAkuns::where('id',$cashmasuk->id_akunmasuk)->increment('saldo',$total);




        foreach($tableData as $item){
            $jumlah = preg_replace('/[^0-9.]/', '', $item['jumlah']);
            DetailCashMasuk::insert([
                'id_cashmasuk' => $cashmasuk->id,
                'id_bukti' => $cashmasuk->id_bukti,
                'id_akunkeluar' => $item['id'],
                'deskripsi' => $item['deskripsi'],
                'jumlah' => $jumlah
            ]);
            //atur transaksi akun cash keluar
            DetailSubAkuns::insert([
                'tanggal' => $tanggal,
                'id_bukti' => $cashmasuk->id_bukti,
                'id_subakun'=> $item['id'],
                'deskripsi' => $item['deskripsi'],
                'kredit' => $jumlah,
                'debit' => 0
            ]);
            SubAkuns::where('id',$item['id'])->decrement('saldo',$jumlah);
        }
        Session::flash('success', 'Data has been successfully stored.');

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

        $subakuns = SubAkuns::all();
        $cashmasuk = CashMasuk::where('id',$id)->first();
        $tanggal = \Carbon\Carbon::parse($cashmasuk->tanggal)->format('m-d-Y');
        $detailcashmasuks = DetailCashMasuk::where('id_cashmasuk',$cashmasuk->id)->get();
        return view('cash.cashmasuk.edit')->with('tanggal',$tanggal)->with('cashmasuk',$cashmasuk)->with('detailcashmasuks',$detailcashmasuks)->with('subakuns',$subakuns);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //balikin saldo awal
        $cashmasukawal = CashMasuk::where('id',$id)->first();
        SubAkuns::where('id',$cashmasukawal->id_akunmasuk)->decrement('saldo',$cashmasukawal->total);

        DetailSubAkuns::where('deskripsi',$cashmasukawal->id_bukti)->delete();
        //delete detail subakuns
        $delDetSubAkuns = DetailSubAkuns::where('id_bukti',$cashmasukawal->id_bukti)->get();
        foreach($delDetSubAkuns as $delDetSubAkun){
            SubAkuns::where('id',$delDetSubAkun->id_subakun)->increment('saldo',$delDetSubAkun->kredit);
        }
        DetailSubAkuns::where('id_bukti',$cashmasukawal->id_bukti)->delete();


        //
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $total = preg_replace('/[^0-9.]/', '', $request->totalJumlah);
        CashMasuk::findOrFail($id)->update([
            'tanggal' => $tanggal,
            'id_akunmasuk' => $request->akun_masuk,
            'total' => $total
        ]);

        $cashmasuk = DB::table('cash_masuks')->where('id',$id)->first();

        DetailCashMasuk::where('id_cashmasuk',$cashmasuk->id)->delete();

        DetailSubAkuns::insert([
            'tanggal' => $tanggal,
            'id_subakun' => $cashmasuk->id_akunmasuk,
            'id_bukti' => $cashmasuk->id_bukti,
            'deskripsi' => $cashmasuk->id_bukti,
            'kredit' => 0,
            'debit' => $total
        ]);
        SubAkuns::where('id',$cashmasuk->id_akunmasuk)->increment('saldo',$total);

        $tableData = json_decode($request->input('tableData'), true);
        foreach($tableData as $item){
            $jumlah = preg_replace('/[^0-9.]/', '', $item['jumlah']);
            DetailCashMasuk::insert([
                'id_cashmasuk' => $cashmasuk->id,
                'id_akunkeluar' => $item['id'],
                'id_bukti' => $cashmasuk->id_bukti,
                'deskripsi' => $item['deskripsi'],
                'jumlah' => $jumlah
            ]);
            //atur transaksi akun cash keluar
            DetailSubAkuns::insert([
                'tanggal' => $tanggal,
                'id_subakun'=> $item['id'],
                'id_bukti' => $cashmasuk->id_bukti,
                'deskripsi' => $item['deskripsi'],
                'kredit' => $jumlah,
                'debit' => 0
            ]);
            SubAkuns::where('id',$item['id'])->decrement('saldo',$jumlah);
        }

        Session::flash('success', 'Data has been successfully updated.');

        return redirect('/cashmasuk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $cashmasukawal = CashMasuk::where('id',$id)->first();
        SubAkuns::where('id',$cashmasukawal->id_akunmasuk)->decrement('saldo',$cashmasukawal->total);

        DetailSubAkuns::where('deskripsi',$cashmasukawal->id_bukti)->delete();
        //delete detail subakuns
        $delDetSubAkuns = DetailSubAkuns::where('id_bukti',$cashmasukawal->id_bukti)->get();
        foreach($delDetSubAkuns as $delDetSubAkun){
            SubAkuns::where('id',$delDetSubAkun->id_subakun)->increment('saldo',$delDetSubAkun->kredit);
        }
        DetailSubAKuns::where('id_bukti',$cashmasukawal->id_bukti)->delete();

        CashMasuk::where('id',$id)->delete();
        DB::table('detail_cash_masuks')->where('id_cashmasuk', $id)->delete();

        Session::flash('success', 'Data has been successfully deleted.');

        return redirect('/cashmasuk');

    }

    public function cetakpdf(string $id){
        $cashmasuk = CashMasuk::where('id',$id)->first();
        $detailcashmasuks = DetailCashMasuk::where('id_cashmasuk',$cashmasuk->id)->get();
        return view('cash.cashmasuk.cetak')->with('cashmasuk',$cashmasuk)->with('detailcashmasuks',$detailcashmasuks);
    }

}
