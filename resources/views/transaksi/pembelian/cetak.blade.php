<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sinar Diesel Truck | Invoice Pembelian </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/AdminLTE/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/AdminLTE/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/AdminLTE/plugins/summernote/summernote-bs4.min.css">
  <style type="text/css" media="print">
    @page { size: landscape; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
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
                      <th style="width: 5%">#</th>
                      <th style="width: 45%">Barang</th>
                      <th style="width: 5%">Jumlah</th>
                      <th style="width: 5%">UOM</th>
                      <th style="width: 10%">Harga</th>
                      <th style="width: 10%">Bruto</th>
                      <th style="width: 10%">Diskon</th>
                      <th style="width: 10%">Netto</th>
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
                <div class="col-8">

                </div>
                <!-- /.col -->
                <div class="col-4">
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

            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
</body>
<script>
    window.addEventListener("load", window.print());
  </script>
