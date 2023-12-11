<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use Illuminate\Http\Request;

class HistoryPembelianController extends Controller
{
    //
    public function getHistory($itemId)
    {
        // Replace this with your logic to fetch history data from the database
        $historyData = DetailPembelian::with(['barang','pembelian','pembelian.supplier'])->where('id_barang', $itemId)->get();

        return response()->json($historyData);
    }
}
