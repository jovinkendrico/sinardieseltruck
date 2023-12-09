@extends('layouts.app2')
@section('title', 'Pembelian')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('pembelian.store')}}" onsubmit="return prepareAndSubmitForm()" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tableData" id="tableData" value="">
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
                                        <label for="id_invoice">No Invoice:</label>
                                        <input type="text" class="form-control" id="id_invoice" name="id_invoice" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_supplier">Supplier</label>
                                        <input type="hidden" name="id_supplier" id="id_supplier" value="">
                                        <select class="form-control select2bs4" id="id_supp" name="id_supp" style="width: 100%;">
                                            <option disabled selected value> -- select an supplier -- </option>
                                            @foreach ($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->nama}}</option>
                                            @endforeach
                                        </select>
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
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="barang">Barang:</label>
                                        <select class="form-control select2bs4" id="barang" name="barang" style="width: 100%;" onchange="updateUOM()">
                                            <option disabled selected value> -- select an item -- </option>
                                            @foreach ($barangs as $barang)
                                                <option data-uombesar="{{ $barang->uombesar }}" data-uomkecil="{{ $barang->uomkecil }}" value="{{ $barang->id }}">{{ $barang->nama }}</option>
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
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tambah</label>
                                        <button type="button" class="btn btn-success" onclick="addRow()">Tambah Barang</button>
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
                                <div class="col-md-8">
                                    <h2>History Pembelian Terdahulu</h2>
                                    <table class="table" id="historyPembelian">
                                        <thead>
                                            <tr>
                                                <th>No Faktur</th>
                                                <th>Supplier</th>
                                                <th>Nama Barang</th>
                                                <th>QTY</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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
                                <div class="col-md-12">
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

    <script>
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
            document.getElementById("id_supplier").value = document.getElementById('id_supp').value
            document.getElementById("tanggal").readOnly = true;
            document.getElementById("id_invoice").readOnly = true;
            document.getElementById("id_supp").disabled = true;
            document.getElementById("jatuh_tempo").readOnly = true;

            // Set the cell values
            cell1.innerHTML = barang.options[barang.selectedIndex].value;
            cell1.style.display = 'none'
            cell2.innerHTML = barang.options[barang.selectedIndex].text;
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

    // Function to get or initialize the sequential number from local storage
    function getSequentialNumber() {
        var storedNumber = localStorage.getItem('sequentialNumber');
        return storedNumber ? parseInt(storedNumber) : 0;
    }

    // Function to save the updated sequential number to local storage
    function saveSequentialNumber(number) {
        localStorage.setItem('sequentialNumber', number.toString());
    }

    // Function to generate the invoice number
    function generateInvoice() {
        // Get the selected date
        var selectedDate = document.getElementById("tanggal").value;

        // Extract month and year from the date (assuming dd/mm/yy format)
        var mm = selectedDate.split('/')[0];
        var yy = selectedDate.split('/')[2].slice(-2);

        // Get the formatted sequential number with leading zeros
        var sequentialNumber = getSequentialNumber();
        var formattedSequentialNumber = formatNumberWithLeadingZeros(sequentialNumber, 4);

        // Construct the invoice number
        var invoiceNumber = 'PB/' + mm + yy + '/' + formattedSequentialNumber;

        // Set the generated invoice number to the input field
        document.getElementById("id_invoice").value = invoiceNumber;

        // Increment the sequential number and save it
        saveSequentialNumber(sequentialNumber + 1);
        return invoiceNumber;
    }

    // Attach the generateInvoice function to the change event of the tanggal field
    function onTanggalChange() {
        // Generate and set the invoice number when Tanggal is changed
        var generatedInvoice = generateInvoice();
        document.getElementById("id_invoice").value = generatedInvoice;
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

        // Display totals
        document.getElementById("totalBruto").value = 'Rp ' + totalBruto.toFixed(2);
        document.getElementById("totalDiskon").value = 'Rp ' + totalDiskon.toFixed(2);
        document.getElementById("totalNetto").value = 'Rp ' + totalNetto.toFixed(2);
    }
    // document.addEventListener("DOMContentLoaded", function() {
    //     initializeTotals();
    // });
    </script>
@endsection
