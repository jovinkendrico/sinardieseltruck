<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\DetailJasa;
use App\Models\DetailSubAkuns;
use App\Models\Pihakjasa;
use App\Models\SubAkuns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PihakjasasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;



        if (!empty($keyword)) {
            $pihakjasas = Pihakjasa::where('nama', 'LIKE', "%$keyword%")
                ->orWhere('kontak', 'LIKE', "%$keyword%")
                ->orWhere('alamat', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $pihakjasas = Pihakjasa::latest()->paginate($perPage);
        }

        return view('admin.pihakjasas.index', compact('pihakjasas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pihakjasas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        Pihakjasa::create($requestData);

        return redirect('admin/pihakjasas')->with('flash_message', 'Pihakjasa added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pihakjasa = Pihakjasa::findOrFail($id);
        $detailjasas = DetailJasa::where('id_pihakjasa',$id)->get();
        $subakuns = SubAkuns::where('id_akun','<=',2)->get();
        return view('admin.pihakjasas.show', compact('pihakjasa', 'detailjasas','subakuns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $pihakjasa = Pihakjasa::findOrFail($id);

        return view('admin.pihakjasas.edit', compact('pihakjasa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $pihakjasa = Pihakjasa::findOrFail($id);
        $pihakjasa->update($requestData);

        return redirect('admin/pihakjasas')->with('flash_message', 'Pihakjasa updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Pihakjasa::destroy($id);

        return redirect('admin/pihakjasas')->with('flash_message', 'Pihakjasa deleted!');
    }

    public function bayar(Request $request)
    {
        $selectedIds = $request->input('selectedIds');
        $selectedIdsArray = explode(',', $selectedIds);

        //create array for store array invoice
        $id_subakunpiutang = 0;
        $id_pihakjasa = 0;
        $totalbayar = (int) $request->totalBayar;
        //Perubahan status transaksi
        foreach($selectedIdsArray as $item){
           $detailjasa =  DetailJasa::where('id',$item)->first();
           $id_subakunpiutang = $detailjasa->id_akunmasuk;
           $id_pihakjasa = $detailjasa->id_pihakjasa;
           if($totalbayar > $detailjasa->harga_modal-$detailjasa->paid){
            DetailJasa::where('id',$item)->increment('paid',$detailjasa->harga_modal-$detailjasa->paid);
            $totalbayar -=$detailjasa->harga_modal-$detailjasa->paid;
           }
           else{
            DetailJasa::where('id',$item)->increment('paid',$totalbayar);
            break;
           }
        }


        $totalbayar = (int) $request->totalBayar;
        //Kurangi Saldo
        SubAkuns::where('id',$request->subakuns)->decrement('saldo',$totalbayar);

        //tambahin detail sub akun
        DetailSubAkuns::insert([
            'tanggal' => now(),
            'id_subakun' => $request->subakuns,
            'deskripsi' => "Pembayaran Piutang Jasa",
            'debit' => 0,
            'kredit' => $totalbayar,
        ]);

        DetailSubAkuns::insert([
            'tanggal' => now(),
            //TODO GANTI
            'id_subakun'=> $id_subakunpiutang,
            'Deskripsi' => "Pelunasan Piutang Jasa",
            'debit' => $totalbayar,
            'kredit' => 0
        ]);

        SubAkuns::where('id',$id_subakunpiutang)->increment('saldo',$totalbayar);


        return redirect('/admin/pihakjasas/'.$id_pihakjasa);
    }
}
