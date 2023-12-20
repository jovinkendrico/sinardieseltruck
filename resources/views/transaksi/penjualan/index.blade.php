
@extends('layouts.app2')

@section('title','Penjualan')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Penjualan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <a href="{{ route('penjualan.create') }}" class="btn btn-success btn-sm" title="Add New Penjualan">
                  <i class="fa fa-plus" aria-hidden="true"></i> Add New
              </a>
              <br/>
              <br/>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Invoice</th>
                  <th>Tanggal</th>
                  <th>Customer</th>
                  <th>Plat</th>
                  <th>Netto</th>
                  <th>Status</th>
                  <th>Jatuh Tempo</th>
                  <th style="width: 20%">Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($penjualans as $penjualan)
                  <tr>
                      <td>{{$penjualan->id_invoice}}</td>
                      <td>{{$penjualan->tanggal}}</td>
                      <td>{{$penjualan['customer']['nama']}}</td>
                      <td>{{$penjualan['truk']['plat']}}</td>
                      <td>Rp. {{$penjualan->netto}}</td>
                      <td class="text-center">
                        @php
                            $iconClass = ($penjualan->status == 'N') ? 'fas fa-times text-danger' : 'fas fa-check text-success';
                            echo "<i class='$iconClass' ></i>";
                        @endphp
                      </td>
                      <td>{{$penjualan->jatuh_tempo}}</td>

                      <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('penjualan.show', $penjualan->id) }}">
                            <i class="fas fa-folder"></i> View
                        </a>

                        @if($penjualan->status == 'N')
                            <a class="btn btn-info btn-sm" href="{{ route('penjualan.edit', $penjualan->id) }}">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <a class="btn btn-danger btn-sm" href="{{ route('penjualan.delete', $penjualan->id) }}">
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
<div class="container-fluid">

@endsection
