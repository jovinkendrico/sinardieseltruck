@extends('layouts.app2')

@section('title','Pembelian')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Pembelian</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="{{ route('pembelian.create') }}" class="btn btn-success btn-sm" title="Add New Pembelian">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add New
              </a>
              <br/>
              <br/>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Invoice</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Netto</th>
                  <th>Status</th>
                  <th>Jatuh Tempo</th>
                  <th style="width: 20%">Action</th>
                  <th style="width: 5%">Select</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($pembelians as $pembelian)
                  <tr>
                      <td>{{$pembelian->id_invoice}}</td>
                      <td>{{ \Carbon\Carbon::parse($pembelian->tanggal)->format('Y-m-d')}}</td>
                      <td>{{$pembelian['supplier']['nama']}}</td>
                      <td>Rp. {{$pembelian->netto}}</td>
                      <td class="text-center">
                        @php
                            $iconClass = ($pembelian->status == 'N') ? 'fas fa-times text-danger' : 'fas fa-check text-success';
                            echo "<i class='$iconClass'></i>";
                        @endphp
                      </td>
                      <td>{{\Carbon\Carbon::parse($pembelian->jatuh_tempo)->format('Y-m-d')}}</td>


                      <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('pembelian.show', $pembelian->id) }}">
                            <i class="fas fa-folder"></i> View
                        </a>

                        @if($pembelian->status == 'N')
                            <a class="btn btn-info btn-sm" href="{{ route('pembelian.edit', $pembelian->id) }}">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="{{ route('pembelian.delete', $pembelian->id) }}">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        @else
                            <!-- If status is not 'N', show a disabled or alternative button -->
                            <button class="btn btn-info btn-sm" disabled>
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" disabled>
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($pembelian->status == 'N')
                        <input type="checkbox" class="checkbox" name="checkboxName[]" value="{{ $pembelian->id }}">
                        @else
                        <input type="checkbox" class="checkbox" name="checkboxName[]" value="{{ $pembelian->id }}" disabled>
                        @endif
                    </td>

                  </tr>
                  @endforeach
                </tbody>

              </table>
              <button id="filterN" class="btn btn-info btn-sm" style="margin-bottom: 10px;">
                <i class="fas fa-filter"></i> Filter Status Not Paid
            </button>
            <button id="filterY" class="btn btn-warning btn-sm" style="margin-bottom: 10px;">
                <i class="fas fa-filter"></i> Filter Status Paid
            </button>
            <button id="filterAll" class="btn btn-primary btn-sm" style="margin-bottom: 10px;">
                <i class="fas fa-filter"></i> Show All
            </button>

              <button id="paidButton" class="btn btn-success btn-sm float-right" style="width: 100px; height: 40px;" disabled>
                Paid
                </button>
            </div>
            <!-- /.card-body -->
          </div>

          <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
      <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Your Modal Content Here -->
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Confirm Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('pembelian.bayar')}}" id="paymentPembelian" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="selectedIds" id="selectedIds">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="totalPrice">Total Price:</label>
                                    <input type="text" class="form-control" id="totalPrice" name="totalPrice" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="subakun">Dari Akun:</label>
                                    <select class="form-control select2bs4" id="subakuns" name="subakuns" style="width: 100%;">
                                        <option disabled selected value> -- select an akun -- </option>
                                        @foreach ($subakuns as $subakun)
                                            <option value="{{ $subakun->id }}"> {{$subakun->nomor_akun}}- {{ $subakun->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Confirm Payment">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add this inside the <div class="container-fluid"> ... </div> -->



<script>
   document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.querySelectorAll('.checkbox');
    var paidButton = document.getElementById('paidButton');
    var paymentModal = document.getElementById('paymentModal');
    var totalPriceInput = document.getElementById('totalPrice');
    var selectedIdsInput = document.getElementById('selectedIds');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var atLeastOneChecked = Array.from(checkboxes).some(function (cb) {
                return cb.checked;
            });

            paidButton.disabled = !atLeastOneChecked;
        });
    });

    paidButton.addEventListener('click', function () {
        var selectedIds = getSelectedIds();
        var totalPrice = calculateTotalPrice();

        selectedIdsInput.value = selectedIds.join(','); // Set comma-separated string
        totalPriceInput.value = formatCurrency(totalPrice);

        // Show the modal
        $('#paymentModal').modal('show');
    });

    var filterNButton = document.getElementById('filterN');
        var filterYButton = document.getElementById('filterY');

        filterNButton.addEventListener('click', function () {
            filterRows('N');
        });

        filterYButton.addEventListener('click', function () {
            filterRows('Y');
        });

        function filterRows(status) {
            checkboxes.forEach(function (checkbox) {
                var rowIndex = checkbox.closest('tr').rowIndex;
                var rowStatus = document.querySelector('#example1').rows[rowIndex].cells[4].textContent;

                if (rowStatus === status) {
                    // Show rows with the specified status
                    document.querySelector('#example1').rows[rowIndex].style.display = '';
                } else {
                    // Hide rows with a different status
                    document.querySelector('#example1').rows[rowIndex].style.display = 'none';
                }
            });
        }
    function calculateTotalPrice() {
        var totalNetto = 0;
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                var rowIndex = checkbox.closest('tr').rowIndex;
                // Extract the "Netto" value from the corresponding column (adjust index as needed)
                var nettoValue = document.querySelector('#example1').rows[rowIndex].cells[3].textContent;
                // Extract numeric part and convert to a number
                var numericNetto = parseFloat(nettoValue.replace(/\D/g, ''));
                totalNetto += numericNetto;
            }
        });
        return totalNetto;
    }

    function getSelectedIds() {
        var selectedIds = [];
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                selectedIds.push(checkbox.value);
            }
        });
        return selectedIds;
    }

    // Helper function to format currency
    function formatCurrency(amount) {
        // Implement your logic for formatting currency, e.g., using Intl.NumberFormat
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
    }

    var filterNButton = document.getElementById('filterN');
        var filterYButton = document.getElementById('filterY');
        var filterAllButton = document.getElementById('filterAll');

        filterNButton.addEventListener('click', function () {
            filterTable('N');
        });

        filterYButton.addEventListener('click', function () {
            filterTable('Y');
        });

        filterAllButton.addEventListener('click', function () {
            filterTable('all');
        });

        function filterTable(status) {
            var rows = document.querySelector('#example1').querySelectorAll('tbody tr');

            rows.forEach(function (row) {
                var rowStatusIcon = row.cells[4].querySelector('i').className;

                if (status === 'all' || (status === 'N' && rowStatusIcon.includes('times')) || (status === 'Y' && rowStatusIcon.includes('check'))) {
                    // Show rows with the specified status or show all rows if 'all' is selected
                    row.style.display = '';
                } else {
                    // Hide rows with a different status
                    row.style.display = 'none';
                }
            });
        }
});
</script>

@endsection
