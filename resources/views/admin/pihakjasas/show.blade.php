@extends('layouts.app2')

@section('title','Pihak Jasa')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pihak Jasa {{$pihakjasa->nama}} </h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Invoice</th>
                                    <th>Jasa</th>
                                    <th>Harga</th>
                                    <th>Paid</th>
                                    <th>Sisa Bayar</th>
                                    <th>Select</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailjasas as $detailjasa)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{\Carbon\Carbon::parse($detailjasa['penjualan']['tanggal'])->format('d-m-Y')}}</td>
                                    <td>{{$detailjasa['penjualan']['id_invoice']}}</td>
                                    <td>{{$detailjasa['jasa']['nama']}}</td>
                                    <td>Rp {{number_format($detailjasa->harga_modal, 2, '.', ',')}}</td>
                                    <td>Rp {{number_format($detailjasa->paid, 2, '.', ',')}}</td>
                                    <td>Rp {{number_format($detailjasa->harga_modal-$detailjasa->paid, 2, '.', ',')}}</td>
                                    <td class="text-center">
                                        @if($detailjasa->paid < $detailjasa->harga_modal)
                                        <input type="checkbox" class="checkbox" name="checkboxName[]" value="{{ $detailjasa->id }}">
                                        @else
                                        <input type="checkbox" class="checkbox" name="checkboxName[]" value="{{ $detailjasa->id }}" disabled>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button id="paidButton" class="btn btn-success btn-sm float-right" style="width: 100px; height: 40px;" disabled>
                            Paid
                            </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
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
                    <form method="POST" action="{{route('pihakjasa.bayar')}}" id="paymentJasa" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
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
                                <div class="form-group">
                                    <label for="totalBayar">Total Bayar:</label>
                                    <input type="text" class="form-control" id="totalBayar" name="totalBayar">

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
    <script src="/AdminLTE/plugins/jquery/jquery.min.js"></script>

    <script src="/AdminLTE/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/AdminLTE/plugins/jquery-validation/additional-methods.min.js"></script>
    <script>
        $(document).ready(function () {
      $('#paymentJasa').validate({
        rules: {
          totalPrice: {
            required: true,
          },
          subakuns: {
            required: true,
          },
          totalBayar: {
            required: true
          },
        },
        messages: {
          totalPrice: {
            required: "Please submit Total Price",
          },
          subakuns: {
            required: "Please submit Sub Akun",
          },
          totalBayar: "Please submit Total Bayar",
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
                var totalNetto = calculateTotalNetto();

                selectedIdsInput.value = selectedIds.join(','); // Set comma-separated string
                totalPriceInput.value = formatCurrency(totalNetto/100);

                // Show the modal
                $('#paymentModal').modal('show');
            });

            function calculateTotalNetto() {
                var totalNetto = 0;
                checkboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        var rowIndex = checkbox.closest('tr').rowIndex;
                        // Extract the "Netto" value from the corresponding column (adjust index as needed)
                        var nettoValue = document.querySelector('#example1').rows[rowIndex].cells[6].textContent;
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
        });
    </script>

@endsection
