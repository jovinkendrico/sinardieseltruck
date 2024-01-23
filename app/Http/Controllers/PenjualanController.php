<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailBarang;
use App\Models\DetailJasa;
use App\Models\DetailPenjualan;
use App\Models\DetailSubAkuns;
use App\Models\Jasa;
use App\Models\Penjualan;
use App\Models\Pihakjasa;
use App\Models\SubAkuns;
use App\Models\Truk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    private function generateInvoiceNumber($tanggal)
    {
        // Extract the month and year from the provided tanggal
        $month = \Carbon\Carbon::parse($tanggal)->format('m');
        $year = \Carbon\Carbon::parse($tanggal)->format('y');
        $yearp = \Carbon\Carbon::parse($tanggal)->format('Y');

        // Get the last invoice in the given month and year
        $lastInvoice = Penjualan::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $yearp)
            ->orderBy('id','desc')
            ->first();

        if ($lastInvoice) {
            // Extract the sequential number from the last invoice ID
            $sequentialNumber = (int)substr($lastInvoice->id_invoice, -4) +1;
        } else {
            // If no previous invoice exists, start with 1
            $sequentialNumber = 1;
        }

        // Increment the sequential number and return the formatted invoice ID
        return 'PJ/' . $month . $year . '/' . sprintf('%04d', $sequentialNumber);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $penjualans = Penjualan::all();
        $subakuns = SubAkuns::where('id_akun','<=',2)->get();
        return view('transaksi.penjualan.index')->with('penjualans',$penjualans)->with('subakuns',$subakuns);
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
        $jasas = Jasa::all();
        $pihakjasas = Pihakjasa::all();
        $subakuns = SubAkuns::where('id_akun','<=',2)->get();
        $subakundaris = SubAkuns::where('id_akun',5)->get();
        $subakunslengkap = SubAkuns::all();
        return view('transaksi.penjualan.create')->with('customers',$customers)->with('barangs',$barangs)->with('truks',$truks)->with('jasas',$jasas)->with('subakuns',$subakuns)->with('subakundaris',$subakundaris)->with('pihakjasas',$pihakjasas)->with('subakunslengkap',$subakunslengkap);
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
            'id_invoice'=>$this->generateInvoiceNumber($request->tanggal),
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
            $barang = Barang::where('id',$item['id'])->first();

            $stoktambahdetail = 0;
            if($item['uom'] == $barang->uombesar){
                $barang->decrement('stok',$item['jumlah']*$barang->satuankecil);
                $stoktambahdetail = $item['jumlah']*$barang->satuankecil;
                $harga = $harga / $barang->satuankecil;
            }
            else{
                $barang->decrement('stok',$item['jumlah']);
                $stoktambahdetail = $item['jumlah'];
            }

            $barang = Barang::where('id',$item['id'])->first();
            DetailBarang::create([
                'tanggal' => $tanggal,
                'id_barang' => $item['id'],
                'id_invoice' => $penjualan->id_invoice,
                'masuk' =>  0,
                'keluar' => $stoktambahdetail,
                'harga_keluar' => $harga,
                'stokdetail' => 0,
                'stokakhir' => $barang->stok,
            ]);
        }
        $tableDataJasa = json_decode($request->input('tableDataJasa'),true);
        $pendapatanjasa = 0;
        $totaljasa = 0;
        foreach($tableDataJasa as $item){
            $harga = preg_replace('/[^0-9.]/', '', $item['harga']);
            $hargamodal = preg_replace('/[^0-9.]/', '', $item['modal']);
            DetailJasa::create([
                'id_penjualan' => $penjualan->id,
                'id_jasa' => $item['id'],
                'id_pihakjasa' => $item['idp'],
                'harga_modal' => $hargamodal,
                'harga' => $harga,
                'deskripsi' => $item['deskripsi'],
                'id_akunmasuk' => $request->akunkeluarjasa,
                'paid' => 0
            ]);
            $totaljasa  += $harga;
            $pendapatanjasa += ($harga - $hargamodal);
        }

        //tambah pendapatan barang
        $detailbarangjuals = DetailBarang::where('id_invoice',$penjualan->id_invoice)->get();
        $pendapatanbarang = 0;
        foreach($detailbarangjuals as $detailbarangjual){
            $remainingqty  = $detailbarangjual->keluar;
            $detailbarangbelis = DetailBarang::where('id_barang',$detailbarangjual->id_barang)->where('stokdetail','>',0)->orderBy('id','asc')->get();
            foreach($detailbarangbelis as $detailbarangbeli){
                $deductQuantity = min($remainingqty, $detailbarangbeli->stokdetail);
                $detailbarangbeli->decrement('stokdetail',$deductQuantity);
                $detailbarangbeli->save();
                $remainingqty -= $deductQuantity;
                $pendapatanbarang += $deductQuantity * ($detailbarangjual->harga_keluar - $detailbarangbeli->harga_masuk);
                if($remainingqty == 0){
                    break;
                }
            }
        }
        Penjualan::findOrFail($penjualan->id)->update([
            'pendapatanbarang' => $pendapatanbarang,
            'pendapatanjasa' => $pendapatanjasa,
        ]);

        if($request->pembayaran == 1){
            //kurangi aset barang
            SubAkuns::where('id', $request->akunkeluar)->first()->decrement('saldo', ($totalNetto-$totaljasa-$pendapatanbarang));

            //tambahi pendapatan barang
            SubAkuns::where('id', 7)->first()->decrement('saldo',$pendapatanbarang);

            //tambahi pendapatan jasa
            SubAkuns::where('id', 8)->first()->decrement('saldo',$pendapatanjasa);

            //kurangi piutang karyawan
            SubAkuns::where('id', $request->akunkeluarjasa)->first()->decrement('saldo', $totaljasa-$pendapatanjasa);

            //tambahi saldo piutang
            SubAkuns::where('id', $request->akunmasuk)->first()->increment('saldo', $totalNetto);


            //kurangi aset barang
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunkeluar,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => ($totalNetto-$totaljasa-$pendapatanbarang),
            ]);

            //tambahi pendapatan barang
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 7,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => $pendapatanbarang
            ]);

            //tambahi pendapatan jasa
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 8,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => $pendapatanjasa
            ]);

            //kurangi piutang karyawan
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunkeluarjasa,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => $totaljasa-$pendapatanjasa
            ]);

            //tambahi saldo piutang
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 18,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => $totalNetto,
                'kredit' => 0
            ]);
            $metode = '';
            $subakuns = SubAkuns::where('id', $request->akunmasuk)->first();
            if($subakuns->id_akun == 1){
                $metode = 'Non Cash';
            }
            else{
                $metode = 'Cash';
            }

            Penjualan::where('id_invoice', $penjualan->id_invoice)->update(['status' => 'Y', 'metode' => $metode]);
        }else{
            //kurangi aset barang
            SubAkuns::where('id', $request->akunkeluar)->first()->decrement('saldo', ($totalNetto-$totaljasa-$pendapatanbarang));

            //tambahi pendapatan barang
            SubAkuns::where('id', 7)->first()->decrement('saldo',$pendapatanbarang);

            //tambahi pendapatan jasa
            SubAkuns::where('id', 8)->first()->decrement('saldo',$pendapatanjasa);

            //kurangi piutang karyawan
            SubAkuns::where('id', $request->akunkeluarjasa)->first()->decrement('saldo', $totaljasa);

            //tambahi saldo piutang
            SubAkuns::where('id', 18)->first()->increment('saldo', $totalNetto);


            //kurangi aset barang
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunkeluar,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => ($totalNetto-$totaljasa-$pendapatanbarang),
            ]);

            //kurangi pendapatan barang
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 7,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => $pendapatanbarang
            ]);

            //kurangi pendapatan jasa
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 8,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => $pendapatanjasa
            ]);

            //kurangi piutang karyawan
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunkeluarjasa,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => 0,
                'kredit' => $totaljasa-$pendapatanjasa
            ]);

            //tambahi saldo piutang
            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 18,
                'id_bukti' => $penjualan->id_invoice,
                'deskripsi' => $penjualan->id_invoice,
                'debit' => $totalNetto,
                'kredit' => 0
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
        $detailJasas= DetailJasa::where('id_penjualan',$penjualan->id)->get();
        return view('transaksi.penjualan.show')->with('penjualan',$penjualan)->with('detailPenjualans',$detailPenjualans)->with('detailJasas',$detailJasas);
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
        $jasas = Jasa::all();
        $penjualan = Penjualan::where('id',$id)->first();
        $tanggal = \Carbon\Carbon::parse($penjualan->tanggal)->format('m-d-Y');
        $jatuh_tempo = \Carbon\Carbon::parse($penjualan->jatuh_tempo)->format('m-d-Y');
        $detailPenjualans = DetailPenjualan::where('id_penjualan',$penjualan->id)->get();
        $detailJasas = DetailJasa::where('id_penjualan',$penjualan->id)->get();
        return view('transaksi.penjualan.edit')->with('jasas',$jasas)->with('detailJasas',$detailJasas)->with('truks',$truks)->with('penjualan',$penjualan)->with('detailPenjualans',$detailPenjualans)->with('customers',$customers)->with('barangs',$barangs)->with('tanggal',$tanggal)->with('jatuh_tempo',$jatuh_tempo);
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

        $detailPenjualans = DetailPenjualan::where('id_penjualan',$penjualan->id)->get();
        foreach($detailPenjualans as $detailPenjualan){
            $barang = Barang::where('id',$detailPenjualan->id_barang)->first();
            if($detailPenjualan->uom == $barang->uombesar){
                $barang->increment('stok',$detailPenjualan->jumlah * $barang->satuankecil);
            }
            else{
                $barang->increment('stok',$detailPenjualan->jumlah);
            }
        }

        DetailPenjualan::where('id_penjualan',$penjualan->id)->delete();
        DetailBarang::where('id_invoice',$penjualan->id_invoice)->delete();
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
            $barang = Barang::where('id',$item['id'])->first();

            $stoktambahdetail = 0;
            if($item['uom'] == $barang->uombesar){
                $barang->decrement('stok',$item['jumlah']*$barang->satuankecil);
                $stoktambahdetail = $item['jumlah']*$barang->satuankecil;
            }
            else{
                $barang->decrement('stok',$item['jumlah']);
                $stoktambahdetail = $item['jumlah'];
            }

            $barang = Barang::where('id',$item['id'])->first();
            DetailBarang::create([
                'tanggal' => $tanggal,
                'id_barang' => $item['id'],
                'id_invoice' => $penjualan->id_invoice,
                'masuk' =>  0,
                'keluar' => $stoktambahdetail,
                'stokdetail' => 0,
                'stokakhir' => $barang->stok,
            ]);
        }

        DetailJasa::where('id_penjualan',$penjualan->id)->delete();
        $tableDataJasa = json_decode($request->input('tableDataJasa'),true);
        foreach($tableDataJasa as $item){
            $harga = preg_replace('/[^0-9.]/', '', $item['harga']);
            DetailJasa::create([
                'id_penjualan' => $penjualan->id,
                'id_jasa' => $item['id'],
                'harga' => $harga,
                'deskripsi' => $item['deskripsi']
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
        $penjualan = DB::table('penjualans')->where('id',$id)->first();

        $detailPenjualans = DetailPenjualan::where('id_penjualan',$penjualan->id)->get();

        DetailBarang::where('id_invoice',$penjualan->id_invoice)->delete();

        foreach($detailPenjualans as $detailPenjualan){
            $barang = Barang::where('id',$detailPenjualan->id_barang)->first();
            if($detailPenjualan->uom == $barang->uombesar){
                $barang->increment('stok',$detailPenjualan->jumlah * $barang->satuankecil);
            }
            else{
                $barang->increment('stok',$detailPenjualan->jumlah);
            }
        }

        Penjualan::where('id',$id)->delete();
        DB::table('detail_penjualans')->where('id_penjualan', $id)->delete();
        DB::table('detail_jasas')->where('id_penjualan', $id)->delete();
        return redirect('/penjualan');

    }

    public function cetakpdf(string $id){
        $penjualan = Penjualan::where('id',$id)->first();
        $detailPenjualans = DetailPenjualan::where('id_penjualan',$penjualan->id)->get();
        $detailJasas= DetailJasa::where('id_penjualan',$penjualan->id)->get();
        return view('transaksi.penjualan.cetak')->with('penjualan',$penjualan)->with('detailPenjualans',$detailPenjualans)->with('detailJasas',$detailJasas);
    }

    public function bayar(Request $request){

        $selectedIds = $request->input('selectedIds');
        $selectedIdsArray = explode(',', $selectedIds);

        $subsementara = SubAkuns::where('id',$request->subakuns)->first();

        //perubahan status transaksi
        foreach($selectedIdsArray as $item){
            Penjualan::where('id',$item)->update(['status' => 'Y']);
            if($subsementara->id_akun == 1){
                Penjualan::where('id',$item)->update(['metode' => 'Non Cash']);
            }else{
                Penjualan::where('id',$item)->update(['metode' => 'Cash']);
            }
        }

        //tambahi saldo
        $totalprice =    (int) (preg_replace('/[^\d]+/', '', $request->totalPrice))/100;
        SubAkuns::where('id',$request->subakuns)->increment('saldo',$totalprice);

        //

        DetailSubAkuns::insert([
            'tanggal' => now(),
            'id_subakun' => $request->subakuns,
            'deskripsi' => "Penjualan Barang",
            'debit' => $totalprice,
            'kredit' => 0,
        ]);


        return redirect('/penjualan');
    }
}
