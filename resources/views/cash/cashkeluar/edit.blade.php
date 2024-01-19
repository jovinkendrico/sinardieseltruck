@extends('layouts.app2')
@section('title', 'Cash Keluar')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Cash Keluar</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form" action="{{route('cashkeluar.update',$cashkeluar->id)}}" onsubmit="return prepareAndSubmitForm()" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tableData" id="tableData" value="">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Existing fields as per your design -->
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" value="{{$tanggal}}" id="tanggal" name="tanggal" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="Masukkan Tanggal"/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="id_invoice">No Invoice:</label>
                                        <input type="text" class="form-control" id="id_invoice" value="{{$cashkeluar->id_bukti}}" name="id_invoice" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="akun_keluar">Akun Kas:</label>
                                        <select class="form-control select2bs4" id="akun_keluar" name="akun_keluar" style="width: 100%;">
                                            <option disabled selected value> -- select an akun -- </option>
                                            @foreach ($subakuns as $subakun)
                                            <option data-merk={{$subakun->id}} value="{{$subakun->id}}" {{ $subakun->id == $cashkeluar->id_akunkeluar ? 'selected' : ''}} >{{$subakun->nomor_akun}} - {{$subakun->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan:</label>
                                        <input type="text" class="form-control" value="{{$cashkeluar->deskripsi}}" id="keterangan" name="keterangan">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Dibayarkan Kepada:</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="akun_masuk">Dibayarkan Kepada:</label>
                                        <select class="form-control select2bs4" id="akun_masuk" name="akun_masuk" style="width: 100%;">
                                            <option disabled selected value> -- select an akun -- </option>
                                            @foreach ($subakuns as $subakun)
                                            <option data-merk={{$subakun->id}} value="{{$subakun->id}}">{{$subakun->nomor_akun}} - {{$subakun->nama}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah:</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">

                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="button" name="button" class="btn btn-success float-right" onclick="addRow()">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <!-- Table to display added items -->
                                    <table class="table" id="itemTable">
                                        <thead>
                                            <tr>
                                                <th style="display: none;">id</th>
                                                <th>Dibayarkan Kepada</th>
                                                <th>Deskripsi</th>
                                                <th>Jumlah</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detailcashkeluars as $detailcashkeluar)
                                            <tr>
                                                <td style="display: none;">{{$detailcashkeluar->id_akunmasuk}}</td>
                                                <td>{{$detailcashkeluar['akunmasuk']['nomor_akun']}} - {{$detailcashkeluar['akunmasuk']['nama']}}</td>
                                                <td>{{$detailcashkeluar->deskripsi}}</td>
                                                <td>Rp {{$detailcashkeluar->jumlah}}</td>
                                                <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
                                            </tr>
                                            @endforeach
                                            <!-- Added items will appear here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">

                                </div>
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Total Jumlah :</th>
                                                <td><input type="text" class="form-control" id="totalJumlah" name="totalJumlah" value="Rp {{$cashkeluar->total}}.00" readonly></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group float-right">
                                        <input class="btn btn-primary" type="submit" value="Update">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>

<script src="/AdminLTE/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/AdminLTE/plugins/jquery-validation/additional-methods.min.js"></script>
<script>
    $(document).ready(function () {
  $('#form').validate({
    rules: {
      tanggal: {
        required: true,
      },
      akun_keluar: {
        required: true,
      },
      keterangan: {
        required: true
      },
    },
    messages: {
      tanggal: {
        required: "Please submit Tanggal",
      },
      akun_keluar: {
        required: "Please submit Akun Keluar",
      },
      keterangan: "Please submit Keterangan",
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },

  });
});
</script>
<script>
            function updateTotals() {
        // Update totals
        var table = document.getElementById("itemTable");
        var totalJumlah = 0;

        for (var i = 0, row; row = table.rows[i]; i++) {
            // Skip the header row
            if (i === 0) {
                continue;
            }

            var jumlah = parseFloat(row.cells[3].innerText.replace('Rp ', ''));

            totalJumlah+= jumlah;
        }

        // Display totals
        document.getElementById("totalJumlah").value = 'Rp ' + totalJumlah.toFixed(2);

    }
        function formatNumberWithLeadingZeros(number, length) {
        return number.toString().padStart(length, '0');
    }


    function prepareAndSubmitForm() {
        // Call the function to update tableData
        var data = getTableData();
        console.log(data);
        // Optionally, you can perform additional validations or actions here

        // Allow the form to be submitted
        return true;
    }
    function tableToJSON(table) {
        var data = [];
    var headers = [];

    // Get headers
    for (var i = 0; i < table.rows[0].cells.length; i++) {
        headers[i] = table.rows[0].cells[i].textContent.toLowerCase();
    }

    // Iterate through rows (start from index 1 to skip the header row)
    for (var i = 1; i < table.rows.length; i++) {
        var row = table.rows[i];
        var rowData = {};

        // Iterate through cells
        for (var j = 0; j < row.cells.length; j++) {
            rowData[headers[j]] = row.cells[j].textContent;
        }

        data.push(rowData);
    }

    return JSON.stringify(data);
    }
    function getTableData() {
        document.getElementById("tableData").value = tableToJSON(document.getElementById('itemTable'))
        console.log(tableToJSON(document.getElementById('itemTable')))
    }
    function addRow() {
            // Get values from the input fields
            var akun_masuk = document.getElementById("akun_masuk");
            var deskripsi = document.getElementById("deskripsi");
            var jumlah = document.getElementById("jumlah");

            // Create a new row in the table
            var table = document.getElementById("itemTable");
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            // Disable the input fields after adding an item
            document.getElementById("tanggal").readOnly = true;
            document.getElementById("id_invoice").readOnly = true;
            document.getElementById("akun_keluar").readOnly = true;

            // Set the cell values
            cell1.innerHTML = akun_masuk.options[akun_masuk.selectedIndex].value;
            cell1.style.display = 'none'
            cell2.innerHTML = akun_masuk.options[akun_masuk.selectedIndex].text;
            cell3.innerHTML = deskripsi.value;
            cell4.innerHTML = 'Rp ' + jumlah.value;
            cell5.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>';

            getTableData();

            updateTotals()
            // Clear input fields after adding a row
            akun_masuk.value = "";
            deskripsi.value = "";
            jumlah.value = "";
        }

        function deleteRow(btn) {
            // Delete the row from the table
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateTotals();

        }
</script>
