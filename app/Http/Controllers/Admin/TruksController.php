<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Truk;
use Illuminate\Http\Request;

class TruksController extends Controller
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
            $truks = Truk::where('plat', 'LIKE', "%$keyword%")
                ->orWhere('jenis', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $truks = Truk::latest()->paginate($perPage);
        }

        return view('admin.truks.index', compact('truks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.truks.create');
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
        
        Truk::create($requestData);

        return redirect('admin/truks')->with('flash_message', 'Truk added!');
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
        $truk = Truk::findOrFail($id);

        return view('admin.truks.show', compact('truk'));
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
        $truk = Truk::findOrFail($id);

        return view('admin.truks.edit', compact('truk'));
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
        
        $truk = Truk::findOrFail($id);
        $truk->update($requestData);

        return redirect('admin/truks')->with('flash_message', 'Truk updated!');
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
        Truk::destroy($id);

        return redirect('admin/truks')->with('flash_message', 'Truk deleted!');
    }
}
