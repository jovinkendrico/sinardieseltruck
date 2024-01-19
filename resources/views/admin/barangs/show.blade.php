@extends('layouts.app2')

@section('title','Barang')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Barang {{$barang->nama}}</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Sisa Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>-</td>
                                    <td>{{\Carbon\Carbon::parse($barang->created_at)->format('d-m-Y')}}</td>
                                    <td>Stok Awal</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{$barang->stokawal}}</td>
                                </tr>
                                @php
                                    $stok = $barang->stokawal;
                                @endphp
                                @foreach ($detailbarangs as $detailbarang)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{\Carbon\Carbon::parse($detailbarang->tanggal)->format('d-m-Y')}}</td>
                                    <td>{{$detailbarang->id_invoice}}</td>
                                    <td>{{$detailbarang->masuk}}</td>
                                    <td>{{$detailbarang->keluar}}</td>
                                    @php
                                        $stok = $stok + $detailbarang->masuk -$detailbarang->keluar;
                                    @endphp
                                    <td>{{$stok}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
