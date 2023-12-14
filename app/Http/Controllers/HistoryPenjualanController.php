<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Illuminate\Http\Request;

class HistoryPenjualanController extends Controller
{
    //
    public function getHistory($itemId)
    {
        // Replace this with your logic to fetch history data from the database
        $historyData = DetailPenjualan::with(['barang','penjualan','penjualan.customer'])->where('id_barang', $itemId)->get();

        return response()->json($historyData);
    }
}
