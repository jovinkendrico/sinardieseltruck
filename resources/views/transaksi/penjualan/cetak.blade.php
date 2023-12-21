<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sinar Diesel Truck | Invoice Penjualan </title>

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
                     {{$penjualan->id_invoice}}
                  </h4>
                </div>

                    <div class="col-12">
                        <h4>
                            <small>Tanggal: {{$penjualan->tanggal}}</small>
                            <small class="float-right">Jatuh Tempo: {{$penjualan->jatuh_tempo}}</small>

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
                        @foreach ($detailPenjualans as $detailPenjualan )
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$detailPenjualan['barang']['nama']}}</td>
                            <td>{{$detailPenjualan->jumlah}}</td>
                            <td>{{$detailPenjualan->uom}}</td>
                            <td>Rp. {{$detailPenjualan->harga}}</td>
                            <td>Rp. {{$detailPenjualan->bruto}}</td>
                            <td>Rp. {{$detailPenjualan->diskon}}</td>
                            <td>Rp. {{$detailPenjualan->netto}}</td>
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
                        <th style="width:5%">#</th>
                        <th style="width:40%">Jasa</th>
                        <th style="width:40%">Deskripsi</th>
                        <th style="width:15%">Harga</th>
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
                              <td>Rp. {{$detailJasa->harga}}</td>
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
                <div class="col-8">

                </div>
                <!-- /.col -->
                <div class="col-4">
                  <p class="lead"></p>

                  <div class="table-responsive">
                    <table class="table">
                        <tr>
                        <th style="width:40%">Total Bruto:</th>
                        <td>Rp. {{$totalbruto}}</td>
                      </tr>
                      <tr>
                        <th style="width:40%">Total Diskon:</th>
                        <td>Rp. {{$totaldiskon}}</td>
                      </tr>
                      <tr>
                        <th style="width:40%">Total Netto:</th>
                        <td>Rp. {{$totalnetto}}</td>
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
</body>
<script>
    window.addEventListener("load", window.print());
  </script>
