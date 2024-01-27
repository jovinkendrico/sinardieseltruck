<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sinar Diesel Truck | Invoice Cash Keluar </title>

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
                       {{$cashkeluar->id_bukti}}
                    </h4>
                  </div>

                      <div class="col-12">
                          <h4>
                              <small>Tanggal: {{ \Carbon\Carbon::parse($cashkeluar->tanggal)->format('d-m-Y')}}</small>
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
                              <td>Rp. {{number_format($detailcashkeluar->jumlah, 2, '.', ',')}}</td>
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
                          <td>Rp. {{number_format($totaljumlah, 2, '.', ',')}}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
      </div>
</body>
<script>
    window.addEventListener("load", window.print());
  </script>
