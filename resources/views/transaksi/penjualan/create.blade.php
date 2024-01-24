@extends('layouts.app2')
@section('title', 'Penjualan')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Penjualan</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form" action="{{route('penjualan.store')}}" onsubmit="return prepareAndSubmitForm()" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tableData" id="tableData" value="">
                            <input type="hidden" name="tableDataJasa" id="tableDataJasa" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Existing fields as per your design -->
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal:</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" onchange="onTanggalChange()" id="tanggal" name="tanggal" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="Masukkan Tanggal"/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="jatuh_tempo">Jatuh Tempo:</label>
                                        <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                            <input type="text" id="jatuh_tempo" name="jatuh_tempo" class="form-control datetimepicker-input" data-target="#reservationdate2" placeholder="Masukkan Tanggal Jatuh Tempo">
                                            <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_supplier">Customer:</label>
                                        <input type="hidden" id="id_customer" name="id_customer" value="">
                                        <select class="form-control select2bs4" id="id_cus" name="id_cus" style="width: 100%;">
                                            <option disabled selected value> -- select an customer -- </option>
                                            @foreach ($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_truk">Truk:</label>
                                        <input type="hidden" id="id_truk" name="id_truk" value="">
                                        <select class="form-control select2bs4" id="id_tr" name="id_tr" style="width: 100%;">
                                            <option disabled selected value> -- select an truk -- </option>
                                            @foreach ($truks as $truk)
                                            <option value="{{$truk->id}}">{{$truk->plat}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="barang">Barang:</label>
                                        <select class="form-control select2bs4" id="barang" name="barang" style="width: 100%;" onchange="updateUOM()">
                                            <option disabled selected value> -- select an item -- </option>
                                            @foreach ($barangs as $barang)
                                                <option data-uombesar="{{ $barang->uombesar }}" data-uomkecil="{{ $barang->uomkecil }}" value="{{ $barang->id }}">{{ $barang->nama}} <span>- Stok: {{$barang->stok}} - Harga: {{$barang->harga}}</span> </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="uom">Uom:</label>
                                        <select class="form-control select2bs4" id="uom" name="uom" style="width: 100%;">
                                            <option disabled selected value> ---- </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah:</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="harga">Harga:</label>
                                        <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="diskon">Diskon:</label>
                                        <input type="number" class="form-control" id="diskon" name="diskon" placeholder="Masukkan diskon">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Tambah</label><br>
                                        <button type="button" class="btn btn-success" onclick="addRow()">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>List Barang:</h4>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <!-- Table to display added items -->
                                    <table class="table" id="itemTable">
                                        <thead>
                                            <tr>
                                                <th style="display: none;">id</th>
                                                <th>Barang</th>
                                                <th>Jumlah</th>
                                                <th>UOM</th>
                                                <th>Harga</th>
                                                <th>Bruto</th>
                                                <th>Diskon</th>
                                                <th>Netto</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Added items will appear here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jasa">Jasa:</label>
                                        <select class="form-control select2bs4" id="jasa" name="jasa" style="width: 100%;">
                                            <option disabled selected value> -- select an jasa -- </option>
                                            @foreach ($jasas as $jasa)
                                                <option value="{{ $jasa->id }}">{{ $jasa->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="pihakjasa">Pihak Jasa:</label>
                                        <select class="form-control select2bs4" id="pihakjasa" name="pihakjasa" style="width: 100%;">
                                            <option disabled selected value> -- select an pihak -- </option>
                                            @foreach ($pihakjasas as $pihakjasa)
                                                <option value="{{ $pihakjasa->id }}">{{ $pihakjasa->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="hargajasamodal">Modal:</label>
                                        <input type="number" class="form-control" id="hargajasamodal" name="hargajasamodal" placeholder="Masukkan Harga Modal">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="hargajasa">Harga:</label>
                                        <input type="number" class="form-control" id="hargajasa" name="hargajasa" placeholder="Masukkan Harga Jasa">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Tambah</label><br>
                                        <button type="button" class="btn btn-success" onclick="addRowJasa()">Tambah</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <h4>
                                    List Jasa:
                                </h4>
                                </div>
                                <div class="col-md-12">
                                <table class="table" id="jasaTable">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">ID</th>
                                            <th>Jasa</th>
                                            <th style="display:none">IDp</th>
                                            <th>Pihak Jasa</th>
                                            <th>Modal</th>
                                            <th>Harga</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pembayaran">Pembayaran: </label>
                                        <select class="form-control select2bs4" id="pembayaran" name="pembayaran" style="width: 100%;">
                                            <option disabled selected value> -- select an pembayaran -- </option>
                                            <option value="1">Kontan</option>
                                            <option value="2">Non Kontan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="akunkeluar">Dari Akun: </label>
                                        <select class="form-control select2bs4" id="akunkeluar" name="akunkeluar" style="width: 100%;">
                                            <option disabled selected value> -- select an akun -- </option>
                                            @foreach ($subakundaris as $subakundari)
                                            <option value="{{ $subakundari->id }}"> {{$subakundari->nomor_akun}}- {{ $subakundari->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="terimaKeContainer" style="display: none;">
                                        <label for="akunmasuk">Terima Akun: </label>
                                        <select class="form-control select2bs4" name="akunmasuk" id="akunmasuk" style="width: 100%">
                                            <option disabled selected value=""> -- select an akun -- </option>
                                            @foreach ($subakuns as $subakun)
                                            <option value="{{ $subakun->id }}"> {{$subakun->nomor_akun}}- {{ $subakun->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group"  style="width: 100%;">
                                        <label for="akunkeluarjasa">Dari Akun Jasa : </label>
                                        <select class="form-control select2bs4" name="akunkeluarjasa" id="akunkeluarjasa" style="width: 100%">
                                            <option disabled selected value=""> -- select an akun -- </option>
                                            @foreach ($subakunslengkap as $sublengkap)
                                            <option value="{{ $sublengkap->id }}"> {{$sublengkap->nomor_akun}}- {{ $sublengkap->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Total Bruto :</th>
                                                <td><input type="text" class="form-control" id="totalBruto" name="totalBruto" value="Rp 0.00" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Total Diskon :</th>
                                                <td><input type="text" class="form-control" id="totalDiskon" name="totalDiskon" value="Rp 0.00" readonly></td>
                                            </tr>
                                            <tr>
                                                <th>Total Netto :</th>
                                                <td><input type="text" class="form-control" id="totalNetto" name="totalNetto" value="Rp 0.00" readonly></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h2>History Penjualan Terdahulu</h2>
                                    <table class="table" id="historyPenjualan">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>No Faktur</th>
                                                <th>Customer</th>
                                                <th>QTY</th>
                                                <th>UOM</th>
                                                <th>Harga/UOM</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group float-right">
                                        <input class="btn btn-primary" type="submit" value="Create">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
          jatuh_tempo: {
            required: true,
          },
          id_cus: {
            required: true
          },
          id_tr: {
            required: true
          },
          pembayaran: {
            required: true
          },
          akunkeluar: {
            required: true
          }
        },
        messages: {
          tanggal: {
            required: "Please submit Tanggal",
          },
          jatuh_tempo: {
            required: "Please submit Jatuh Tempo",
          },
          id_cus: "Please submit Customer",
          id_tr: "Please submit Truk",
          pembayaran: "Please submit Pembayaran",
          akunkeluar: "Please submit Akun Keluar"
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
        function toggleTerimaKe() {
            var pembayaranSelect = document.getElementById("pembayaran");
            var terimaKeContainer = document.getElementById("terimaKeContainer");

            if (pembayaranSelect.value === "1") {
                // Show Terima ke field when Pembayaran is Kontan
                terimaKeContainer.style.display = "block";
            } else {
                // Hide Terima ke field for other Pembayaran options
                terimaKeContainer.style.display = "none";
            }
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
        document.getElementById("tableDataJasa").value = tableToJSON(document.getElementById('jasaTable'))
        console.log(tableToJSON(document.getElementById('itemTable')))
        console.log(tableToJSON(document.getElementById('jasaTable')))
    }

    function extractNumericValue(value) {
    // Extract numeric value from a string (assuming 'Rp. xxx' format)
        return parseFloat(value.replace('Rp ', '').replace(',', ''));
    }

    function addRow() {
            // Get values from the input fields
            var barang = document.getElementById("barang");
            var uom = document.getElementById("uom");
            var jumlah = document.getElementById("jumlah");
            var harga = document.getElementById("harga");
            var diskon = document.getElementById("diskon");

            // Create a new row in the table
            var table = document.getElementById("itemTable");
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);
            var cell9 = row.insertCell(8);

            // Disable the input fields after adding an item
            document.getElementById("id_customer").value = document.getElementById('id_cus').value
            document.getElementById("id_truk").value = document.getElementById('id_tr').value
            document.getElementById("tanggal").readOnly = true;
            document.getElementById("id_cus").disabled = true;
            document.getElementById("id_tr").disabled = true;
            document.getElementById("jatuh_tempo").readOnly = true;

            // Set the cell values
            cell1.innerHTML = barang.options[barang.selectedIndex].value;
            cell1.style.display = 'none'
            cell2.innerHTML = '<span class="clickable" onclick="fetchHistoryPenjualan('+barang.options[barang.selectedIndex].value+')">' + barang.options[barang.selectedIndex].text + '</span>';
            cell3.innerHTML = jumlah.value;
            cell4.innerHTML = uom.value;
            cell5.innerHTML = 'Rp ' + harga.value;
            cell6.innerHTML = 'Rp ' + (harga.value * jumlah.value);
            cell7.innerHTML = 'Rp ' + ((harga.value * jumlah.value) * diskon.value / 100);
            cell8.innerHTML = 'Rp ' + ((harga.value * jumlah.value) - ((harga.value * jumlah.value) * diskon.value / 100));
            cell9.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>';

            getTableData();
            updateTotals();
            // Clear input fields after adding a row
            barang.value = "";
            uom.value = "";
            jumlah.value = "";
            harga.value = "";
            diskon.value = "";
        }

        function deleteRow(btn) {
            // Delete the row from the table
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateTotals();

        }

    function formatNumberWithLeadingZeros(number, length) {
        return number.toString().padStart(length, '0');
    }

    function updateUOM() {
        var selectedBarang = document.getElementById("barang");
        var selectedBarangIndex = selectedBarang.selectedIndex;

        var uombesar = selectedBarang.options[selectedBarangIndex].getAttribute("data-uombesar");
        var uomkecil = selectedBarang.options[selectedBarangIndex].getAttribute("data-uomkecil");

        // Set the UOM options in the UOM dropdown
        var uomSelect = document.getElementById("uom");
        uomSelect.innerHTML = '<option>'+'----'+'</option><option>' + uombesar + '</option><option>' + uomkecil + '</option>';
    }
        //Initialize totals
    // var totalBruto = 0;
    // var totalDiskon = 0;
    // var totalNetto = 0;


        function updateTotals() {
        // Update totals
        var table = document.getElementById("itemTable");
        var totalBruto = 0;
        var totalDiskon = 0;
        var totalNetto = 0;

        for (var i = 0, row; row = table.rows[i]; i++) {
            // Skip the header row
            if (i === 0) {
                continue;
            }

            var bruto = parseFloat(row.cells[5].innerText.replace('Rp ', ''));
            var diskon = parseFloat(row.cells[6].innerText.replace('Rp ', ''));
            var netto = parseFloat(row.cells[7].innerText.replace('Rp ', ''));

            totalBruto += bruto;
            totalDiskon += diskon;
            totalNetto += netto;
        }

        var table = document.getElementById("jasaTable");
        for (var i = 0, row; row = table.rows[i]; i++) {
            // Skip the header row
            if (i === 0) {
                continue;
            }

            var bruto = parseFloat(row.cells[5].innerText.replace('Rp ', ''));

            totalBruto += bruto;
            totalNetto += bruto;
        }


        // Display totals
        document.getElementById("totalBruto").value = 'Rp ' + totalBruto.toFixed(2);
        document.getElementById("totalDiskon").value = 'Rp ' + totalDiskon.toFixed(2);
        document.getElementById("totalNetto").value = 'Rp ' + totalNetto.toFixed(2);
    }
    // document.addEventListener("DOMContentLoaded", function() {
    //     initializeTotals();
    // });
    </script>
    <script>
        function addRowJasa(){
            var jasa = document.getElementById("jasa");
            var pihakjasa = document.getElementById("pihakjasa");
            var hargajasamodal = document.getElementById("hargajasamodal");
            var hargajasa = document.getElementById("hargajasa");
            var deskripsi = document.getElementById("deskripsi");

            // Create a new row in the table
            var table = document.getElementById("jasaTable");
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7 = row.insertCell(6);
            var cell8 = row.insertCell(7);


            // Disable the input fields after adding an item
            document.getElementById("id_customer").value = document.getElementById('id_cus').value
            document.getElementById("id_truk").value = document.getElementById('id_tr').value
            document.getElementById("tanggal").readOnly = true;
            document.getElementById("id_cus").disabled = true;
            document.getElementById("id_tr").disabled = true;
            document.getElementById("jatuh_tempo").readOnly = true;

            // Set the cell values
            cell1.innerHTML = jasa.options[jasa.selectedIndex].value;
            cell1.style.display = 'none'
            cell2.innerHTML = jasa.options[jasa.selectedIndex].text ;
            cell3.innerHTML = pihakjasa.options[pihakjasa.selectedIndex].value;
            cell3.style.display = 'none'
            cell4.innerHTML = pihakjasa.options[pihakjasa.selectedIndex].text;
            cell5.innerHTML = 'Rp ' + hargajasamodal.value;
            cell6.innerHTML = 'Rp ' + hargajasa.value;
            cell7.innerHTML = deskripsi.value;
            cell8.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRowJasa(this)">Delete</button>';

            getTableData();
            updateTotals();
            // Clear input fields after adding a row
            jasa.value = "";
            hargajasa.value = "";
            deskripsi.value = "";
        }
        function deleteRowJasa(btn) {
            // Delete the row from the table
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateTotals();

        }
    </script>
    <script>

        function fetchHistoryPenjualan(itemId) {
            // Replace the URL with the actual endpoint to fetch history data
            var url = '{{ route("historypenjualan.get", ["itemId" => ":itemId"]) }}';
                url = url.replace(':itemId', itemId);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the historyPembelian table with the fetched data
                    updateHistoryTable(data);
                })
                .catch(error => {
                    console.error('Error fetching history data:', error);

                    // Optionally, log or display the response content
                    response.text().then(text => console.error('Response content:', text));
                });
        }

                function updateHistoryTable(data) {
                    // Clear the existing table rows
                    var historyTable = $('#historyPenjualan').DataTable();
            historyTable.clear().draw();

            // Populate the table with the fetched data
            data.forEach(rowData => {
                const barangName = rowData.barang ? rowData.barang.nama : 'Unknown Barang';
                const invoice = rowData.penjualan ? rowData.penjualan.id_invoice : 'Unknown Invoice';
                const customer = rowData.penjualan.customer ? rowData.penjualan.customer.nama : 'Unknown Customer';
                historyTable.row.add([barangName, invoice, customer, rowData.jumlah, rowData.uom, "Rp " +  rowData.harga]).draw();
            });
                }
            </script>

@endsection
