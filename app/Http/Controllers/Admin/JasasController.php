<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Jasa;
use Illuminate\Http\Request;

class JasasController extends Controller
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
            $jasas = Jasa::where('nama', 'LIKE', "%$keyword%")
                ->orWhere('harga', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $jasas = Jasa::latest()->paginate($perPage);
        }

        return view('admin.jasas.index', compact('jasas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.jasas.create');
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
        
        Jasa::create($requestData);

        return redirect('admin/jasas')->with('flash_message', 'Jasa added!');
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
        $jasa = Jasa::findOrFail($id);

        return view('admin.jasas.show', compact('jasa'));
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
        $jasa = Jasa::findOrFail($id);

        return view('admin.jasas.edit', compact('jasa'));
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
        
        $jasa = Jasa::findOrFail($id);
        $jasa->update($requestData);

        return redirect('admin/jasas')->with('flash_message', 'Jasa updated!');
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
        Jasa::destroy($id);

        return redirect('admin/jasas')->with('flash_message', 'Jasa deleted!');
    }
}
