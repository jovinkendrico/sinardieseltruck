
@extends('layouts.app2')

@section('title','Penjualan')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Penjualan</h3>
              <a href="{{ route('penjualan.create') }}" class="btn btn-success btn-sm float-right" title="Add New Penjualan">
                <i class="fa fa-plus" aria-hidden="true"></i> Add New
            </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 5%">ID</th>
                  <th style="widht: 10%">Tanggal</th>
                  <th style="width: 10%">Invoice</th>
                  <th style="width: 12%">Customer</th>
                  <th style="width: 10%">Plat</th>
                  <th style="width: 14%">Netto</th>
                  <th style="width: 19%">Pendapatan Barang</th>
                  <th style="width: 18%">Pendapatan Jasa</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($penjualans as $penjualan)
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y')}}</td>
                      <td>{{$penjualan->id_invoice}}</td>
                      <td>{{$penjualan['customer']['nama']}}</td>
                      <td>{{$penjualan['truk']['plat']}}</td>
                      <td>Rp. {{number_format($penjualan->netto, 2, '.', ',')}}</td>
                      <td>Rp. {{number_format($penjualan->pendapatanbarang, 2, '.', ',')}}</td>
                      <td>Rp. {{number_format($penjualan->pendapatanjasa, 2, '.', ',')}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</div>d
@endsection
