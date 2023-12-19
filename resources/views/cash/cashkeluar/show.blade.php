
@extends('layouts.app2')

@section('title','Laporan Cash Keluar')
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
                 {{$cashkeluar->id_bukti}}
              </h4>
            </div>

                <div class="col-12">
                    <h4>
                        <small>Tanggal: {{$cashkeluar->tanggal}}</small>
                    </h4>
                </div>
            <div class="col-12">
                <h4>
                    <small>Kas Keluar: {{$cashkeluar['akunkeluar']['nama']}}</small>
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
                  <th>Akun Masuk</th>
                  <th>Deskripsi</th>
                  <th>Jumlah</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $totaljumlah = 0;
                        $i = 1;
                    @endphp
                    @foreach ($detailcashkeluars as $detailcashkeluar)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$detailcashkeluar['akunmasuk']['nama']}}</td>
                        <td>{{$detailcashkeluar->deskripsi}}</td>
                        <td>Rp {{$detailcashkeluar->jumlah}}</td>
                    </tr>
                    @php
                        $i++;
                        $totaljumlah+=$detailcashkeluar->jumlah;

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
                    <th style="width:50%">Total Jumlah:</th>
                    <td>Rp. {{$totaljumlah}}</td>
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
                <form method="GET" target="_blank" action="">
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
