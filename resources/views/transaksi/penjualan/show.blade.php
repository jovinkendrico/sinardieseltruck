
@extends('layouts.app2')

@section('title','Invoice Penjualan')
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
                 {{$penjualan->id_invoice}}
              </h4>
            </div>

                <div class="col-12">
                    <h4>
                        <small>Tanggal: {{\Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y')}}</small>
                        <small class="float-right">Jatuh Tempo: {{\Carbon\Carbon::parse($penjualan->jatuh_tempo)->format('d-m-Y')}}</small>

                    </h4>
                </div>
            <div class="col-12">
                <h4>
                    <small>Customer: {{$penjualan['customer']['nama']}}</small>
                    <small>Plat: {{$penjualan['truk']['plat']}}</small>
                </h4>
              </div>

            <!-- /.col -->
          </div>
          <!-- info row -->
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-md-12">
                <h5>
                    List Barang:
                </h5>
            </div>
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
                    @foreach ($detailPenjualans as $detailPenjualan )
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$detailPenjualan['barang']['nama']}}</td>
                        <td>{{$detailPenjualan->jumlah}}</td>
                        <td>{{$detailPenjualan->uom}}</td>
                        <td>Rp. {{number_format($detailPenjualan->harga, 2, '.', ',')}}</td>
                        <td>Rp. {{number_format($detailPenjualan->bruto, 2, '.', ',')}}</td>
                        <td>Rp. {{number_format($detailPenjualan->diskon, 2, '.', ',')}}</td>
                        <td>Rp. {{number_format($detailPenjualan->netto, 2, '.', ',')}}</td>
                    </tr>
                    @php
                        $i++;
                        $totalbruto+=$detailPenjualan->bruto;
                        $totaldiskon+=$detailPenjualan->diskon;
                        $totalnetto+=$detailPenjualan->netto;

                    @endphp
                    @endforeach

                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <div class="col-md-12">
                <h5>List Jasa:</h5>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Jasa</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                      @php
                          $i = 1;
                      @endphp
                      @foreach ($detailJasas as $detailJasa )
                      <tr>
                          <td>{{$i}}</td>
                          <td>{{$detailJasa['jasa']['nama']}}</td>
                          <td>{{$detailJasa->deskripsi}}</td>
                          <td>Rp. {{number_format($detailJasa->harga, 2, '.', ',')}}</td>
                      </tr>
                      @php
                          $i++;
                          $totalbruto+=$detailJasa->harga;
                          $totalnetto+=$detailJasa->harga;
                      @endphp
                      @endforeach

                  </tbody>
                </table>
              </div>
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
                <form method="GET" target="_blank" action="{{route('penjualan.cetak',$penjualan->id)}}">
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
