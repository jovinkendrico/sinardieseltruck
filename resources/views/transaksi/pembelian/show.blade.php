
@extends('layouts.app2')

@section('title','Invoice Pembelian')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
                <h2>
                    <i class="fas fa-globe"></i>
                    Sinar Diesel Truck
                </h2>
              </div>
            <div class="col-12">
              <h4>
                 {{$pembelian->id_invoice}}
              </h4>
            </div>

                <div class="col-12">
                    <h4>
                        <small>Tanggal: {{\Carbon\Carbon::parse($pembelian->tanggal)->format('d-m-Y')}}</small>
                        <small class="float-right">Jatuh Tempo: {{\Carbon\Carbon::parse($pembelian->jatuh_tempo)->format('d-m-Y')}}</small>

                    </h4>
                </div>
            <div class="col-12">
                <h4>
                    <small>Supplier: {{$pembelian['supplier']['nama']}}</small>
                </h4>
              </div>

            <!-- /.col -->
          </div>
          <!-- info row -->
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Barang</th>
                  <th>Jumlah</th>
                  <th>UOM</th>
                  <th>Harga</th>
                  <th>Bruto</th>
                  <th>Diskon</th>
                  <th>Netto</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $totalbruto = 0;
                        $totaldiskon = 0;
                        $totalnetto = 0;
                        $i = 1;
                    @endphp
                    @foreach ($detailPembelians as $detailPembelian )
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$detailPembelian['barang']['nama']}}</td>
                        <td>{{$detailPembelian->jumlah}}</td>
                        <td>{{$detailPembelian->uom}}</td>
                        <td>Rp. {{number_format($detailPembelian->harga, 2, '.', ',')}}</td>
                        <td>Rp. {{number_format($detailPembelian->bruto, 2, '.', ',')}}</td>
                        <td>Rp. {{number_format($detailPembelian->diskon, 2, '.', ',')}}</td>
                        <td>Rp. {{number_format($detailPembelian->netto, 2, '.', ',')}}</td>
                    </tr>
                    @php
                        $i++;
                        $totalbruto+=$detailPembelian->bruto;
                        $totaldiskon+=$detailPembelian->diskon;
                        $totalnetto+=$detailPembelian->netto;

                    @endphp
                    @endforeach

                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">

            </div>
            <!-- /.col -->
            <div class="col-6">
              <p class="lead"></p>

              <div class="table-responsive">
                <table class="table">
                    <tr>
                    <th style="width:50%">Total Bruto:</th>
                    <td>Rp. {{number_format($totalbruto, 2, '.', ',')}}</td>
                  </tr>
                  <tr>
                    <th style="width:50%">Total Diskon:</th>
                    <td>Rp. {{number_format($totaldiskon, 2, '.', ',')}}</td>
                  </tr>
                  <tr>
                    <th style="width:50%">Total Netto:</th>
                    <td>Rp. {{number_format($totalnetto, 2, '.', ',')}}</td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
                <form method="GET" target="_blank" action="{{route('pembelian.cetak',$pembelian->id)}}">
                        <input type="submit" class="btn btn-primary float-right" value="Generate PDF" style="margin-right: 5px;">

                          </input>
                </form>

            </div>
          </div>
        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div>
@endsection
