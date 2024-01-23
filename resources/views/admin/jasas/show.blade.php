@extends('layouts.app2')

@section('title','Jasa')


@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jasa {{$jasa->nama}} </h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>Pihak Jasa</th>
                                    <th>Harga Modal</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailjasas as $detailjasa)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{\Carbon\Carbon::parse($detailjasa['penjualan']['tanggal'])->format('d-m-Y')}}</td>
                                    <td>{{$detailjasa['penjualan']['id_invoice']}}</td>
                                    <td>{{$detailjasa['pihakjasa']['nama']}}</td>
                                    <td>Rp {{number_format($detailjasa->harga_modal, 2, '.', ',')}}</td>
                                    <td>Rp {{number_format($detailjasa->harga, 2, '.', ',')}}</td>
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
