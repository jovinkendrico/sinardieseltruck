<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailBarang;
use App\Models\DetailHistorySubAkuns;
use App\Models\DetailPembelian;
use App\Models\DetailSubAkuns;
use App\Models\Pembelian;
use App\Models\SubAkuns;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PembelianController extends Controller
{
    private function generateInvoiceNumber($tanggal)
    {
        // Extract the month and year from the provided tanggal
        $month = \Carbon\Carbon::parse($tanggal)->format('m');
        $year = \Carbon\Carbon::parse($tanggal)->format('y');
        $yearp = \Carbon\Carbon::parse($tanggal)->format('Y');

        // Get the last invoice in the given month and year
        $lastInvoice = Pembelian::whereMonth('tanggal', $month)
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
        return 'PB/' . $month . $year . '/' . sprintf('%04d', $sequentialNumber);
    }
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
        $subakuns = SubAkuns::where('id_akun','<=',2)->get();

        $pembelians = Pembelian::all();
        return view('transaksi.pembelian.index')->with('pembelians',$pembelians)->with('subakuns',$subakuns);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $subakuns = SubAkuns::where('id_akun','<=',2)->get();
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $subakunterimas = SubAkuns::where('id_akun',5)->get();
        return view('transaksi.pembelian.create')->with('suppliers',$suppliers)->with('barangs',$barangs)->with('subakuns',$subakuns)->with('subakunterimas',$subakunterimas);
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
            'id_invoice'=>$this->generateInvoiceNumber($request->tanggal),
            'id_supplier'=>$request->id_supplier,
            'netto'=>$totalNetto,
            'jatuh_tempo'=>$jatuh_tempo,
            'status'=> 'N',
            'id_akunmasuk' => $request->akunmasuk,
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
            $barang = Barang::where('id',$item['id'])->first();

            $stoktambahdetail = 0;
            if($item['uom'] == $barang->uombesar){
                $barang->increment('stok',$item['jumlah']*$barang->satuankecil);
                $stoktambahdetail = $item['jumlah']*$barang->satuankecil;
            }
            else{
                $barang->increment('stok',$item['jumlah']);
                $stoktambahdetail = $item['jumlah'];
            }

            //tambah detail barang
            $barang = Barang::where('id',$item['id'])->first();
            DetailBarang::create([
                'tanggal' => $tanggal,
                'id_barang' => $item['id'],
                'id_invoice' => $pembelian->id_invoice,
                'masuk' =>  $stoktambahdetail,
                'harga_masuk' => $harga,
                'keluar' => 0,
                'stokdetail' => $stoktambahdetail,
                'stokakhir' => $barang->stok,
            ]);
        }


        if($request->pembayaran == 1){
            SubAkuns::where('id', $request->akunmasuk)->first()->increment('saldo', $totalNetto);
            SubAkuns::where('id',$request->akunkeluar)->first()->decrement('saldo', $totalNetto);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunmasuk,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => $totalNetto,
                'kredit' => 0
            ]);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunkeluar,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => 0,
                'kredit' => $totalNetto
            ]);

            $metode = '';
            $subakuns = SubAkuns::where('id', $request->akunkeluar)->first();
            if($subakuns->id_akun == 1){
                $metode = 'Non Cash';
            }
            else{
                $metode = 'Cash';
            }

            Pembelian::where('id_invoice', $pembelian->id_invoice)->update(['status' => 'Y', 'metode' => $metode]);
        }
        else{
            SubAkuns::where('id', $request->akunmasuk)->first()->increment('saldo', $totalNetto);
            SubAkuns::where('id', 16)->first()->decrement('saldo', $totalNetto);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunmasuk,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => $totalNetto,
                'kredit' => 0
            ]);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 16,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => 0,
                'kredit' => $totalNetto
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
        $subakuns = SubAkuns::where('id_akun','<=',2)->get();
        $pembelian = Pembelian::where('id',$id)->first();
        $subakunterimas = SubAkuns::where('id_akun',5)->get();

        $tanggal = \Carbon\Carbon::parse($pembelian->tanggal)->format('m-d-Y');
        $jatuh_tempo = \Carbon\Carbon::parse($pembelian->jatuh_tempo)->format('m-d-Y');
        $detailPembelians =DetailPembelian::where('id_pembelian',$pembelian->id)->get();
        return view('transaksi.pembelian.edit')->with('subakuns',$subakuns)->with('pembelian',$pembelian)->with('detailPembelians',$detailPembelians)->with('suppliers',$suppliers)->with('barangs',$barangs)->with('tanggal',$tanggal)->with('jatuh_tempo',$jatuh_tempo)->with('subakunterimas',$subakunterimas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $pembelianawal = DB::table('pembelians')->where('id',$id)->first();
        $id_akunmasuk = $pembelianawal->id_akunmasuk;
        $tanggal = \Carbon\Carbon::parse($request->tanggal);
        $jatuh_tempo = \Carbon\Carbon::parse($request->jatuh_tempo);
        $totalNetto = preg_replace('/[^0-9.]/', '', $request->totalNetto);
        Pembelian::findOrFail($id)->update([
            'tanggal'=>$tanggal,
            'id_supplier'=>$request->id_supplier,
            'netto'=>$totalNetto,
            'jatuh_tempo'=>$jatuh_tempo,
            'status'=> 'N',
            'id_akunmasuk'=>$request->akunmasuk,
        ]);

        //get id pembelian yang di update
        $pembelian = DB::table('pembelians')->where('id',$id)->first();

        $detailPembelians = DetailPembelian::where('id_pembelian',$pembelian->id)->get();

        foreach($detailPembelians as $detailPembelian){
            $barang = Barang::where('id',$detailPembelian->id_barang)->first();
            if($detailPembelian->uom == $barang->uombesar){
                $barang->decrement('stok',$detailPembelian->jumlah * $barang->satuankecil);
            }
            else{
                $barang->decrement('stok',$detailPembelian->jumlah);
            }
        }

        //delete detailpembelian sebelumnya
        DetailBarang::where('id_invoice',$pembelian->id_invoice)->delete();
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
            $barang = Barang::where('id',$item['id'])->first();

            $stoktambahdetail = 0;
            if($item['uom'] == $barang->uombesar){
                $barang->increment('stok',$item['jumlah']*$barang->satuankecil);
                $stoktambahdetail = $item['jumlah']*$barang->satuankecil;
                $harga = $harga / $barang->satuankecil;
            }
            else{
                $barang->increment('stok',$item['jumlah']);
                $stoktambahdetail = $item['jumlah'];
            }

            //tambah detail barang
            $barang = Barang::where('id',$item['id'])->first();
            DetailBarang::create([
                'tanggal' => $tanggal,
                'id_barang' => $item['id'],
                'id_invoice' => $pembelian->id_invoice,
                'masuk' =>  $stoktambahdetail,
                'harga_masuk' => $harga,
                'keluar' => 0,
                'stokdetail' => $stoktambahdetail,
                'stokakhir' => $barang->stok,
            ]);
        }

        //balikin saldo TODO
        $detailSubAkunMasuk = DetailSubAkuns::where('id_bukti',$pembelian->id_invoice)->first();
        $detailSubAkunKeluar = DetailSubAKuns::where('id_bukti',$pembelian->id_invoice)->latest('id')->first();
        SubAkuns::where('id', $id_akunmasuk)->first()->decrement('saldo', $detailSubAkunMasuk->debit);
        SubAkuns::where('id', 16)->first()->increment('saldo', $detailSubAkunKeluar->kredit);

        DetailSubAkuns::where('id_bukti',$pembelian->id_invoice)->delete();

        if($request->pembayaran == 1){
            SubAkuns::where('id', $request->akunmasuk)->first()->increment('saldo', $totalNetto);
            SubAkuns::where('id',$request->akunkeluar)->first()->decrement('saldo', $totalNetto);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunmasuk,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => $totalNetto,
                'kredit' => 0
            ]);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunkeluar,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => 0,
                'kredit' => $totalNetto
            ]);

            $metode = '';
            $subakuns = SubAkuns::where('id', $request->akunkeluar)->first();
            if($subakuns->id_akun == 1){
                $metode = 'Non Cash';
            }
            else{
                $metode = 'Cash';
            }

            Pembelian::where('id_invoice', $pembelian->id_invoice)->update(['status' => 'Y', 'metode' => $metode]);
        }
        else{
            SubAkuns::where('id', $request->akunmasuk)->first()->increment('saldo', $totalNetto);
            SubAkuns::where('id', 16)->first()->decrement('saldo', $totalNetto);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => $request->akunmasuk,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => $totalNetto,
                'kredit' => 0
            ]);

            DetailSubAkuns::create([
                'tanggal' => $tanggal,
                'id_subakun' => 16,
                'id_bukti' => $pembelian->id_invoice,
                'deskripsi' => $pembelian->id_invoice,
                'debit' => 0,
                'kredit' => $totalNetto
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
        $pembelian = DB::table('pembelians')->where('id',$id)->first();

        $detailPembelians = DetailPembelian::where('id_pembelian',$pembelian->id)->get();
        DetailBarang::where('id_invoice',$pembelian->id_invoice)->delete();
        $detailSubAkunMasuk = DetailSubAkuns::where('id_bukti',$pembelian->id_invoice)->first();
        $detailSubAkunKeluar = DetailSubAKuns::where('id_bukti',$pembelian->id_invoice)->latest('id')->first();
        SubAkuns::where('id', $pembelian->id_akunmasuk)->first()->decrement('saldo', $detailSubAkunMasuk->debit);
        SubAkuns::where('id', 16)->first()->increment('saldo', $detailSubAkunKeluar->kredit);
        DetailSubAkuns::where('id_bukti',$pembelian->id_invoice)->delete();

        foreach($detailPembelians as $detailPembelian){
            $barang = Barang::where('id',$detailPembelian->id_barang)->first();
            if($detailPembelian->uom == $barang->uombesar){
                $barang->decrement('stok',$detailPembelian->jumlah * $barang->satuankecil);
            }
            else{
                $barang->decrement('stok',$detailPembelian->jumlah);
            }
        }

        Pembelian::where('id',$id)->delete();

        DB::table('detail_pembelians')->where('id_pembelian', $id)->delete();

        return redirect('/pembelian');

    }

    public function cetakpdf(string $id){
        $pembelian = Pembelian::where('id',$id)->first();
        $detailPembelians = DetailPembelian::where('id_pembelian',$pembelian->id)->get();
        return view('transaksi.pembelian.cetak')->with('pembelian',$pembelian)->with('detailPembelians',$detailPembelians);
    }


    public function bayar(Request $request){
        $selectedIds = $request->input('selectedIds');
        $selectedIdsArray = explode(',', $selectedIds);

        $subsementara = SubAkuns::where('id',$request->subakuns)->first();

        //create array for store array invoice

        //Perubahan status transaksi
        foreach($selectedIdsArray as $item){
            Pembelian::where('id',$item)->update(['status' => 'Y']);
            if($subsementara->id_akun == 1){
                Pembelian::where('id',$item)->update(['metode' => 'Non Cash']);
            }else{
                Pembelian::where('id',$item)->update(['metode' => 'Cash']);
            }
        }


        //Kurangi Saldo
        $totalprice =    (int) (preg_replace('/[^\d]+/', '', $request->totalPrice))/100;
        SubAkuns::where('id',$request->subakuns)->decrement('saldo',$totalprice);

        //tambahin detail sub akun
        DetailSubAkuns::insert([
            'tanggal' => now(),
            'id_subakun' => $request->subakuns,
            'deskripsi' => "Pembelian Barang",
            'debit' => 0,
            'kredit' => $totalprice,
        ]);

        $detailsubakun = DB::table('detail_sub_akuns')->latest('id')->first();


        //tambahin rincian detail sub akun
        foreach($selectedIdsArray as $item){
            $pembelian = Pembelian::where('id',$item)->first();
            DetailHistorySubAkuns::insert([
                'id_detailsubakun' => $detailsubakun->id,
                'id_invoice' => $pembelian->id_invoice
            ]);
        }

        DetailSubAkuns::insert([
            'tanggal' => now(),
            //TODO GANTI
            'id_subakun'=> 16,
            'Deskripsi' => "Pelunasan Pembelian Barang",
            'debit' => $totalprice,
            'kredit' => 0
        ]);

        $detailsubakun = DB::table('detail_sub_akuns')->latest('id')->first();
        SubAkuns::where('id',16)->increment('saldo',$totalprice);


        foreach($selectedIdsArray as $item){
            $pembelian = Pembelian::where('id',$item)->first();
            DetailHistorySubAkuns::insert([
                'id_detailsubakun' => $detailsubakun->id,
                'id_invoice' => $pembelian->id_invoice
            ]);
        }



        return redirect('/pembelian');
    }
}
