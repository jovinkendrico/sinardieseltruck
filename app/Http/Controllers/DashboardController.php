<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Customer;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jumlahBarang = Barang::count();
        $jumlahPembelian = Pembelian::count();
        $jumlahPenjualan = Penjualan::count();
        $jumlahCustomer = Customer::count();
        $totalSale = Penjualan::sum('netto');
        $penjualanjts = Penjualan::where('status', 'N')->where('jatuh_tempo', '>=', now())->orderBy('jatuh_tempo')->paginate(10);
        $penjualanjtls = Penjualan::where('status', 'N')->where('jatuh_tempo', '<=', now())->orderBy('jatuh_tempo')->paginate(10);
        return view('welcome',compact('jumlahBarang', 'jumlahPembelian', 'jumlahPenjualan', 'jumlahCustomer','totalSale','penjualanjts','penjualanjtls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
