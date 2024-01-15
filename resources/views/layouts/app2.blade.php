<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sinar Diesel Truck | @yield('title')</title>

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
  <link rel="stylesheet" href="/AdminLTE/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


  <style>
    .invisible-cell {
        display: none;
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    @include('layouts.navbar')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('layouts.sidebar')
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">@yield('title')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    @include('layouts.footer')
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/AdminLTE/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/AdminLTE/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/AdminLTE/dist/js/pages/dashboard.js"></script>
<script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="/AdminLTE/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/AdminLTE/plugins/select2/js/select2.full.min.js"></script>

<script>
     $(document).ready(function () {
        $('#modal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            console.log('Button Data:', button.data()); // Check if data is logged
            var akunId = button.data('id');
            var nomorAkun = button.data('nomorakun');
            var namaAkun = button.data('nama');
            console.log('ID:', akunId, 'Nomor Akun:', nomorAkun, 'Nama Akun:', namaAkun); // Check individual values
            var modal = $(this);

            // Populate the form fields dynamically
            var editForm = modal.find('#editForm');
            editForm.attr('action', editForm.attr('action').replace(':id', akunId));

            // Use the data from the button to populate the form fields
            modal.find('#edit_nomor_akun').val(nomorAkun);
            modal.find('#edit_nama').val(namaAkun);
        });
    });
    $(function () {

      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      $('.select2').select2();
      $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
      $('#reservationdate').datetimepicker({
        format: 'L'
    });
    $('#reservationdate2').datetimepicker({
        format: 'L'
    });
    });

  </script>

</body>
</html>
