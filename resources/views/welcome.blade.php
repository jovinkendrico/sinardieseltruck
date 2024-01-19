
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Penjualan Terakhir</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Invoice ID</th>
                        <th>Customer</th>
                        <th>Netto</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($penjualanlatest as $penjualan)
                            <tr>

                                <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y')}}</td>
                                <td><a href={{route('penjualan.show',$penjualan->id)}}>{{$penjualan->id_invoice}}</a></td>
                                <td>{{$penjualan['customer']['nama']}}</td>
                                <td>Rp {{number_format($penjualan->netto, 2, '.', ',')}}</td>
                                @if ($penjualan->status =='N')
                                    <td><span class="badge bg-danger">Not Paid</span></td>
                                @else
                                    <td><span class="badge bg-success">Paid</span></td>
                                @endif
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <a href="{{route('penjualan.create')}}" class="btn btn-sm btn-info float-left">Tambah Penjualan</a>
                  <a href="/penjualan" class="btn btn-sm btn-secondary float-right">Lihat Penjualan</a>
                </div>
                <!-- /.card-footer -->
              </div>
        </div>
        <div class="col-md-4">
            <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Kas Masuk {{$bulan}}</span>
                  <span class="info-box-number">Rp {{number_format($kasmasuk, 2, '.', ',')}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="far fa-heart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Kas Keluar {{$bulan}}</span>
                  <span class="info-box-number">Rp {{number_format($kaskeluar, 2, '.', ',')}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Pembelian {{$bulan}}</span>
                  <span class="info-box-number">Rp {{number_format($pembeliankas, 2, '.', ',')}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
              <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="far fa-comment"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Penjualan {{$bulan}}</span>
                  <span class="info-box-number">Rp {{number_format($penjualankas, 2, '.', ',')}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Pembelian dengan Jatuh Tempo Terdekat</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Invoice ID</th>
                        <th>Supplier</th>
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
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Invoice ID</th>
                        <th>Supplier</th>
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
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
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
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
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
