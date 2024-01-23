<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\DetailJasa;
use App\Models\Pihakjasa;
use Illuminate\Http\Request;

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
        return view('admin.pihakjasas.show', compact('pihakjasa', 'detailjasas'));
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
}
