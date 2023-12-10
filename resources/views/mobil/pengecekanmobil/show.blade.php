
@extends('layouts.app2')

@section('title','Pengecekan Mobil')
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
                <div class="col-6">
                    <h4>
                        <small>Tanggal: {{$pengecekan->tanggal}}</small>
                    </h4>
                </div>
                <div class="col-6">
                    <h4>
                        <small>Plat: {{$pengecekan['truk']['plat']}}</small>
                    </h4>
                </div>
            <div class="col-6">
                <h4>
                    <small>Pemeriksa: {{$pengecekan->pemeriksa}}</small>
                </h4>
              </div>
              <div class="col-6">
                <h4>
                    <small>Jenis: {{$pengecekan['truk']['jenis']}}</small>
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
                  <th>Perlengkapan</th>
                  <th>Deskripsi</th>
                  <th>Kondisi</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($detailPengecekans as $detailPengecekan )
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$detailPengecekan['perlengkapan']['nama']}}</td>
                        <td>@php
                            if($detailPengecekan->deskripsi == 1){
                                echo "Ada";
                            }else{
                                echo "Tidak Ada";
                            }
                        @endphp</td>
                        <td>@php
                            if($detailPengecekan->kondisi == 1){
                                echo "Baik";
                            }else{
                                echo "Rusak";
                            }
                        @endphp</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach

                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
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
