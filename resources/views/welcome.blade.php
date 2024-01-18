
@extends('layouts.app2')

@section('title','Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$jumlahBarang}}</h3>

              <p>Barang</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/admin/barangs" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$jumlahPenjualan}}</h3>

              <p>Penjualan</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/penjualan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$jumlahCustomer}}</h3>

              <p>Customer</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="/admin/customers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$jumlahPembelian}}</h3>

              <p>Pembelian</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="/pembelian" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Pembelian dengan Jatuh Tempo Terdekat</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Netto</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelianjts as $pembelianjt)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pembelianjt->id_invoice}}</td>
                            <td>{{$pembelianjt['supplier']['nama']}}</td>
                            <td>Rp {{number_format($pembelianjt->netto, 2, '.', ',')}}</td>
                            <td>{{\Carbon\Carbon::parse($pembelianjt->jatuh_tempo)->format('d-m-Y')}}</td>
                            <td><span class="badge bg-danger">Not Paid</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
                <!-- /.card-body -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Pembelian dengan Jatuh Tempo Terlewat</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Netto</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelianjtls as $pembelianjtl)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pembelianjtl->id_invoice}}</td>
                            <td>{{$pembelianjtl['supplier']['nama']}}</td>
                            <td>Rp {{number_format($pembelianjtl->netto, 2, '.', ',')}}</td>
                            <td>{{\Carbon\Carbon::parse($pembelianjtl->jatuh_tempo)->format('d-m-Y')}}</td>
                            <td><span class="badge bg-danger">Not Paid</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Penjualan dengan Jatuh Tempo Terdekat</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Netto</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualanjts as $penjualanjt)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$penjualanjt->id_invoice}}</td>
                            <td>{{$penjualanjt['customer']['nama']}}</td>
                            <td>Rp {{number_format($penjualanjt->netto, 2, '.', ',')}}</td>
                            <td>{{\Carbon\Carbon::parse($penjualanjt->jatuh_tempo)->format('d-m-Y')}}</td>
                            <td><span class="badge bg-danger">Not Paid</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
                <!-- /.card-body -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Penjualan dengan Jatuh Tempo Terlewat</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Netto</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualanjtls as $penjualanjtl)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$penjualanjtl->id_invoice}}</td>
                            <td>{{$penjualanjtl['customer']['nama']}}</td>
                            <td>Rp {{number_format($penjualanjtl->netto, 2, '.', ',')}}</td>
                            <td>{{\Carbon\Carbon::parse($penjualanjtl->jatuh_tempo)->format('d-m-Y')}}</td>
                            <td><span class="badge bg-danger">Not Paid</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Penjualan</h3>
                  <a href="javascript:void(0);">View Report</a>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">Rp {{number_format($totalSale, 2, '.', ',')}}</span>
                    <span>Total Penjualan</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Dari Bulan Llau</span>
                  </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="250"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Cost
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Revenue
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
      </div>
</div>
@endsection
