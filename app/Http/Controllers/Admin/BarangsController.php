<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangsController extends Controller
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
            $barangs = Barang::where('nama', 'LIKE', "%$keyword%")
                ->orWhere('harga', 'LIKE', "%$keyword%")
                ->orWhere('satuanbesar', 'LIKE', "%$keyword%")
                ->orWhere('satuankecil', 'LIKE', "%$keyword%")
                ->orWhere('uombesar', 'LIKE', "%$keyword%")
                ->orWhere('uomkecil', 'LIKE', "%$keyword%")
                ->orWhere('stok', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $barangs = Barang::latest()->paginate($perPage);
        }

        return view('admin.barangs.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.barangs.create');
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
        Barang::create($requestData);

        return redirect('admin/barangs')->with('flash_message', 'Barang added!');
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
        $barang = Barang::findOrFail($id);

        return view('admin.barangs.show', compact('barang'));
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
        $barang = Barang::findOrFail($id);

        return view('admin.barangs.edit', compact('barang'));
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

        $barang = Barang::findOrFail($id);
        $barang->update($requestData);

        return redirect('admin/barangs')->with('flash_message', 'Barang updated!');
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
        Barang::destroy($id);

        return redirect('admin/barangs')->with('flash_message', 'Barang deleted!');
    }
}
