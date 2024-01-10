@extends('layouts.app2')

@section('title', 'Sub Akun')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">History {{ $subakun->nama }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="{{ route('subakuns.index', $subakun->id_akun) }}" title="Back"><button
                            class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"
                                aria-hidden="true"></i> Back</button></a>
                    <br />
                    <br />
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailSubAkuns as $detailSubAkun)
                            <tr class="clickable-row"  data-detail-id="{{ $detailSubAkun->id }}" data-toggle="collapse">
                                <td>{{ $detailSubAkun->tanggal }}</td>
                                <td>{{ $detailSubAkun->deskripsi }}</td>
                                <td>Rp. {{ number_format($detailSubAkun->debit, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($detailSubAkun->kredit, 0, ',', '.') }}</td>
                            </tr>
                            <tr id="detailsRow{{ $detailSubAkun->id }}" class="collapse">
                                <!-- Details will be appended here dynamically -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- Include Bootstrap JS library -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


<!-- ... Your HTML content ... -->

<style>
    .collapse {
        margin-top: 10px;
        border-radius: 5px;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        max-height: 0;
    }

    .collapse.show {
        max-height: 500px; /* Adjust the maximum height as needed */
        transition: max-height 0.3s ease-in;
    }

    .collapse-content {
        padding: 10px;
        background-color: #fff;
        color: #333;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function fetchDetailSubAkun(detailSubAkunId, clickedRow) {
            var url = '{{ route("fetch.detail.subakun", ["id" => ":detailSubAkunId"]) }}';
            url = url.replace(':detailSubAkunId', detailSubAkunId);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Detail SubAkun Data:', data);

                    var detailsRow = document.createElement('div');
                    detailsRow.className = 'collapse';

                    var contentDiv = document.createElement('div');
                    contentDiv.className = 'collapse-content';

                    data.forEach(element => {
                        var paragraph = document.createElement('p');
                        paragraph.textContent = 'Invoice ID: ' + element['id_invoice'];
                        contentDiv.appendChild(paragraph);
                    });

                    detailsRow.appendChild(contentDiv);

                    // Find existing details row if it exists
                    var existingDetailsRow = clickedRow.nextElementSibling;

                    // Remove existing details row if it exists
                    if (existingDetailsRow) {
                        existingDetailsRow.remove();
                    }

                    // Insert the details row after the clicked row
                    clickedRow.parentNode.insertBefore(detailsRow, clickedRow.nextSibling);

                    // Toggle the collapse state directly using Bootstrap API
                    $(detailsRow).collapse('toggle');
                })
                .catch(error => {
                    console.error('Error fetching detail subakun data:', error);
                });
        }

        // Add click event listener to all clickable rows
        document.querySelectorAll('.clickable-row').forEach(function (row) {
            row.addEventListener('click', function () {
                fetchDetailSubAkun(this.dataset.detailId, this);
            });
        });

        $('[data-toggle="collapse"]').collapse();
    });
</script>



@endsection
