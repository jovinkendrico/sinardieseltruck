@extends('layouts.app2')

@section('title','Pihak Jasa')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pihak Jasa {{$pihakjasa->nama}} </h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>Jasa</th>
                                    <th>Harga</th>
                                    <th>Paid</th>
                                    <th>Sisa Bayar</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailjasas as $detailjasa)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{\Carbon\Carbon::parse($detailjasa['penjualan']['tanggal'])->format('d-m-Y')}}</td>
                                    <td>{{$detailjasa['penjualan']['id_invoice']}}</td>
                                    <td>{{$detailjasa['jasa']['nama']}}</td>
                                    <td>Rp {{number_format($detailjasa->harga_modal, 2, '.', ',')}}</td>
                                    <td>Rp {{number_format($detailjasa->paid, 2, '.', ',')}}</td>
                                    <td>Rp {{number_format($detailjasa->harga_modal-$detailjasa->paid, 2, '.', ',')}}</td>
                                    <td class="text-center">
                                        @if($detailjasa->paid < $detailjasa->harga_modal)
                                        <input type="checkbox" class="checkbox" name="checkboxName[]" value="{{ $detailjasa->id }}">
                                        @else
                                        <input type="checkbox" class="checkbox" name="checkboxName[]" value="{{ $detailjasa->id }}" disabled>
                                        @endif
                                    </td>
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
