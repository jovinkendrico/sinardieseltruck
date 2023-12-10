<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Perlengkapan;
use Illuminate\Http\Request;

class PerlengkapansController extends Controller
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
            $perlengkapans = Perlengkapan::where('nama', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $perlengkapans = Perlengkapan::latest()->paginate($perPage);
        }

        return view('admin.perlengkapans.index', compact('perlengkapans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.perlengkapans.create');
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
        
        Perlengkapan::create($requestData);

        return redirect('admin/perlengkapans')->with('flash_message', 'Perlengkapan added!');
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
        $perlengkapan = Perlengkapan::findOrFail($id);

        return view('admin.perlengkapans.show', compact('perlengkapan'));
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
        $perlengkapan = Perlengkapan::findOrFail($id);

        return view('admin.perlengkapans.edit', compact('perlengkapan'));
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
        
        $perlengkapan = Perlengkapan::findOrFail($id);
        $perlengkapan->update($requestData);

        return redirect('admin/perlengkapans')->with('flash_message', 'Perlengkapan updated!');
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
        Perlengkapan::destroy($id);

        return redirect('admin/perlengkapans')->with('flash_message', 'Perlengkapan deleted!');
    }
}
