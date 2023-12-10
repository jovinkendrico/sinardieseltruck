@extends('layouts.app2')
@section('title', 'Pengecekan Mobil')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Pengecekan Mobil</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('pengecekan.store')}}" onsubmit="return prepareAndSubmitForm()" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
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
                                        <label for="pemeriksa">Pemeriksa:</label>
                                        <input type="text" class="form-control" id="pemeriksa" name="pemeriksa">
                                    </div>
                                    <div class="form-group">
                                        <label for="pemeriksa">Service:</label>
                                        <input type="text" class="form-control" id="service" name="service">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_truk">Truk:</label>
                                        <input type="hidden" name="id_truk" id="id_truk" value="">
                                        <select class="form-control select2bs4" id="id_tr" name="id_tr" style="width: 100%;" onchange="updateMerk()">
                                            <option disabled selected value> -- select an truk -- </option>
                                            @foreach ($truks as $truk)
                                            <option data-merk={{$truk->jenis}} value="{{$truk->id}}">{{$truk->plat}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jatuh_tempo">Merk Mobil:</label>
                                        <input type="text" class="form-control" id="merk" name="merk" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="barang">Perlengkapan:</label>
                                        <select class="form-control select2bs4" id="perlengkapan" name="perlengkapan" style="width: 100%;">
                                            <option disabled selected value> -- select an item -- </option>
                                            @foreach ($perlengkapans as $perlengkapan)
                                                <option value="{{ $perlengkapan->id }}">{{ $perlengkapan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi:</label>

                                        <select class="form-control select2bs4" id="deskripsi" name="deskripsi" style="width: 100%;">
                                            <option disabled selected value> -- deskripsi -- </option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                            <option value="Ada">Ada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="kondisi">Kondisi:</label>
                                        <select class="form-control select2bs4" id="kondisi" name="kondisi" style="width: 100%;">
                                            <option disabled selected value> -- kondisi -- </option>
                                            <option value="Rusak">Rusak</option>
                                            <option value="Baik">Baik</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tambah</label>
                                        <button type="button" id="button" name="button" class="btn btn-success" onclick="addRow()">Tambah Perlengkapan</button>
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
                                                <th>Perlengkapan</th>
                                                <th>Deskripsi</th>
                                                <th>Kondisi</th>
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
@endsection
<script>
    function updateMerk(){
        var selectedTruck = document.getElementById("id_tr");
        var selectedTruckIndex = selectedTruck.selectedIndex;

        var merk = selectedTruck.options[selectedTruckIndex].getAttribute("data-merk");

        // Set the UOM options in the UOM dropdown
        document.getElementById("merk").value = merk
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
            var perlengkapan = document.getElementById("perlengkapan");
            var kondisi = document.getElementById("kondisi");
            var deskripsi = document.getElementById("deskripsi");

            // Create a new row in the table
            var table = document.getElementById("itemTable");
            var row = table.insertRow(table.rows.length);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);

            // Disable the input fields after adding an item
            document.getElementById("id_truk").value = document.getElementById('id_tr').value
            document.getElementById("tanggal").readOnly = true;
            document.getElementById("pemeriksa").readOnly = true;
            document.getElementById("id_tr").disabled = true;
            document.getElementById("service").readOnly = true;

            // Set the cell values
            cell1.innerHTML = perlengkapan.options[perlengkapan.selectedIndex].value;
            cell1.style.display = 'none'
            cell2.innerHTML = perlengkapan.options[perlengkapan.selectedIndex].text;
            cell3.innerHTML = deskripsi.value;
            cell4.innerHTML = kondisi.value;
            cell5.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>';

            // Clear input fields after adding a row
            perlengkapan.value = "";
            kondisi.value = "";
            deskripsi.value = "";
        }

        function deleteRow(btn) {
            // Delete the row from the table
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateTotals();

        }
</script>
